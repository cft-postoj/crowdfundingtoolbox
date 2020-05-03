<?php


namespace Modules\Payment\Services;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Campaigns\Entities\UserDonationData;
use Modules\Payment\Repositories\PaymentRepository;
use Modules\UserManagement\Emails\DonationEmail;
use Modules\UserManagement\Services\GeneratedUserTokenService;
use Modules\UserManagement\Services\PortalUserService;
use Modules\UserManagement\Services\UserPaymentOptionService;
use Modules\UserManagement\Services\UserService;

class PaymentService
{
    static $releaseDate = '2019-10-29 21:00:00';

    protected $paymentRepository;
    protected $donationService;
    protected $portalUserService;
    protected $userPaymentOptionService;
    protected $variableSymbolService;

    private $transactionDateIndex;
    private $amountIndex;
    private $ibanIndex;
    private $variableSymbolIndex;
    private $specificSymbolIndex;
    private $constantSymbolIndex;
    private $payerReferenceIndex;
    private $paymentNoteIndex;
    private $transactionIdIndex;
    private $userService;


    // tatra banka iban for card pay
    const EXCLUDE_IBAN_FROM_PAIRING = 'SK701100000000123456789';

    public function __construct()
    {
        $this->paymentRepository = new PaymentRepository();
        $this->donationService = new DonationService();
        $this->portalUserService = new PortalUserService();
        $this->userPaymentOptionService = new UserPaymentOptionService();
        $this->variableSymbolService = new VariableSymbolService();
        $this->userService = new UserService();
    }

    public function create($request)
    {
        $valid = validator($request->only(
            'transaction_id',
            'variable_symbol',
            'iban',
            'amount',
            'transfer_type',
            'transaction_date',
            'created_by'
        ), [
            'transaction_id' => 'required|string|max:255',
            'variable_symbol' => 'bigInteger|max:255',
            'iban' => 'string|max:255',
            'amount' => 'required|decimal|max:255',
            'transfer_type' => 'required|integer',
            'transaction_date' => 'required|timestamp',
            'created_by' => 'required|string'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], 400);
            return $jsonError;
        }

        try {
            $this->createPayment($request);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Successfully created payment.'
        ], Response::HTTP_CRETED);

    }

    public function createPayment($request)
    {
        $payment = $this->paymentRepository->create($request);
        return $payment;
    }

    public function update($request)
    {

    }

    public function getUnpairedPayments()
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 2000);
        return response()->json(
            $this->paymentRepository->getUnpairedPayments(),
            Response::HTTP_OK);
    }

    public function getPayment($id)
    {
        return $this->paymentRepository->get($id);
    }

    public function pairPaymentToUser($request)
    {
        $valid = validator($request->only(
            'user_id',
            'iban'
        ), [
            'user_id' => 'required|integer',
            'iban' => 'required|string'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], 400);
            return $jsonError;
        }

        $modified = $request->all();
        $modified['update_iban'] = true;

        try {
            $this->pairPaymentToUserCore($modified);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => 'Successfully paired payment to user.'
        ], Response::HTTP_OK);
    }

    public function pairPaymentToUserCore($request, $payments = null)
    {
        if ($payments) {
            $unpairedPayments = $payments;
        } else {
            $unpairedPayments = $this->paymentRepository->getUnpairedPaymentsDesc();
        }
        $portal_user_id = $this->portalUserService->getPortalUserIdByUserId($request['user_id']);
        $donations = $this->donationService->getDonationsByPortalUserId($portal_user_id);
        foreach ($unpairedPayments as $unPay) {
            if ($unPay->iban === $request['iban']) {
                if ($donations->isEmpty()) {
                    $shouldBeMonthlyPayment = $this->donationService->shouldBeMonthlyDonation($portal_user_id, Carbon::parse($unPay->transaction_date),
                        $unPay->amount);
                    $donationRequest = array(
                        'amount' => $unPay->amount,
                        'is_monthly_donation' => $shouldBeMonthlyPayment['monthly'],
                        'portal_user_id' => $portal_user_id,
                        'widget_id' => 1,
                        'payment_method' => $unPay->transfer_type,
                        'status' => 'processed',
                        'payment_id' => $unPay->id,
                        'trans_date' => $unPay->transaction_date
                    );
                    if ($shouldBeMonthlyPayment['numberOfOneTimePayments'] != 0) {
                        $this->donationService->updateMonthlyStatusRetrospective($portal_user_id, Carbon::parse($unPay->transaction_date), $unPay->amount);
                    }
                    $this->donationService->create($donationRequest);
                } else {
                    $paired = false;
                    $isPaymentIdNull = false;
                    foreach ($donations as $donation) {
                        $isPaymentIdNull = false;
                        // find first donation with same amount
                        if ($donation->payment_id == null) {
                            $isPaymentIdNull = true;
                        }
                        if (($donation->amount == $unPay->amount) && $isPaymentIdNull && !$paired) {
                            $paired = true;
                            $this->donationService->updatePaymentIdAndAmount(array(
                                'payment_id' => $unPay->id,
                                'amount' => $unPay->amount,
                                'status' => 'processed',
                                'trans_date' => $unPay->transaction_date
                            ), $donation->id);
                        }
                    }
                    if (!$paired) {
                        // pair to last donation with correct amount
                        if ($isPaymentIdNull) {
                            foreach ($donations as $donation) {
                                // find first donation with same amount
                                $isPaymentIdNull = false;
                                if ($donation->payment_id == null) {
                                    $isPaymentIdNull = true;
                                }
                                if ($isPaymentIdNull) {
                                    $this->donationService->updatePaymentIdAndAmount(array(
                                        'payment_id' => $unPay->id,
                                        'amount' => $unPay->amount,
                                        'status' => 'processed',
                                        'trans_date' => $unPay->transaction_date
                                    ), $donation->id);
                                    break;
                                }
                            }
                        } else {
                            $shouldBeMonthlyPayment = $this->donationService->shouldBeMonthlyDonation($portal_user_id, Carbon::parse($unPay->transaction_date), $unPay->amount);
                            $donationRequest = array(
                                'amount' => $unPay->amount,
                                'is_monthly_donation' => $shouldBeMonthlyPayment['monthly'],
                                'portal_user_id' => $portal_user_id,
                                'widget_id' => 1,
                                'payment_method' => $unPay->transfer_type,
                                'status' => 'processed',
                                'payment_id' => $unPay->id,
                                'trans_date' => $unPay->transaction_date
                            );
                            if ($shouldBeMonthlyPayment['numberOfOneTimePayments'] != 0) {
                                $this->donationService->updateMonthlyStatusRetrospective($portal_user_id, Carbon::parse($unPay->transaction_date), $unPay->amount);
                            }
                            $this->donationService->create($donationRequest);
                        }
                    }
                }
                if (key_exists('update_iban', $request) && $request['update_iban']) {
                    // update others payment options to prevent duplicity of ibans
                    $paymentOptions = $this->userPaymentOptionService->getOptionsByIban($request['iban']);
                    foreach ($paymentOptions as $paymentOption) {
                        // skip owner of this vs from removing
                        if ($paymentOption->portal_user_id !== $portal_user_id) {
                            $paymentOption->bank_account_number = '';
                            $paymentOption->pairing_type = 'variable_symbol';
                            $paymentOption->update();
                        }
                    }
                    // ADD NEW IBAN TO PORTAL USER
                    $req = array(
                        'bank_account_number' => $request['iban'],
                        'pairing_type' => 'iban'
                    );
                    $this->userPaymentOptionService->update($req, $portal_user_id);
                }
            }
        }
    }

    public function pairPaymentsViaIban($request)
    {
        $valid = validator($request->only(
            'payment_ids'
        ), [
            'payment_ids' => 'required|array'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], 400);
            return $jsonError;
        }

        $allIds = sizeof($request['payment_ids']);
        $successPaired = 0;

        try {
            foreach ($request['payment_ids'] as $payment_id) {
                $paymentData = $this->paymentRepository->get($payment_id);
                $portalUsers = $this->portalUserService->getAll();
                foreach ($portalUsers as $user) {
                    if ($user->portalUser->userPaymentOptions !== null) {
                        if ($paymentData->iban === $user->portalUser->userPaymentOptions->bank_account_number) {
                            $donations = $this->donationService->getDonationsByUserId($user->id);
                            if ($donations->isEmpty()) {
                                $donationRequest = array(
                                    'amount' => $paymentData->amount,
                                    'is_monthly_donation' => false,
                                    'portal_user_id' => $user->portalUser->id,
                                    'widget_id' => 1,
                                    'payment_method' => $paymentData->transfer_type,
                                    'status' => 'processed',
                                    'payment_id' => $paymentData->id,
                                    'trans_date' => $paymentData->transaction_date
                                );
                                $this->donationService->create($donationRequest);
                                $successPaired++;
                            } else {
                                $paired = false;
                                $isPaymentIdNull = false;
                                foreach ($donations as $donation) {
                                    // find first donation with same amount
                                    if ($donation->payment_id == null) {
                                        $isPaymentIdNull = true;
                                    }
                                    if (($donation->amount == $paymentData->amount) && $isPaymentIdNull && !$paired) {
                                        $paired = true;
                                        $this->donationService->updatePaymentIdAndAmount(array(
                                            'payment_id' => $request['payment_id'],
                                            'amount' => $paymentData->amount,
                                            'status' => 'processed',
                                            'trans_date' => $paymentData->transaction_date
                                        ), $donation->id);
                                        $successPaired++;
                                    }
                                }
                                if (!$paired) {
                                    // pair to last donation with correct amount
                                    if ($isPaymentIdNull) {
                                        foreach ($donations as $donation) {
                                            // find first donation with same amount
                                            if ($donation->payment_id == null) {
                                                $isPaymentIdNull = true;
                                            }
                                            if ($isPaymentIdNull) {
                                                $this->donationService->updatePaymentIdAndAmount(array(
                                                    'payment_id' => $request['payment_id'],
                                                    'amount' => $paymentData->amount,
                                                    'status' => 'processed',
                                                    'trans_date' => $paymentData->transaction_date
                                                ), $donation->id);
                                                $successPaired++;
                                            }
                                        }
                                    } else {
                                        $shouldBeMonthlyPayment = $this->donationService->shouldBeMonthlyDonation($paymentData, Carbon::parse($paymentData->transaction_date), $paymentData->amount);
                                        $donationRequest = array(
                                            'amount' => $paymentData->amount,
                                            'is_monthly_donation' => $shouldBeMonthlyPayment['monthly'],
                                            'portal_user_id' => $user->portalUser->id,
                                            'widget_id' => 1,
                                            'payment_method' => $paymentData->transfer_type,
                                            'status' => 'processed',
                                            'payment_id' => $paymentData->id,
                                            'trans_date' => $paymentData->transaction_date
                                        );
                                        if ($shouldBeMonthlyPayment['numberOfOneTimePayments'] != 0) {
                                            $this->donationService->updateMonthlyStatusRetrospective($user->portalUser->id, Carbon::parse($paymentData->transaction_date), $paymentData->amount);
                                        }
                                        $this->donationService->create($donationRequest);
                                        $successPaired++;
                                    }
                                }
                            }
                            // ADD NEW IBAN TO PORTAL USER
                            $request = array(
                                'bank_account_number' => $paymentData->iban,
                                'pairing_type' => 'iban'
                            );
                            $this->userPaymentOptionService->update($request, $user->portalUser->id);
                        }
                    }
                }
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($successPaired !== $allIds) {
            $message = 'Not every user has in his account included IBAN, which is used in these payments. <br /><b>PAIRING STATUS:</b> ';
            if ($successPaired === 1) {
                $successMessage = $successPaired . ' payment was ';
            } else {
                $successMessage = $successPaired . ' payments were ';
            }
            if ($allIds - $successPaired === 1) {
                $notSuccessMessage = ($allIds - $successPaired) . ' payment was ';
            } else {
                $notSuccessMessage = ($allIds - $successPaired) . ' payments were ';
            }
            $message .= $successMessage . 'successfully paired and ' . $notSuccessMessage . ' not paired.';
        } else {
            $message = '<b>PAIRING STATUS:</b> All payments were successfully paired!';
        }
        $status = 'success';
        if ($allIds - $successPaired !== 0) {
            $status = 'warning';
        }

        return response()->json([
            'message' => $message,
            'status' => $status
        ], Response::HTTP_CREATED);

    }

    private function getUserWithVariableSymbolOrIban($variable_symbol, $iban)
    {
        $portal_user_id = null;
        if ($variable_symbol != null) {
            $portal_user_id = $this->variableSymbolService->getPortalUserByVariableSymbol($variable_symbol);
        }
        $paymentOption = $this->userPaymentOptionService->getByIban($iban);
        if ($paymentOption !== null) {
            if ($paymentOption->pairing_type === 'iban') {
                $portal_user_id = $paymentOption->portal_user_id;
            }
        }
        return $portal_user_id;
    }

    public function pairImportedPaymentWithUser($portal_user_id, $payment)
    {
        try {
            $donations = $this->donationService->getDonationsByPortalUserId($portal_user_id);
            //portal user don't have any donations
            if ($donations == null) {
                $shouldBeMonthlyPayment = $this->donationService->shouldBeMonthlyDonation($portal_user_id, Carbon::parse($payment->transaction_date), $payment->amount);
                $donationRequest = array(
                    'amount' => $payment->amount,
                    'amount_initialized' => null,
                    'is_monthly_donation' => $shouldBeMonthlyPayment['monthly'],
                    'portal_user_id' => $portal_user_id,
                    'widget_id' => null,
                    'payment_method' => $payment->transfer_type,
                    'status' => 'processed',
                    'payment_id' => $payment->id,
                    'trans_date' => $payment->transaction_date
                );
                $this->donationService->create($donationRequest);
            } else {
                //trying to pair with created donation
                $paired = false;
                $isPaymentIdNull = false;
                foreach ($donations as $donation) {
                    // find first donation with same amount
                    if ($donation->payment_id == null) {
                        $isPaymentIdNull = true;
                    } else {
                        $isPaymentIdNull = false;
                    }
                    if (($donation->amount == $payment->amount) && $isPaymentIdNull && !$paired) {
                        $paired = true;
                        $this->donationService->updatePaymentIdAndAmount(array(
                            'payment_id' => $payment->id,
                            'amount' => $payment->amount,
                            'payment_method' => $payment->transfer_type,
                            'status' => 'processed',
                            'trans_date' => $payment->transaction_date
                        ), $donation->id);

                    }
                }
                if (!$paired) {
                    // pair to last donation with correct amount
                    if ($isPaymentIdNull) {
                        foreach ($donations as $donation) {
                            // find first donation with same amount
                            if ($donation->payment_id == null) {
                                $isPaymentIdNull = true;
                            } else {
                                $isPaymentIdNull = false;
                            }
                            if ($isPaymentIdNull) {
                                $this->donationService->updatePaymentIdAndAmount(array(
                                    'payment_id' => $payment->id,
                                    'amount' => $payment->amount,
                                    'payment_method' => $payment->transfer_type,
                                    'status' => 'processed',
                                    'trans_date' => $payment->transaction_date
                                ), $donation->id);
                            }
                        }
                    } else {
                        $shouldBeMonthlyPayment = $this->donationService->shouldBeMonthlyDonation($portal_user_id, Carbon::parse($payment->transaction_date), $payment->amount);
                        $lastMonthlyDonation = $this->donationService->lastBankTransferMonthlyDonation($portal_user_id);
                        $donationRequest = array(
                            'amount' => $payment->amount,
                            'amount_initialized' => null,
                            'is_monthly_donation' => $shouldBeMonthlyPayment['monthly'],
                            'portal_user_id' => $portal_user_id,
                            'widget_id' => $lastMonthlyDonation === null ? null : $lastMonthlyDonation->widget_id,
                            'referral_widget_id' => $lastMonthlyDonation === null ? null : $lastMonthlyDonation->referral_widget_id,
                            'tracking_show_id' => $lastMonthlyDonation === null ? null : $lastMonthlyDonation->tracking_show_id,
                            'payment_method' => $payment->transfer_type,
                            'status' => 'processed',
                            'payment_id' => $payment->id,
                            'trans_date' => $payment->transaction_date
                        );
                        if ($shouldBeMonthlyPayment['numberOfOneTimePayments'] != 0) {
                            $this->donationService->updateMonthlyStatusRetrospective($portal_user_id, Carbon::parse($payment->transaction_date), $payment->amount);
                        }
                        $this->donationService->create($donationRequest);
                    }

                    $generatedTokenService = new GeneratedUserTokenService();
                    $actualUserId = $this->portalUserService->getUserId($portal_user_id);
                    $userService = new UserService();
                    $actualUserEmail = $userService->getById($actualUserId)->email;
                    $generatedToken = $generatedTokenService->create($actualUserId);
                    $shouldBeMonthlyPayment = $this->donationService->shouldBeMonthlyDonation($portal_user_id, Carbon::parse($payment->transaction_date), $payment->amount);
                    Mail::to($actualUserEmail)->send(
                        new DonationEmail($payment->amount, $payment->variable_symbol, null, 'donation', ($shouldBeMonthlyPayment['monthly']) ? 'monthly' : 'oneTime', $payment->transfer_type, $generatedToken, $actualUserId)
                    );
                }
            }
            // ADD NEW IBAN TO PORTAL USER
            if ($payment->iban !== null) {
                $req = array(
                    'bank_account_number' => $payment->iban,
                    'pairing_type' => 'iban'
                );
                $this->userPaymentOptionService->update($req, $portal_user_id);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Successfully paired payment to user.'
        ], Response::HTTP_OK);
    }

    public function getPayments($from, $to, $monthly, $pageSize, $filterColumns)
    {
        return $this->paymentRepository->getPayments($from, $to, $monthly, $pageSize, $filterColumns);
    }


    public function getPaymentTotalGroupMonthly($from, $to)
    {
        return $this->paymentRepository->getPaymentTotalGroupMonthly($from, $to);
    }

    public function checkUplodedFileType()
    {
        $allowed = array('csv');
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $tmpname = $_FILES['file']['tmp_name'];
        $filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed) || finfo_file($finfo, $tmpname) !== 'text/plain') {
            return response()->json([
                'error' => 'Type of choosed file is not allowed. Only .csv files are allowed.'
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => 'Correct file type.'
        ], Response::HTTP_OK);
    }


    /*
     * Method for pairing bank account name to all payments (from business banking CSV export).
     */
    public function pairAccountNameToPayments()
    {
        try {
            ini_set('memory_limit', '2048M');
            ini_set('max_execution_time', 2000);
            $tmpName = $_FILES['file']['tmp_name'];
            $defaultEncoding = file($tmpName);

            $UTF8Encoding = array();
            $wrongFormatException = 0;

            foreach ($defaultEncoding as $row) {
                try {
                    if (strlen(iconv("UTF-8", 'utf-8//TRANSLIT', $row)) > 50) {
                        array_push($UTF8Encoding, iconv("UTF-8", 'utf-8//TRANSLIT', $row));
                    }
                } catch (\InvalidArgumentException $exception) {
                    $wrongFormatException++;
                    array_push($UTF8Encoding, $row);
                }
            }

            $csvAsArray = array();
            foreach ($UTF8Encoding as $row) {
                array_push($csvAsArray, explode(';', $row));
            }

            $accountNameIndex = 6; // Name of account (in Tatrabanka export)
            $accountNumberIndex = 4; // Bank account number (in Tatrabanka export)

            $counter = 0;
            $updated = 0;
            foreach ($csvAsArray as $csv) {
                Log::info('account-data: ' . json_encode($csv));
                Log::info('account number: ' . $csv[$accountNumberIndex] . ', account name: ' . $csv[$accountNameIndex]);
                if ($counter > 0) { // skip first row (header)
                    $accountNumber = $csv[$accountNumberIndex];
                    $accountName = $csv[$accountNameIndex];

                    if ($this->paymentRepository->updateByAccountNumber($accountNumber, $accountName)) {
                        $updated++;
                    }
                }
                $counter++;
            }


        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getTrace()
            ], Response::HTTP_BAD_REQUEST);
        }

        $message = '<b>CSV import was successfully done.</b><br><u>STATUS:</u><br>';
        $message .= 'Paired account name to payments: <b>' . $updated . '</b><br>';
        if ($wrongFormatException !== 0) {
            $message .= $wrongFormatException . ' payments have some difficulties with encoding.';
        }
        return response()->json([
            'message' => $message
        ], Response::HTTP_CREATED);

    }


    public function importPayments()
    {
        try {
            ini_set('memory_limit', '2048M');
            ini_set('max_execution_time', 2000);
            $tmpName = $_FILES['file']['tmp_name'];
            $defaultEncoding = file($tmpName);

            $UTF8Encoding = array();
            $wrongFormatException = 0;

            foreach ($defaultEncoding as $row) {
                try {
                    array_push($UTF8Encoding, iconv("Windows-1250", "UTF-8", $row));
                } catch (\InvalidArgumentException $exception) {
                    $wrongFormatException++;
                    array_push($UTF8Encoding, $row);
                }
            }

            $csvAsArray = array_map('str_getcsv', $UTF8Encoding);

            // bank transfer, card pay, pay by square, google pay, apple pay
            $transferTypes = [1, 2, 3, 4, 5];
            $cardPayIdentificator = 'CP ';


            // STATICALY DEFINED SHAPE OF IMPORT PAYMENTS - uses index from zero. Default table (Slovak standard bank export) looks like this:
            // ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            // | Processing date | Settlement date | Sum | Currency | Type (credit/debet) | Prefix | Account number | Bank code | IBAN | Variable symbol | Specific symbol | Constant symbol | Payer reference | Information | Description |
            // ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

            $this->transactionDateIndex = 1; // Settlement date
            $this->amountIndex = 2; // Sum
            $this->ibanIndex = 8; // Iban
            $this->variableSymbolIndex = 9; // Variable symbol
            $this->specificSymbolIndex = 10; // Specific symbol
            $this->constantSymbolIndex = 11; // Constant symbol
            $this->payerReferenceIndex = 12; // Payer reference
            $this->paymentNoteIndex = 13; // Information
            $this->transactionIdIndex = 14; // Description (for example card pay information)

            $createdBy = 'import';

            if (!$this->isCorrectCsvFormat($csvAsArray)) {
                return response()->json([
                    'error' => 'CSV file has not correct format. Please, check your file with our documentation.'
                ], Response::HTTP_BAD_REQUEST);
            }


            $counter = 0;
            $countOfSuccessfullyCreatedRecords = 0;
            $countOfPairedPayments = 0;
            $doubleInserted = [];
            foreach ($csvAsArray as $key => $csv) {
                if ($counter > 0) {
                    if ((strpos($csv[$this->transactionIdIndex], $cardPayIdentificator) !== false)) {
                        if (Carbon::parse($csv[$this->transactionDateIndex])->isAfter(
                            Carbon::createFromFormat('Y-m-d H:i:s', self::$releaseDate))) {
                            Log::info('Payment not imported because is card pay payment with transaction date after release date.
                          Every CP payments should be handled directly during processing. Details of skipped payment: ' .
                                json_encode($csv));
                            $counter++;
                            continue;
                        }
                    }
                    // skip first row (header)
                    $length = $this->countOfNewRecords($csv, $this->checkSameRecords($csv, $csvAsArray));
                    if (array_search($csv, $doubleInserted) === false) {
                        for ($i = 0; $i < $length; $i++) {
                            // create record in payments table
                            $csvRequest = array(
                                'transaction_id' => $csv[$this->transactionIdIndex],
                                'iban' => $csv[$this->ibanIndex],
                                'amount' => (float)number_format((float)str_replace(',', '.', $csv[$this->amountIndex]), 2, '.', ''),
                                'created_by' => $createdBy,
                                'transfer_type' => (substr($csv[$this->transactionIdIndex], 0, 3) === $cardPayIdentificator) ?
                                    $transferTypes[1] : ((strpos(strtolower($csv[$this->paymentNoteIndex]), 'pay-by-square') !== false) ?
                                        $transferTypes[2] : $transferTypes[0]), //pay-by-square identificatior is in payment description
                                'variable_symbol' => (int)$csv[$this->variableSymbolIndex],
                                'transaction_date' => date('Y-m-d H:i:s', strtotime($csv[$this->transactionDateIndex])),
                                'payment_notes' => $csv[$this->paymentNoteIndex],
                                'payer_reference' => $csv[$this->payerReferenceIndex],
                                'specific_symbol' => (int)$csv[$this->specificSymbolIndex],
                                'constant_symbol' => (int)$csv[$this->constantSymbolIndex]
                            );
                            $currentPaymentRecord = $this->paymentRepository->create($csvRequest);
                            $countOfSuccessfullyCreatedRecords++;

                            $portal_user_id = $this->getUserWithVariableSymbolOrIban(trim($csv[$this->variableSymbolIndex]), $csv[$this->ibanIndex]);
                            if ($portal_user_id !== null) {
                                $this->pairImportedPaymentWithUser($portal_user_id, $currentPaymentRecord);
                                $countOfPairedPayments++;
                            }
                        }
                    }
                    if ($length !== 1) {
                        array_push($doubleInserted, $csv);
                    }
                }
                $counter++;
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        //sub 1 from counter to remove 1 row from counting
        $counter--;
        $message = '<b>CSV import was successfully done.</b><br><u>STATUS:</u><br>';
        $message .= 'Import records: <b>' . $counter . '</b><br>';
        $message .= 'Imported payments: <b>' . $countOfSuccessfullyCreatedRecords . '</b><br>';
        $message .= ($counter - $countOfSuccessfullyCreatedRecords) . ' records already exist in database.<br><br><u>Pairing status:</u><br>';
        $message .= $countOfPairedPayments . ' paired payments and ' . ($countOfSuccessfullyCreatedRecords - $countOfPairedPayments) . ' unpaired payments.<br>';
        if ($wrongFormatException !== 0) {
            $message .= $wrongFormatException . ' payments have some difficulties with encoding.';
        }
        return response()->json([
            'message' => $message
        ], Response::HTTP_CREATED);
    }

    // check if csv consists of correct count of columns and check if some of required value is not null (before importing)
    private function isCorrectCsvFormat($csv)
    {
        if (sizeof($csv[0]) !== 15) { //default count of csv cols
            return false;
        }
        // variable symbol can be null
        $count = 0;
        foreach ($csv as $c) {
            if ($count > 0):
                if ($c[$this->transactionIdIndex] === null ||
                    $c[$this->ibanIndex] === null ||
                    $c[$this->transactionDateIndex] === null ||
                    (float)number_format((float)$c[$this->amountIndex], 2, '.', '') === 0) {
                    return false;
                }
            endif;
            $count++;
        }
        return true;
    }

    // function which check all records in csv and find matches with row (for example, if some donor made donation more time per one day)
    private function checkSameRecords($row, $csvAsArray)
    {
        $counter = 0;
        foreach ($csvAsArray as $key => $csv) {
            if ($key === 0) {
                continue;
            }
            $csvClone = $csv;
            $rowClone = $row;
            $csvDate = Carbon::parse($csvClone[$this->transactionDateIndex]);
            $rowDate = Carbon::parse($rowClone[$this->transactionDateIndex]);
            $csvClone[$this->transactionDateIndex] = null;
            $rowClone[$this->transactionDateIndex] = null;
            if ($csv === $row && Carbon::parse($rowDate)->isBetween($csvDate->clone()->subDays(2), $csvDate)) {
                $counter++;
            }
        }
        return $counter;
    }

    // function which check, if payments table consists of some rows from csv
    private function countOfNewRecords($row, $timesOccurrence)
    {
        $occurrences = 0;
        $payments = $this->paymentRepository->getPaymentsFromIban($row[$this->ibanIndex]);
        foreach ($payments as $p) {
            if ($this->isSamePayments($p, $row)) {
                $occurrences++;
            }
        }
        $countOfNewRecords = $timesOccurrence - $occurrences;
        if ($countOfNewRecords < 0) {
            $countOfNewRecords = 0;
        }

        return $countOfNewRecords;
    }

    private function isSamePayments($database, $csv)
    {
        // remove all diacritical mark to trying to match, that removes all diacritic
        $table = array(
            'Á' => 'A', 'Ä' => 'A', 'á' => 'a', 'ä' => 'a',
            'Č' => 'C', 'č' => 'c',
            'Ď' => 'D', 'ď' => 'd',
            'É' => 'E', 'é' => 'e', 'Ě' => 'E', 'ě' => 'e',
            'Í' => 'I', 'í' => 'i',
            'Ľ' => 'L', 'ľ' => 'l', 'Ĺ' => 'L', 'ĺ' => 'l',
            'Ň' => 'N', 'ň' => 'n',
            'Ó' => 'O', 'ó' => 'o', 'Ô' => 'O', 'ô' => 'o', 'Ö' => 'o', 'ö' => 'o',
            'Š' => 'S', 'š' => 's',
            'Ŕ' => 'R', 'ŕ' => 'r', 'Ř' => 'R', 'ř' => 'r',
            'Ť' => 'T', 'ť' => 't',
            'Ú' => 'U', 'ú' => 'u', 'Ů' => 'u', 'ů' => 'u',
            'Ý' => 'Y', 'ý' => 'y',
            'Ž' => 'Z', 'ž' => 'z',
        );

        $csvTransactionDate = Carbon::parse($csv[$this->transactionDateIndex]);

        return $database->iban === $csv[$this->ibanIndex]
            && (int)$database->variable_symbol === (int)$csv[$this->variableSymbolIndex]
            && (int)$database->specific_symbol === (int)$csv[$this->specificSymbolIndex]
            && (int)$database->constant_symbol === (int)$csv[$this->constantSymbolIndex]
            && (str_replace(' ', '', $database->payment_notes) === str_replace(' ', '', $csv[$this->paymentNoteIndex]) ||
                str_replace(' ', '', $database->payment_notes) === str_replace(' ', '', (strtr($csv[$this->paymentNoteIndex], $table))))
            && $database->amount === (float)number_format((float)str_replace(',', '.', $csv[$this->amountIndex]), 2, '.', '')
            && Carbon::createFromFormat('Y-m-d H:i:s', $database->transaction_date)->isBetween(
                $csvTransactionDate->copy()->subDays(2), $csvTransactionDate->copy()->addDay()

            );
    }

    public function getByTransactionId($transactionId)
    {
        return $this->paymentRepository->getByTransactionId($transactionId);
    }

    public function importUsersIbans()
    {
        //parse csv to array
        $tmpName = $_FILES['file']['tmp_name'];
        $csvAsArray = array_map('str_getcsv', file($tmpName));
        $emailIbanPairs = array();
        for ($i = 1; $i < count($csvAsArray); $i++) {
            $emailIbanPair = $this->ownArrayCombine($csvAsArray[0], $csvAsArray[$i]);
            $emailIbanPair['email'] = str_lower($emailIbanPair['email']);
            array_push($emailIbanPairs, $emailIbanPair);
        }

        usort($emailIbanPairs, function ($a, $b) {
            return strtotime($a["updated_at"]) - strtotime($b["updated_at"]);
        });

        foreach ($emailIbanPairs as $emailIbanPair) {
            if ($emailIbanPair['iban'] !== null && $emailIbanPair['iban'] !== '\N') {
                $user = $this->userService->getUserByEmailWithUserPaymentOptions($emailIbanPair['email']);
                $userPaymentOptions = $user->portalUser->userPaymentOptions;
                $userPaymentOptions->bank_account_number = $emailIbanPair['iban'];
                $userPaymentOptions->save();
                $this->pairPaymentToUserCore(['user_id' => $user->id, 'iban' => $emailIbanPair['iban']]);
            }
        }
    }


    //safe version of array_combine (if second there is more $keys then $values, insert null into those $keys)
    private function ownArrayCombine($keys, $values)
    {
        $result = array();
        foreach ($keys as $index => $key) {
            $result[$key] = count($values) > $index ? $values[$index] : null;
        }
        return $result;
    }


    /*
     * Try to pair all unpaired payments via variable symbols or iban.
     */
    public function bulkPairUnpairedPayments()
    {
        try {
            $unpairedPayments = $this->paymentRepository->getAscUnpairedPayments();

            $countOfPaired = 0;
            $responsePaired = array();

            foreach ($unpairedPayments as $unpairedPayment) {
                $portal_user_id = $this->isValidVariableSymbol($unpairedPayment->variable_symbol);

                // if user not exists with IBAN, check if portal user exists with IBAN
                if ($portal_user_id === null) {
                    $portal_user_id = $this->isValidIban($unpairedPayment->iban, $unpairedPayment->transaction_id);
                }

                // if portal user id is null for iban and var symbol, break
                if ($portal_user_id === null) {
                    continue;
                } else {
                    // All donations for portal user
                    $donations = $this->donationService->getAscDonationsByPortalUserId($portal_user_id);

                    $isPaired = false;
                    foreach ($donations as $donation) {
                        if (!$isPaired && $donation->payment_id == null) {
                            // try to pair if donation has payment_id == null
                            $isPaired = true;
                            $this->donationService->updatePaymentIdAndAmount(array(
                                'payment_id' => $unpairedPayment->id,
                                'amount' => $unpairedPayment->amount,
                                'status' => 'processed'
                            ), $donation->id);
                            $countOfPaired++;
                            array_push($responsePaired, array(
                                'donation_id' => $donation->id,
                                'payment_id' => $unpairedPayment->id,
                                'portal_user_id' => $portal_user_id,
                                'amount' => $unpairedPayment->amount
                            ));
                        }
                        /*
                            * check if same payment_id is not assign to more donations
                            */
                        $anotherDonationWithSamePayment = $this->donationService->anotherDonationsWithSamePayment($donation->payment_id);
                        if ($anotherDonationWithSamePayment !== null && !$isPaired) {
                            $isPaired = true;
                            $this->donationService->updatePaymentIdAndAmount(array(
                                'payment_id' => $unpairedPayment->id,
                                'amount' => $unpairedPayment->amount,
                                'status' => 'processed'
                            ), $anotherDonationWithSamePayment->id);
                            $countOfPaired++;
                            array_push($responsePaired, array(
                                'donation_id' => $donation->id,
                                'payment_id' => $unpairedPayment->id,
                                'portal_user_id' => $portal_user_id,
                                'amount' => $unpairedPayment->amount
                            ));
                        }
                    }
                }
            }
            Log::INFO('BULK PAIR UNPAIRED PAYMENTS --- \n COUNT PAIRED: ' . $countOfPaired . '\n\n PAIRED DATA: ' . json_encode($responsePaired));

            // Remove payment_id from all donations, which has status initialized
            $countPaymentId = 0;
            foreach ($this->donationService->allInitializedOlderThenDayWithPaymentId() as $donation) {
                $this->donationService->updatePaymentIdAndAmount(array(
                    'payment_id' => null
                ), $donation->id);
                $countPaymentId++;
            }

            Log::INFO('BULK PAIR -- count of initialized donations with payment_id: ' . $countPaymentId);

            // Add status processed for donations which has payment_id and status waiting_for_payment
            $countPaymentId = 0;
            foreach ($this->donationService->allWaitingWithPaymentId() as $donation) {
                $this->donationService->updatePaymentIdAndAmount(array(
                    'status' => 'processed'
                ), $donation->id);
                $countPaymentId++;
            }

            Log::INFO('BULK PAIR -- count of waiting_payment donations with payment_id: ' . $countPaymentId);

            Log::INFO('BULK PAIR -- count of initialized donations with payment_id: ' . $countPaymentId);

        } catch (\Exception $exception) {
            Log::ERROR('BULK PAIR UNPAIRED PAYMENTS --- ' . $exception->getMessage() . '----' . json_encode($exception));
        }
    }

    private function isValidVariableSymbol($variable_symbol)
    {
        if ($variable_symbol !== 0 && $variable_symbol !== null && $variable_symbol !== '') {
            // check if variable symbol exist in db
            $portal_user_id = $this->variableSymbolService->getPortalUserByVariableSymbol($variable_symbol);
            if ($portal_user_id !== null) {
                return $portal_user_id;
            }
        }

        return null;
    }

    private function isValidIban($iban, $transaction_id)
    {
        if ($iban !== 0 && $iban !== null && $iban !== '' && $iban !== self::EXCLUDE_IBAN_FROM_PAIRING && substr($transaction_id, 0, 3) !== 'CP ') {
            // check if variable symbol exist in db
            $userOptions = $this->userPaymentOptionService->getByIban($iban);
            if ($userOptions !== null) {
                return $userOptions->portal_user_id;
            }
        }

        return null;
    }
}
