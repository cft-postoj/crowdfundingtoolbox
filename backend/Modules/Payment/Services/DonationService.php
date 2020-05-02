<?php

namespace Modules\Payment\Services;


use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Payment\Entities\Donation;
use Modules\Payment\Entities\DonationInitialize;
use Modules\Payment\Repositories\DonationRepository;
use Modules\UserManagement\Emails\DonationEmail;
use Modules\UserManagement\Repositories\PortalUserRepository;
use Modules\UserManagement\Services\CreatedUsersService;
use Modules\UserManagement\Services\GeneratedUserTokenService;
use Modules\UserManagement\Services\PortalUserService;
use Modules\UserManagement\Services\TrackingService;
use JWTAuth;
use Webpatser\Uuid\Uuid;

class DonationService
{

    private $portalUserService;
    private $donationRepository;
    private $portalUserRepository;
    private $trackingService;
    private $paymentMethodsService;
    private $bankButtonService;
    private $payBySquareService;
    private $cardPayService;
    private $comfortPayService;

    //tells about number of days between payments, that should still should be consider as monthly donations
    private $diffInDaysInMonthly = 40;
    private $createdUserService;

    public function __construct()
    {
        $this->portalUserService = new PortalUserService();
        $this->donationRepository = new DonationRepository();
        $this->portalUserRepository = new PortalUserRepository();
        $this->trackingService = new TrackingService();
        $this->paymentMethodsService = new PaymentMethodsService();
        $this->bankButtonService = new BankButtonService();
        $this->payBySquareService = new PayBySquareService();
        $this->cardPayService = new CardPayService();
        $this->comfortPayService = new ComfortPayService();
        $this->createdUserService = new CreatedUsersService();
    }

    //if request is from dashboard, mock this function entirely
    public function initializeBackend($data, $url)
    {
        $bankOption = $this->paymentMethodsService->getBankOption($data['frequency'], 1);
        $qrCodeOption = $bankOption;
        if ($data['frequency'] !== 'monthly') {
            $qrCodeOption = $this->paymentMethodsService->getBankOption($data['frequency'], 3);
        }
        $bankButtons = $this->bankButtonService->getBankButtons();
        if (strpos($url, env('APP_URL')) === 0) {
            $qrCode = $this->payBySquareService->getQRCodeFromData('0001', '20', $data['frequency'], $qrCodeOption->accountNumber);
            return array(
                'variable_symbol' => '0001',
                'bank_account' => $bankOption->accountNumber,
                'bankButtons' => $bankButtons,
                'qrCode' => $qrCode,
                'backoffice' => 'true'
            );
        }
        return $this->initialize($data);

    }

    public function allInitializedOlderThenDayWithPaymentId()
    {
        return Donation::where('status', 'initialized')
            ->whereDate('created_at', '<=', Carbon::now()->subDay())
            ->whereNotNull('payment_id')
            ->get();
    }

    public function allWaitingWithPaymentId()
    {
        return Donation::where('status', 'waiting_for_payment')
            ->whereNotNull('payment_id')
            ->get();
    }

    public function initialize($data)
    {
        try {
            $bankOption = $this->paymentMethodsService->getBankOption($data['frequency'], 1);
            $qrCodeOption = $bankOption;
            if ($data['frequency'] !== 'monthly') {
                $qrCodeOption = $this->paymentMethodsService->getBankOption($data['frequency'], 3);
            }
            $trackingShow = $this->trackingService->getTrackingShowById($data['show_id']);
            $user = $this->portalUserService->registerDuringDonation($data['show_id'], $data['email'], $trackingShow->visit['user_cookie'], $data['terms'], $bankOption->accountNumber);
            $bankButtons = $this->bankButtonService->getBankButtons();

            $uuid = Uuid::generate()->string;

            $donation = Donation::create([
                'referral_widget_id' => $data['referral_widget_id'],
                'tracking_show_id' => $data['show_id'],
                'referral_tracking_show_id' => $data['referral_tracking_show_id'],
                'widget_id' => $trackingShow->widget->id,
                'portal_user_id' => $user->portalUser->id,
                'status' => 'initialized',
                'is_monthly_donation' => $data['frequency'] == 'monthly',
                'amount_initialized' => $data['amount'],
                'notes' => $data['notes'],
                'uuid' => $uuid
            ]);
            $qrCode = $this->payBySquareService->getQRCodeFromData($user->portalUser->variableSymbol->variable_symbol, $data['amount'], $data['frequency'], $qrCodeOption->accountNumber);

            if ($data['frequency'] === 'monthly') {
                return array(
                    'variable_symbol' => $user->portalUser->variableSymbol->variable_symbol,
                    'bank_account' => $bankOption->accountNumber,
                    'bankButtons' => $bankButtons,
                    'donation_id' => $donation->id,
                    'comfortPayURL' => $this->comfortPayService->init($data, $user, $uuid)
                );
            } else {
                return array(
                    'variable_symbol' => $user->portalUser->variableSymbol->variable_symbol,
                    'bank_account' => $bankOption->accountNumber,
                    'bankButtons' => $bankButtons,
                    'qrCode' => $qrCode,
                    'donation_id' => $donation->id,
                    'cardPayURL' => $this->cardPayService->init($data, $user, $uuid)
                );
            }
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
    }

    public function deleteDonation($id)
    {
        return $this->donationRepository->delete($id);
    }

    public function waitingForPayment($donationId, $payment_method_id)
    {
        $donation = $this->getById($donationId);
        $donation->status = 'waiting_for_payment';
        $donation->payment_method = $payment_method_id;
        $donation->update();
        $this->createdUserService->deleteByPortalUserId($donation->portal_user_id);
        if ((int)$payment_method_id !== 2) { // if is not Card Pay
            $portal_user_id = $donation->portal_user_id;
            $userId = $this->portalUserService->getUserId($portal_user_id);
            $userData = $this->portalUserService->getById($userId);
            $email = $userData->email;
            $variableSymbol = $userData->portalUser->variableSymbol->variable_symbol;
            $generatedTokenService = new GeneratedUserTokenService();
            $generatedToken = $generatedTokenService->create($userId);
            Mail::to($email)->send(
                new DonationEmail($donation->amount_initialized, $variableSymbol, null, 'donation', $donation->is_monthly_donation ? 'monthly' : 'one-time', $payment_method_id, $generatedToken, $userId));
        }
        return $donation;
    }


    public function isUserOneTimeSupporter($donationsData)
    {
        foreach ($donationsData as $donation) {
            if ($donation->is_monthly_donation) {
                return false;
            }
        }
        return true;
    }

    public function isInSpecificLastPaymentTarget($donationsData, $olderThan, $notOlderThan, $type)
    {
        foreach ($donationsData as $donation) {
            if ($type == 'monthly') {
                if ($donation->is_monthly_donation) {
                    // return first donation which is monthly type
                    return $this->calculateDays($olderThan, $notOlderThan, $donation);
                }
            } else {
                if ($this->isUserOneTimeSupporter($donationsData)) {
                    if (!$donation->is_monthly_donation) {
                        return $this->calculateDays($olderThan, $notOlderThan, $donation);
                    }
                } else {
                    return false;
                }

            }
        }
        return false;
    }

    private function calculateDays($olderThan, $notOlderThan, $donation)
    {
        // WORKING WITH LAST DONATION
        $now = Carbon::now();
        return ($olderThan !== null && $notOlderThan !== null) ?
            (($now->subDays($olderThan) > Carbon::createFromFormat('Y-m-d H:i:s', $donation->created_at))
            && ($now->subDays($notOlderThan) < Carbon::createFromFormat('Y-m-d H:i:s', $donation->created_at))
                ? true : false)
            : (($olderThan !== null && $notOlderThan === null)
                ?
                (($now->subDays($olderThan) > Carbon::createFromFormat('Y-m-d H:i:s', $donation->created_at))
                    ? true : false)
                : (($now->subDays($notOlderThan) < Carbon::createFromFormat('Y-m-d H:i:s', $donation->created_at))
                    ? true : false
                )
            );
    }

    public function isInSpecificDonationTarget($donationsData, $biggerThan, $lessThan, $type)
    {
        if ($type === 'monthly') {
            return $this->isCorrectDonationTarget($biggerThan, $lessThan, $donationsData, true);
        }
        return $this->isCorrectDonationTarget($biggerThan, $lessThan, $donationsData, false);
    }

    private function isCorrectDonationTarget($biggerThan, $lessThan, $donations, $monthlyDonation)
    {
        foreach ($donations as $donation) {
            if ($donation->is_monthly_donation === $monthlyDonation) {
                if ($biggerThan !== null && $lessThan !== null) {
                    if ($donation->amount > $biggerThan && $donation->amount < $lessThan) {
                        return true;
                    }
                } else if ($biggerThan !== null && $lessThan === null) {
                    if ($donation->amount > $biggerThan) {
                        return true;
                    }
                } else {
                    if ($donation->amount < $lessThan) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function getDetail($id)
    {
        return response()->json(
            $this->donationRepository->getDetail($id),
            Response::HTTP_OK
        );
    }

    public function updateAssignment($request, $id)
    {
        $valid = validator($request->only(
            'user_id'
        ), [
            'user_id' => 'required|integer'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], 400);
            return $jsonError;
        }

        try {
            $portal_user_id = $this->portalUserService->getPortalUserIdByUserId($request['user_id']);
            $this->donationRepository->updateAssignment($portal_user_id, $id);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Successfully updated donation with id ' . $id . '.'
        ],
            Response::HTTP_CREATED
        );
    }

    public function updatePaymentIdAndAmount($request, $id)
    {
        return Donation::where('id', $id)->update(
            $request
        );
    }

    public function getDonationsByUserId($user_id)
    {
        return Donation::where('portal_user_id', $this->portalUserService->getPortalUserIdByUserId($user_id))
            ->get();
    }

    public function getDonationsByPortalUserId($portal_user_id)
    {
        return Donation::where('portal_user_id', $portal_user_id)->get();
    }

    public function getAscDonationsByPortalUserId($portal_user_id)
    {
        return Donation::where('portal_user_id', $portal_user_id)->orderBy('id', 'asc')->get();
    }

    public function getDonationsByPortalUserIdWithPaymentId($portal_user_id)
    {
        return Donation::where('portal_user_id', $portal_user_id)
            ->whereNotNull('payment_id')
            ->get();
    }


    public function create($request)
    {
        return $this->donationRepository->create($request);
    }

    public function cancelAssignment($id)
    {
        try {
            $this->donationRepository->delete($id);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Successfully cancel assignment of donation with id ' . $id
        ], Response::HTTP_OK);
    }

    private function getById($donationId)
    {
        return $this->donationRepository->getById($donationId);
    }

    public function getDonations($from, $to, $monthly, $page_size, $filterColumns)
    {
        return $this->donationRepository->getDonations($from, $to, $monthly, $page_size, $filterColumns);
    }

    public function shouldBeMonthlyDonation($portalUserId, Carbon $transactionDate, $amount)
    {
        //sub 35 days from calcForDay to get value for minimum date for interval, where payments will be aggregated
        // to calc sum of all payment's amount
        $from = $transactionDate->copy()->subDays($this->diffInDaysInMonthly);
        return $this->donationRepository->shouldBeMonthlyDonation($portalUserId, $from, $transactionDate, $amount);
    }

    public function updateMonthlyStatusRetrospective($portalUserId, Carbon $to, $amount)
    {
        //sub $diffInDaysInMonthly days from calcForDay to get value for minimum date for interval, where payments will be aggregated
        // to calc sum of all payment's amount
        $from = $to->copy()->subDays($this->diffInDaysInMonthly);

        $donations = $this->donationRepository->getDonationsToUpdateStatusRetrospective($portalUserId, $from, $to, $amount);
        foreach ($donations as $donation) {
            $from = Carbon::parse($donation->payment->transaction_date);
            $to = $from->copy()->addDays($this->diffInDaysInMonthly);
            if ($this->donationRepository->shouldBeMonthlyDonation($portalUserId, $from, $to, $amount)) {
                $donation->is_monthly_donation = true;
                $this->donationRepository->updateRequest($donation);
            }
        }
    }

    //filter campaign using monthly /one-time and not supporter status from campaign's targeting
    public function filterCampaignByTargetingAndDonations($campaigns, $donations)
    {
        $result = [];
        foreach ($campaigns as $campaign) {
            //filter only campaigns, where one_time, monthly or not_supporter targeting is activated
            if ($campaign->targeting->one_time || $campaign->targeting->monthly || $campaign->targeting->not_supporter) {
                $sumInDateRange = $this->sumOfDonationAmount(
                    $campaign->targeting->one_time_not_older_than,
                    Carbon::now()->subDays($campaign->targeting->one_time_not_older_than_value),
                    $campaign->targeting->one_time_older_than,
                    Carbon::now()->subDays($campaign->targeting->one_time_older_than_value),
                    $campaign->targeting->monthly_not_older_than,
                    Carbon::now()->subDays($campaign->targeting->monthly_not_older_than_value),
                    $campaign->targeting->monthly_older_than,
                    Carbon::now()->subDays($campaign->targeting->monthly_older_than_value),
                    $donations
                );
                //check if $sumInDateRange is in range. one-time, monthly and not supporter are connected with OR
                if (
                    // not supporter
                    (($campaign->targeting->not_supporter && $donations->isEmpty())) ||
                    // one time supporters
                    ($campaign->targeting->one_time &&
                        ($sumInDateRange['one_time'] > 0) &&
                        (!$campaign->targeting->one_time_min || $sumInDateRange['one_time'] >= $campaign->targeting->one_time_min_value) &&
                        (!$campaign->targeting->one_time_max || $sumInDateRange['one_time'] <= $campaign->targeting->one_time_max_value)) ||
                    // monthly supporters
                    ($campaign->targeting->monthly &&
                        ($sumInDateRange['monthly'] > 0) &&
                        (!$campaign->targeting->monthly_min || $sumInDateRange['monthly'] >= $campaign->targeting->monthly_min_value) &&
                        (!$campaign->targeting->monthly_max || $sumInDateRange['monthly'] <= $campaign->targeting->monthly_max_value)
                    )) {
                    array_push($result, $campaign);
                }
            } else {
                array_push($result, $campaign);
            }
        }
        return $result;
    }

    private function sumOfDonationAmount($one_time_not_older_than, $one_time_from, $one_time_older_than, $one_time_to,
                                         $monthly_not_older_than, $monthly_from, $monthly_older_than, $monthly_to, $donations)
    {
        $sumOfDonations = array('one_time' => 0, 'monthly' => 0);
        $one_time_from = $one_time_not_older_than ? $one_time_from : Carbon::minValue();
        $one_time_to = $one_time_older_than ? $one_time_to : Carbon::maxValue();
        $monthly_from = $monthly_not_older_than ? $monthly_from : Carbon::minValue();
        $monthly_to = $monthly_older_than ? $monthly_to : Carbon::maxValue();
        foreach ($donations as $donation) {
            if ($donation->is_monthly_donation) {
                if (Carbon::parse($donation->payment->transaction_date)->between($monthly_from, $monthly_to)) {
                    $sumOfDonations['monthly'] += $donation->amount;
                }
            } else {
                if (Carbon::parse($donation->payment->transaction_date)->between($one_time_from, $one_time_to)) {
                    $sumOfDonations['one_time'] += $donation->amount;
                }
            }
        }
        return $sumOfDonations;
    }

    public function getSuccessDonationsByMonthOldDate()
    {
        $currentDate = Carbon::now();
        $monthOldDate = $currentDate->subMonth();
        $response = $this->donationRepository->getSuccessDonationsByMonthOldDate($monthOldDate);
        return $response;
    }

    public function lastBankTransferMonthlyDonation($portal_user_id)
    {
        return $this->donationRepository->lastBankTransferMonthlyDonation($portal_user_id);
    }

    public function anotherDonationsWithSamePayment($payment_id)
    {
        if (sizeof($this->donationRepository->getByPaymentId($payment_id)) > 1) {
            return $this->donationRepository->getByPaymentId($payment_id)[0];
        }
        return null;
    }

    public function accountDonationView()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $userData = $this->portalUserRepository->getUserSupportData($this->portalUserService->getPortalUserIdByUserId($user->id));
        return view('portal-templates.myAccount.parts.donation', array('data' => $userData));
    }


    public function pairBulk($userId, array $paymentIds)
    {
        $paymentService = new PaymentService();
        $counter = 0;
        foreach ($paymentIds as $paymentId) {
            $currentPayment = $paymentService->getPayment($paymentId);
            $this->unpairBulk([$paymentId]);
            $paymentService->pairPaymentToUserCore([
                'user_id' => $userId,
                'iban' => $currentPayment->iban],
                [$currentPayment]);
            $counter++;
            Log::info('bulk paired payment: ' . json_encode($currentPayment));
        }
        return $counter;
    }

    public function unpairBulk($paymentIds, $donations = null)
    {
        if ($donations === null) {
            $donations = Donation::query()
                ->whereIn('payment_id', $paymentIds)->get();
        }
        $count = 0;
        foreach ($donations as $donation) {
            $donation->update(['payment_id' => null]);
            $donation->delete();
            $count++;
        }
        return $count;
    }

    public function deleteAllDonationByPortalUserId($id)
    {
        $this->donationRepository->deleteAllDonationByPortalUserId($id);
    }


}
