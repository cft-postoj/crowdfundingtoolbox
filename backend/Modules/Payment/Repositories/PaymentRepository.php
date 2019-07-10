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
            ::with('pairedDonation')
            ->doesnthave('pairedDonation')
            ->orderby('id', 'DESC')
            ->get();
    }

    public function get($id)
    {
        return $this->model
            ::where('id', $id)
            ->first();
    }

}