<?php


namespace Modules\Payment\Services;


use Carbon\Carbon;
use ElfSundae\Laravel\Hashid\Facades\Hashid;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Log;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Entities\VariableSymbol;
use Modules\Payment\Repositories\DonationRepository;
use Modules\Payment\Repositories\PaymentRepository;
use Modules\UserManagement\Emails\DonationEmail;
use Modules\UserManagement\Services\GeneratedUserTokenService;
use Modules\UserManagement\Services\PortalUserService;
use Modules\UserManagement\Services\TrackingService;
use Modules\UserManagement\Services\UserPaymentOptionService;

class CardPayService
{
    private $mid;
    private $currency;
    private $securityKey;
    private $notificationEmail;
    protected $portalUserService;
    protected $trackingService;
    protected $paymentRepository;
    protected $donationRepository;
    private $client;

    public function __construct()
    {
        /*
         * Slovak bank - TatraBanka CardPay service
         * If you want to use TatraBanka CardPay service, you need to add your details in config
         * if you need, here is official documentation of CardPay service:
         * https://www.tatrabanka.sk/cardpay/CardPay_technicka_prirucka.pdf
         * If you want to use another card pay service, you can do it according to this implementation
         */
        $this->mid = config('cardpay.MID');
        $this->currency = config('cardpay.currency');
        $this->securityKey = config('cardpay.securityKey');
        $this->notificationEmail = config('cardpay.notificationEmail');
        $this->portalUserService = new PortalUserService();
        $this->paymentRepository = new PaymentRepository();
        $this->trackingService = new TrackingService();
        $this->donationRepository = new DonationRepository();
        $this->client = new Client();
    }

    public function init($data, $user, $uuid)
    {
        return $this->getCardPayLink($data['amount'], $user, $data->ip(), $uuid);
    }

    public function response($data, $uuid, $userId)
    {
        try {
            $params = [];

            $params['AMT'] = $data->query('AMT');
            $params['CURR'] = $data->query('CURR');
            $params['VS'] = $data->query('VS');
            $params['TXN'] = $data->query('TXN');
            $params['RES'] = $data->query('RES');
            $params['AC'] = $data->query('AC');
            $params['TRES'] = $data->query('TRES');
            $params['RC'] = $data->query('RC');
            $params['TID'] = $data->query('TID');
            $params['TIMESTAMP'] = $data->query('TIMESTAMP');
            $params['HMAC'] = $data->query('HMAC');
            $params['ECDSA_KEY'] = $data->query('ECDSA_KEY');
            $params['ECDSA'] = $data->query('ECDSA');
            $params['CFT_USER'] = $userId; // USER ID
            $params['CC'] = $data->query('CC'); // mask card number
            $params['RC'] = $data->query('RC'); // response code

            $paramsText = "";
            foreach ($params as $key => $param) {
                $paramsText .= $key . '=' . $param . '' . PHP_EOL;
            }

            Log::info('Donations payment response params (CARDPAY): ' . $paramsText);

            // Check if payment exists in database
            if ($this->paymentRepository->getByTransactionId($params['TID']) != null
                || $this->paymentRepository->getByUuid($uuid) != null) {
                return response()->json([
                    'error' => 'payment_exists',
                    'message' => 'Payment with this id already exist.'
                ], Response::HTTP_BAD_REQUEST);
            }

            if ($params['RES'] === 'OK') {
                if ($this->checkHmac($params, $params['HMAC']) && $this->checkEcdsa($params)) {

                    // Create payment record
                    $payment = $this->paymentRepository->create([
                        'transaction_id' => $params['TID'],
                        'uuid' => $uuid,
                        'variable_symbol' => $params['VS'],
                        'iban' => null,
                        'amount' => $params['AMT'],
                        'transfer_type' => 2, // card
                        'transaction_date' => Carbon::now(),
                        'created_by' => 'API'
                    ]);

                    // update donation or create new
                    $portalUserId = $this->portalUserService->getPortalUserIdByUserId(Hashid::decode($params['CFT_USER']));
                    if ($this->donationRepository->getByPaymentDetails($uuid, $portalUserId) == null) {
                        if ($this->donationRepository->getNotPairedByPortalUser($portalUserId) === null) {
                            // create new donation
                            $this->donationRepository->create([
                                'amount' => $params['AMT'],
                                'is_monthly_donation' => false,
                                'portal_user_id' => $portalUserId,
                                'widget_id' => 1,
                                'referral_widget_id' => 1,
                                'status' => 'processed',
                                'payment_id' => $payment->id,
                                'payment_method' => 2,
                                'tracking_show_id' => null,
                                'amount_initialize' => $params['AMT'],
                                'uuid' => $uuid,
                                'trans_date' => $payment->transaction_date
                            ]);
                        } else {
                            // update donation
                            $donation = $this->donationRepository->getNotPairedByPortalUser($portalUserId);
                            $this->donationRepository->update($donation->id, 'processed', 2, $payment->id, $params['AMT'], $payment->transaction_date);
                        }
                    } else {
                        // update donation
                        $donation = $this->donationRepository->getByPaymentDetails($uuid, $portalUserId);
                        $this->donationRepository->update($donation->id, 'processed', 2, $payment->id, $params['AMT'], $payment->transaction_date);
                    }

                    if ($params['CC'] !== null) {
                        $userPaymentOptionService = new UserPaymentOptionService();
                        $userPaymentOptionService->update(array(
                            'payment_card_number' => $params['CC']
                        ), $portalUserId);
                    }

                    // success payment email
                    $userId = Hashid::decode($params['CFT_USER']);
                    $user = $this->portalUserService->getUserByUserId($userId);

                    $generatedTokenService = new GeneratedUserTokenService();
                    $generatedToken = $generatedTokenService->create($userId);
                    Mail::to($user->email)->send(
                        new DonationEmail($params['AMT'], $params['VS'], null, 'donation', 'oneTime', 2, $generatedToken, $userId)
                    );

                    return response()->json([
                        'message' => 'Payment was successful. Thank you.',
                        'generated_token' => $generatedToken,
                        'user_id' => $userId,
                        'amount' => $params['AMT'],
                        'vs' => $params['VS']
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'error' => 'payment_not_valid',
                        'message' => 'Payment response is not valid or payment was already added.'
                    ], Response::HTTP_BAD_REQUEST);
                }

            } else {
                $userId = Hashid::decode($params['CFT_USER']);
                $user = $this->portalUserService->getUserByUserId($userId);
                $generatedTokenService = new GeneratedUserTokenService();
                $generatedToken = $generatedTokenService->create($user->id);
                // Email Payment Error
                Mail::to($user->email)->send(
                    new DonationEmail($params['AMT'], $params['VS'], null, 'donationNotSuccess', 'oneTime', 2, $generatedToken, $userId)
                );
                return response()->json([
                    'error' => 'payment_error',
                    'message' => 'Payment was failed.'
                ], Response::HTTP_BAD_REQUEST);
            }

        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    private function getCardPayLink($amount, $user, $ip, $uuid)
    {
        $url = Config::get('cardpay.EndPoint');
        $params = [];
        $params['MID'] = $this->mid;
        $params['AMT'] = number_format($amount, 2, '.', '');
        $params['CURR'] = $this->currency;
        $params['VS'] = $this->portalUserService->getVariableSymbol($user->id);
        $params['TXN'] = '';
        $params['RURL'] = $this->getRURL($uuid, $user->id);
        $params['IPC'] = $ip;
        $params['NAME'] = substr($user->email, 0, 29);
        $params['REM'] = $this->notificationEmail;
        $params['TPAY'] = 'N';
        $params['CID'] = '';
        $params['TIMESTAMP'] = Carbon::now('UTC')->format('dmYHis');
        $params['HMAC'] = $this->getRequestHmac($params);
        $params['AREDIR'] = 1;
        $params['LANG'] = 'sk';

        $paramsText = "";
        foreach ($params as $key => $param) {
            $paramsText .= $key . '=' . $param . '' . PHP_EOL;
        }
        Log::info('Payment request params: ' . $paramsText);
        $query = '?';
        foreach ($params as $key => $param) {
            if ($param != '') {
                $query .= $key . '=' . $param . '&';
            }
        }
        $query = trim($query, '&');

        return $url . $query;
    }


    /*
     * cardpay gateway return URL
     * url HAS NOT be with params.. all params must be separated via slashes
     * single page for thank you
     */
    private function getRURL($uuid, $user_id)
    {
        return env('CARDPAY_THANK_YOU_PAGE') . '/' . $uuid . '/' . Hashid::encode($user_id);
    }

    private function getRequestHmac($params)
    {
        $hmacString = $params['MID'] . $params['AMT'] . $params['CURR'] . $params['VS'] .
            $params['RURL'] . $params['IPC'] . $params['NAME'] . $params['REM'] . $params['TIMESTAMP'];
        Log::info('$hmacString: ' . $hmacString);
        $securityKeyHex = pack("H*", $this->securityKey);
        $signature = hash_hmac("sha256", $hmacString, $securityKeyHex);
        return $signature;
    }

    private function getResponseHmac($params)
    {
        $hmacString = $params['AMT'] . $params['CURR'] . $params['VS'] .
            $params['RES'] . $params['AC'] . $params['CC'] . $params['RC'] . $params['TID'] . $params['TIMESTAMP'];
        $securityKeyHex = pack("H*", $this->securityKey);
        $signature = hash_hmac("sha256", $hmacString, $securityKeyHex);
        return $signature;
    }

    private function checkHmac($params, $hmac)
    {
        $hmacSignature = $this->getResponseHmac($params);
        return $hmac === $hmacSignature;
    }

    private function checkEcdsa($params)
    {
        $ecdsaString = $params['AMT'] . $params['CURR'] . $params['VS'] . $params['RES'] .
            $params['AC'] . $params['CC'] . $params['RC'] . $params['TID'] . $params['TIMESTAMP'] . $params['HMAC'];

        // TODO: make it with guzzle
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://moja.tatrabanka.sk/e-commerce/ecdsa_keys.txt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $output = curl_exec($ch);
        curl_close($ch);

        $pKeyBlock = strpos($output, 'KEY_ID: ' . $params['ECDSA_KEY']);
        $pKeyValid = strpos($output, 'STATUS: VALID', $pKeyBlock);
        if ($pKeyValid > 15) {
            return false;
        }
        $pKeyStart = strpos($output, '-----BEGIN PUBLIC KEY-----', $pKeyBlock);
        $pKeyEnd = strpos($output, '-----END PUBLIC KEY-----', $pKeyBlock) + 24;
        $publicKey = substr($output, $pKeyStart, $pKeyEnd - $pKeyStart);

        return openssl_verify($ecdsaString, pack("H*", $params['ECDSA']), $publicKey, 'sha256');
    }

    public function validatePayments()
    {
        try {
            $validationUrl = 'https://moja.tatrabanka.sk/cgi-bin/e-commerce/start/cardpay_txn.jsp';
            // check all cardpay payments day before
            $from = Carbon::today()->subDay()->format('dmYHis'); // must be in this format for Tatrabanka
            $to = Carbon::today()->subSecond()->format('dmYHis'); // must be in this format for Tatrabanka

            // make HMAC
            $hmacString = $this->mid . $from . $to . 'OK';
            $securityKeyHex = pack("H*", $this->securityKey);
            $HMAC_SIGNATURE = hash_hmac("sha256", $hmacString, $securityKeyHex);

            $addedPayments = 0;


            $response = $this->client->request('GET',
                $validationUrl . '?' .
                'MID=' . $this->mid . '&' .
                'TS_FROM=' . $from . '&' .
                'TS_TO=' . $to . '&' .
                'STATUS=' . 'OK' . '&' .
                'HMAC=' . $HMAC_SIGNATURE, [
                    'headers' => ['Accept' => 'application/xml'],
                    'timeout' => 120
                ]);

            $xml = simplexml_load_string($response->getBody()->getContents());
            foreach ($xml->children()->transactions as $children) {
                foreach ($children->transaction as $transaction) {
                    $amount = $transaction->amount; // amount
                    $variable_symbol = $transaction->vs; // variable symbol
                    $transaction_id = $transaction->id; // transaction id
                    $transaction_date = Carbon::createFromFormat('dmYHis', $transaction->timestamp)->format('Y-m-d H:i:s');

                    // Get cardpay payment which has same variable symbol and transaction id
                    $payment = Payment::where('variable_symbol', $variable_symbol)
                        ->where('transaction_id', $transaction_id)
                        ->first();
                    if ($payment == null) {
                        // Create new payment
                        $payment = Payment::create([
                            'transaction_id' => $transaction_id,
                            'variable_symbol' => $variable_symbol,
                            'amount' => $amount,
                            'transfer_type' => 2,
                            'created_by' => 'API',
                            'transaction_date' => $transaction_date
                        ]);
                        $existedVariableSymbol = VariableSymbol::where('variable_symbol', $variable_symbol)->first();
                        // if variable symbol already exists in our database, pair payment with user, else payment will be in unpaired payments
                        if ($existedVariableSymbol) {
                            $paymentService = new PaymentService();
                            $paymentService->pairImportedPaymentWithUser($existedVariableSymbol->portal_user_id, $payment);
                        }
                        $addedPayments++;
                    }

                }
            }
        } catch (\Exception $exception) {
            Log::error('VALIDATE CARDPAY PAYMENTS ERROR -- ' . $exception->getMessage());
            return false;
        }

        Log::info('VALIDATE CARDPAY PAYMENTS SUCCESS -- count of added payments: ' . $addedPayments);
        return true;
    }
}
