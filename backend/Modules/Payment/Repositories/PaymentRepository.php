<?php


namespace Modules\Payment\Repositories;


use Modules\Payment\Entities\Payment;

class PaymentRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Payment::class;
    }

    public function create($request)
    {
        return $this->model
            ::create($request);
    }

    public function update($request, $payment_id)
    {
        // case automatically update variable symbol and user id if bad paired
        return $this->model
            ::where('id', $payment_id)
            ->update($request);
    }

    public function getUnpairedPayments()
    {
        return $this->model
            ::with('donation')
            ->doesnthave('donation')
            ->orderby('id', 'DESC')
            ->get();
    }

    public function get($id)
    {
        return $this->model
            ::where('id', $id)
            ->first();
    }

    public function getPayments($from, $to, $monthly)
    {

        $query = Payment::query()
            ->whereDate('transaction_date', '>=', $from)
            ->whereDate('transaction_date', '<=', $to)
            ->with(['donation.portalUser.user.userDetail',
                'donation.widget.campaign',
                'donation.widget.widgetType','paymentMethod'])
            ->orderBy('transaction_date', 'DESC');

        if ($monthly === 'true') {
            $query = $query->has('donationMonthlyTrue');
        }
        if ($monthly === 'false') {
            $query = $query->has('donationMonthlyFalse');
        }
        return $query->get();
    }

    public function all()
    {
        return $this->model
            ::all();
    }

    public function getPaymentsFromIban($iban)
    {
        return $this->model
            ::where('iban', $iban)
            ->get();
    }

}