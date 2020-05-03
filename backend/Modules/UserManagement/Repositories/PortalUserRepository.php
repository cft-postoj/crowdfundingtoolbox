<?php


namespace Modules\UserManagement\Repositories;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Payment\Entities\Donation;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Entities\PaymentMethod;
use Modules\UserManagement\Entities\PortalUser;

class PortalUserRepository implements PortalUserRepositoryInterface
{
    protected $model;

    // first donation and date for portal user, when he successfully made first donation monthly group
    private $firstDonationMonthly;
    private $firstDonationAt;
    // first donation and date for portal user, when he successfully made first donation
    private $firstDonation;
    private $lastDonationAt;
    private $lastDonation;
    private $isMonthlyDonor;

    function __construct()
    {
        $this->model = PortalUser::class;

        $this->firstDonationMonthly = Donation::query()
            ->select('portal_user_id', 'is_monthly_donation',
                DB::raw('MIN(created_at) as first_donation_at'))
            ->groupBy('portal_user_id', 'is_monthly_donation');

        // first donation and date for portal user, when he successfully made first donation
        $this->firstDonationAt = Donation::query()
            ->select('portal_user_id', DB::raw('MIN(created_at) as first_donation_at'))
            ->where('status', 'processed')
            ->groupBy('portal_user_id');

        $this->firstDonation = Donation::query()
            ->select(DB::raw("DISTINCT ON (portal_user_id,created_at) portal_user_id"), 'widget_id as first_donation_widget_id', 'created_at');

        // get date of last donation
        $this->lastDonationAt = Donation::query()
            ->select('portal_user_id', DB::raw('MAX(created_at) as last_donation_at'))
            ->where('status', 'processed')
            ->groupBy('portal_user_id');

        // last donation detail
        $this->lastDonation = Donation::query()
            ->select(DB::raw("DISTINCT ON (portal_user_id,created_at) portal_user_id"), 'amount as last_donation_value', 'is_monthly_donation as last_donation_monthly',
                'payment_method as last_donation_payment_method', 'created_at', 'payment_id');

        // SUB DAYS -- count of days from last donation (30 days + 10 days for bank processing)
        $subDays = 30 + 10;
        $today = Carbon::today();
        $this->isMonthlyDonor = Donation::query()
            ->select(DB::raw('DISTINCT ON (portal_user_id) id as monthly_donor_donation_id'), 'portal_user_id as monthly_donor_portal_user_id')
            ->where('is_monthly_donation', '=', true)
            ->where('status', 'processed')
            ->where('created_at', '>=', $today->subDays($subDays)->toDateTimeString());
    }

    public function all()
    {
        return $this->model
            ::with('donations')
            ->with('isMonthlyDonor')
            ->get();
    }

    public function getAllIds()
    {
        return PortalUser::select('id')->get();
    }

    public function get($userId)
    {
        return $this->model
            ::where('user_id', $userId)
            ->first();
    }

    public function update($request, $portal_user_id)
    {
        return $this->model
            ::where('id', $portal_user_id)
            ->update($request);
    }


    public function create($userId)
    {
        return $this->model
            ::create([
                'user_id' => $userId
            ]);
    }

    public function createByDonation($user_id)
    {
        return $this->model
            ::create([
                'user_id' => $user_id,
                'register_by' => 'donation'
            ]);
    }

    public function createPortalUser($userId, $notes, $registerBy)
    {
        return $this->model
            ::create([
                'user_id' => $userId,
                'notes' => $notes,
                'register_by' => $registerBy
            ]);
    }

    public function getDonationsByUserPortalAndDate($id, $from, $to)
    {
        return Donation::query()
            ->whereHas('portalUser', function ($join) use ($id) {
                $join->where('user_id', $id);
            })
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->with('widget.campaign')
            ->with('widget.widgetType')
            ->with('portalUser.user.userDetail')
            ->with('payment.paymentMethod')
            ->get();
    }

    public function getAllWithDonations()
    {
        return $this->model
            ::has('donations')
            ->with('donations')
            ->has('user')
            ->with('user.userDetail')
            ->with('visit')
            ->get();
    }

    public function getAllWithOneTimeDonation()
    {
        return PortalUser
            ::whereHas('donations', function ($q) {
                $q->where('is_monthly_donation', false)
                    ->whereNotNull('payment_id');
            })
            ->with('donations.payment')
            ->get();

    }

    public function getDonationsDetailInfo($id)
    {
        return $this->model
            ::where('user_id', $id)
            ->with(['firstDonation', 'last', 'isMonthlyDonor', 'donationsSum'])
            ->first();
    }

    public function removeById($id)
    {
        return $this->model
            ::where('id', $id)
            ->delete();
    }

    public function getUserSupportData($id)
    {
        return $this->model
            ::where('id', $id)
            ->with('lastDonation')
            ->with('variableSymbol')
            ->with('userPaymentOptions')
            ->with('isMonthlyDonor')
            ->with('firstDonation')
            ->has('user')
            ->with('user.userDetail')
            ->with('gifts')
            ->with('gifts.gift')
            ->first();
    }

    public function getUserDonationData($id)
    {
        return $this->model
            ::where('id', $id)
            ->with('lastDonation')
            ->with('variableSymbol')
            ->with('userPaymentOptions')
            ->with('isMonthlyDonor')
            ->with('firstDonation')
            ->first();
    }

    public function getAllWithDonationData($minUserId, $maxUserId)
    {
        return $this->model
            ::where('id', '>=', $minUserId)
            ->where('id', '<=', $maxUserId)
            ->with('lastGiftDonation')
            //->with('variableSymbol')
            //->with('userPaymentOptions')
            //->with('isMonthlyDonor')
            //->with('firstDonation')
            ->get();
    }


    public
    function getPortalUserIdByUserId($userId)
    {
        return $this->model
            ::select('id')
            ->where('user_id', $userId)
            ->first();
    }


    public
    function getDonors($from, $to, $monthly, $pageSize, $filterColumns)
    {

        $payment = Payment::query()->select('id as payment_id', 'transaction_date');


        // get date of last donation
        $lastDonationAt = Donation::query()
            ->select('portal_user_id', DB::raw('MAX(created_at) as last_donation_at'))
            ->whereNotNull('payment_id')
            ->groupBy('portal_user_id');

        //if monthly is set, filter lastDonationAt
        if ($monthly !== null) {
            $lastDonationAt = $lastDonationAt->where('is_monthly_donation', $monthly);
        }

        // last donation detail
        $lastDonation = Donation::query()
            ->select('portal_user_id', 'amount as last_donation_value', 'is_monthly_donation as last_donation_monthly',
                'payment_method as last_donation_payment_method', 'created_at', 'payment_id');

        $resultQuery = PortalUser::filter($filterColumns)
            ->select(DB::raw('distinct on(portal_users.id) *'))
            ->joinSub($lastDonationAt, 'last_donation_at', 'portal_users.id', '=', 'last_donation_at.portal_user_id')
            ->joinSub($lastDonation, 'last_donation', function ($join) {
                $join->on('last_donation_at', '=', 'last_donation.created_at')
                    ->whereRaw('last_donation.portal_user_id = last_donation_at.portal_user_id');
            })
            ->whereHas('donations', function (Builder $query) use ($from, $to) {
                $query->whereHas('payment', function (Builder $query) use ($to, $from) {
                    $query->whereDate('payments.transaction_date', '>=', $from)
                        ->whereDate('payments.transaction_date', '<=', $to);;
                });
            })
            ->leftJoinSub($payment, 'payment', 'last_donation.payment_id', '=', 'payment.payment_id')
            ->leftJoinSub(PaymentMethod::query()->select('id as last_donation_payment_method_id', 'method_name as last_donation_payment_method_name'),
                'payment_method', 'last_donation.last_donation_payment_method', '=', 'payment_method.last_donation_payment_method_id');
        if ($pageSize != null) {
            return $resultQuery->paginate($pageSize);
        } else return $resultQuery->get();
    }

    public
    function countOfNewDonors($from, $to)
    {
        $firstPayment = Payment::query()
            ->select(DB::raw('MIN(payments.transaction_date) as first_payment_date'),
                'donations.portal_user_id as first_portal_user_id')
            ->join('donations', 'payments.id', '=', 'donations.payment_id')
            ->orderBy('first_portal_user_id')
            ->groupBy('first_portal_user_id');

        $payment = Payment::query()
            ->select('payments.transaction_date as current_payment_date',
                'donations.portal_user_id as portal_user_id',
                'donations.is_monthly_donation as is_monthly_donation')
            ->whereDate('payments.transaction_date', '>=', $from)
            ->whereDate('payments.transaction_date', '<=', $to)
            ->join('donations', 'payments.id', '=', 'donations.payment_id')
            ->groupBy('payments.id', 'portal_user_id', 'is_monthly_donation');

        //get only those portal users who made first donation at specific time period
        return PortalUser::query()
            ->select(DB::raw('count(portal_users.id)'), 'is_monthly_donation')
            ->joinSub($firstPayment, 'first_payment', function ($join) {
                $join->on('portal_users.id', '=', 'first_payment.first_portal_user_id');
            })
            ->joinSub($payment, 'payment', function ($join) {
                $join->on('portal_users.id', '=', 'payment.portal_user_id');
            })
            ->with('userPaymentOptions')
            ->whereRaw('current_payment_date = first_payment_date')
            ->groupBy('is_monthly_donation')
            ->get();
    }

    public
    function getDonorsNew($from, $to, $monthly, $pageSize, $filterColumns, $onlyCount)
    {
        $firstPayment = Payment::query()
            ->select(DB::raw('MIN(payments.transaction_date) as first_payment_date'),
                'donations.portal_user_id as first_portal_user_id')
            ->join('donations', 'payments.id', '=', 'donations.payment_id')
            ->orderBy('first_portal_user_id')
            ->groupBy('first_portal_user_id');

        $payment = Payment::query()
            ->select('payments.transaction_date as current_payment_date',
                'donations.portal_user_id as portal_user_id',
                'donations.is_monthly_donation as is_monthly_donation')
            ->whereDate('payments.transaction_date', '>=', $from)
            ->whereDate('payments.transaction_date', '<=', $to)
            ->join('donations', 'payments.id', '=', 'donations.payment_id')
            ->groupBy('payments.id', 'portal_user_id', 'is_monthly_donation');

        // get date of last donation
        $lastDonationAt = Donation::query()
            ->select('portal_user_id', DB::raw('MAX(created_at) as last_donation_at'))
            ->whereNotNull('payment_id')
            ->groupBy('portal_user_id');

        //if monthly is set, filter lastDonationAt
        if ($monthly !== null) {
            $lastDonationAt = $lastDonationAt->where('is_monthly_donation', $monthly);
        }

        // last donation detail
        $lastDonation = Donation::query()
            ->select(DB::raw('DISTINCT ON (portal_user_id,created_at) portal_user_id'), 'id as last_donation_id', 'amount as last_donation_value', 'is_monthly_donation as last_donation_monthly',
                'payment_method as last_donation_payment_method', 'created_at', 'payment_id');

        //get only those portal users who made first donation at specific time period
        $resultQuery = PortalUser::filter($filterColumns)
            ->joinSub($lastDonationAt, 'last_donation_at', 'portal_users.id', '=', 'last_donation_at.portal_user_id')
            ->joinSub($lastDonation, 'last_donation', function ($join) {
                $join->on('last_donation_at', '=', 'last_donation.created_at')
                    ->whereRaw('last_donation.portal_user_id = last_donation_at.portal_user_id');
            })
            ->joinSub($firstPayment, 'first_payment', function ($join) {
                $join->on('portal_users.id', '=', 'first_payment.first_portal_user_id');
            })
            ->joinSub($payment, 'payment', function ($join) {
                $join->on('portal_users.id', '=', 'payment.portal_user_id');
            })
            ->leftJoinSub(PaymentMethod::query()->select('id as last_donation_payment_method_id', 'method_name as last_donation_payment_method_name'),
                'payment_method', 'last_donation.last_donation_payment_method', '=', 'payment_method.last_donation_payment_method_id')
            ->whereRaw('current_payment_date = first_payment_date')
            ->orderBy('last_donation_at', 'DESC');
        if ($onlyCount) {
            return $resultQuery->count();
        }
        if ($pageSize !== null) {
            return $resultQuery->paginate($pageSize);
        } else $resultQuery->get();
    }

    public
    function getDonorsStoppedSupporting($stopAfterDate, $pageSize, $filterColumns)
    {
        // get date of last donation
        $lastMonthlyDonationAt = Donation::query()
                ->select('portal_user_id', DB::raw('MAX(trans_date) as last_donation_at'))
            ->where('is_monthly_donation', true)
            ->groupBy('portal_user_id');

        // last donation detail
        $lastMonthlyDonation = Donation::query()
            ->select('portal_user_id', 'amount as last_donation_value', 'is_monthly_donation as last_donation_monthly',
                'payment_method as last_donation_payment_method', 'trans_date');

        $resultQuery = PortalUser::filter($filterColumns)
            ->joinSub($lastMonthlyDonationAt, 'last_donation_at', function ($join) {
                $join->on('portal_users.id', '=', 'last_donation_at.portal_user_id');
            })
            ->joinSub($lastMonthlyDonation, 'last_donation', function ($join) {
                $join->on('last_donation_at.last_donation_at', '=', 'last_donation.trans_date')
                    ->whereRaw('last_donation.portal_user_id = last_donation_at.portal_user_id');
            })
            ->leftJoinSub(PaymentMethod::query()->select('id as last_donation_payment_method_id', 'method_name as last_donation_payment_method_name'),
                'payment_method', 'last_donation.last_donation_payment_method', '=', 'payment_method.last_donation_payment_method_id')
            ->orderBy('last_donation_at', 'DESC')
            ->whereDate('last_donation_at', '<=', $stopAfterDate);
        if ($pageSize !== null) {
            return $resultQuery->paginate($pageSize);
        } else {
            return $resultQuery->get();
        }
    }


    public
    function didNotPay($from, $to, $pageSize, $filterColumns)
    {
        // get date of last donation
        $lastDonationAt = Donation::query()
            ->select('portal_user_id', DB::raw('MAX(created_at) as last_donation_at'))
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->groupBy('portal_user_id');

        // last donation detail
        $lastDonation = Donation::query()
            ->select('portal_user_id', 'amount as last_donation_value', 'is_monthly_donation as last_donation_monthly',
                'payment_method as last_donation_payment_method', 'status', 'created_at', 'amount_initialized');


        $resultQuery = PortalUser::filter($filterColumns)
            ->whereDoesntHave('donations', function ($join) use ($to, $from) {
                $join->where('status', 'LIKE', 'processed')
                    ->whereDate('donations.created_at', '>=', $from)
                    ->whereDate('donations.created_at', '<=', $to);
            })
            ->joinSub($lastDonationAt, 'lastDonationAt', function ($join) {
                $join->on('portal_users.id', '=', 'lastDonationAt.portal_user_id');
            })
            ->joinSub($lastDonation, 'last_donation', function ($join) {
                $join->on('last_donation_at', '=', 'last_donation.created_at');
            })
            ->leftJoinSub(PaymentMethod::query()->select('id as last_donation_payment_method_id', 'method_name as last_donation_payment_method_name'),
                'payment_method', 'last_donation.last_donation_payment_method', '=', 'payment_method.last_donation_payment_method_id')
            ->with('lastUserDonation')
            ->orderBy('last_donation_at', 'DESC')
            ->where('last_donation.status', 'waiting_for_payment');
        if ($pageSize !== null) {
            return $resultQuery->paginate($pageSize);
        } else return $resultQuery->get();
    }

    public
    function onlyInitializeDonation($from, $to, $pageSize, $filterColumns)
    {
        //get only these donations, that have status initialized and are in time interval
        $onlyInitializeDonation = Donation::query()
            ->select(DB::raw('DISTINCT ON (donations.portal_user_id) donations.portal_user_id as portal_user_id'),
                'campaigns.name as campaign_name', 'campaigns.id as campaign_id', 'amount_initialized')
            ->join('widgets', 'widget_id', '=', 'widgets.id')
            ->join('campaigns', 'campaign_id', '=', 'campaigns.id')
            ->where('donations.status', 'initialized')
            ->whereDate('donations.created_at', '>=', $from)
            ->whereDate('donations.created_at', '<=', $to)
            ->orderBy('portal_user_id', 'ASC');
        $resultQuery = PortalUser::filter($filterColumns)
            ->whereDoesntHave('donations', function ($join) use ($to, $from) {
                $join->where('status', 'NOT LIKE', 'initialized')
                    ->whereDate('donations.created_at', '>=', $from)
                    ->whereDate('donations.created_at', '<=', $to);
            })
            ->joinSub($onlyInitializeDonation, 'onlyInitializeDonation', function ($join) {
                $join->on('portal_users.id', '=', 'onlyInitializeDonation.portal_user_id');
            })
            ->leftJoinSub($this->lastDonationAt, 'last_donation_at', function ($join) {
                $join->on('portal_users.id', '=', 'last_donation_at.portal_user_id');
            })
            ->leftJoinSub($this->lastDonation, 'last_donation', function ($join) {
                $join->on('last_donation.created_at', '=', 'last_donation_at')
                    ->whereRaw('last_donation.portal_user_id = last_donation_at.portal_user_id');
            })
            ->with('lastUserDonation');
        if ($pageSize !== null) {
            return $resultQuery->paginate($pageSize);
        } else return $resultQuery->get();
    }


    public
    function getAllPortalUsers($from, $to, $pageSize, $filterColumns)
    {
        $payment = Payment::query()
            ->select('id as payment_id', 'transaction_date')
            ->whereDate('payments.transaction_date', '>=', $from)
            ->whereDate('payments.transaction_date', '<=', $to);
        $resultQuery = PortalUser::filter($filterColumns)
            ->leftJoinSub($this->lastDonationAt, 'last_donation_at', 'portal_users.id', '=', 'last_donation_at.portal_user_id')
            ->leftJoinSub($this->lastDonation, 'last_donation', function ($join) {
                $join->on('last_donation_at', '=', 'last_donation.created_at')
                    ->whereRaw('last_donation.portal_user_id = last_donation_at.portal_user_id');
            })
            ->leftJoinSub($payment, 'payment', 'last_donation.payment_id', '=', 'payment.payment_id')
            ->leftJoinSub(PaymentMethod::query()->select('id as last_donation_payment_method_id', 'method_name as last_donation_payment_method_name'),
                'payment_method', 'last_donation.last_donation_payment_method', '=', 'payment_method.last_donation_payment_method_id');
        if ($pageSize !== null) {
            return $resultQuery->paginate($pageSize);
        } else {
            return $resultQuery->get();
        }
    }

    public
    function getUsersWithRecentDonation(int $daysBefore)
    {
        $now = Carbon::now();
        $from = Carbon::now()->subDays($daysBefore);
        return PortalUser::with(['donations' => function ($query) use ($now, $from) {
            $query->whereHas('payment', function ($query) use ($now, $from) {
                $query->whereDate('payments.transaction_date', '<', $now)
                    ->whereDate('payments.transaction_date', '>', $from);
            });
        },
            'lastPortalUserDonorCategory',
            'activeManualAssignedPortalUserDonorCategory'])
            ->get();

    }

    public
    function getUserId($portal_user_id)
    {
        return $this->model
            ::where('id', $portal_user_id)
            ->first()['user_id'];
    }

    public
    function getDonationsByPortalUser($portalUserId)
    {
        return $this->model
            ::has('donations')
            ->with('donations')
            ->where('id', $portalUserId)
            ->get();
    }

    public
    function activateAccount($portalUserId)
    {
        return $this->model
            ::where('id', $portalUserId)
            ->update([
                'locked_account' => false,
                'unlocked_at' => Carbon::now()
            ]);
    }

    public
    function getActiveDonors()
    {
        /*
         * use for mailer
         * Logic: user is active donor if he has some donation in last month (35 days ago)
         * or if he has min 60 eur donations in last year
         */
        return $this->model
            ::has('user')
            ->with('user')
            ->with('lastUserDonation.payment')
            ->with('donationsSumInLastYear')
            ->get();
    }

}