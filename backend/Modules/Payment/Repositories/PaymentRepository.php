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
            ::doesntHave('donation')
            ->orderByDesc('payments.transaction_date')
            ->get();
    }

    public function getAscUnpairedPayments()
    {
        return $this->model
            ::doesntHave('donation')
            ->orderBy('payments.transaction_date', 'asc')
            ->get();
    }

    public function getUnpairedPaymentsDesc()
    {
        return $this->model
            ::doesntHave('donation')
            ->orderBy('payments.transaction_date')
            ->get();
    }

    public function get($id)
    {
        return $this->model
            ::where('id', $id)
            ->with('donation')
            ->first();
    }

    public function getPayments($from, $to, $monthly, $pageSize, $filterColumns)
    {
        $query = Payment::filter($filterColumns)
            ->orderBy('payments.transaction_date', 'DESC');

        if ($from !== null) {
            $query = $query->whereDate('payments.transaction_date', '>=', $from);
        }
        if ($to !== null) {
            $query = $query->whereDate('payments.transaction_date', '<=', $to);
        }

        if ($monthly === 'true') {
            $query = $query->has('donationMonthlyTrue');
        }
        if ($monthly === 'false') {
            $query = $query->has('donationMonthlyFalse');
        }
        return $query->paginate($pageSize);
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

    public function getByTransactionId($tid)
    {
        return $this->model
            ::where('transaction_id', $tid)
            ->first();
    }

    public function getByUuid($uuid)
    {
        return $this->model
            ::where('uuid', $uuid)
            ->first();
    }

    public function existTransactionId($transactionId)
    {
        return $this->model
            ::where('transaction_id', $transactionId)
            ->first();
    }

    public function updateByAccountNumber($accountNumber, $accountName)
    {
        return $this->model
            ::where('iban', $accountNumber)
            ->update(array(
                'account_name' => $accountName
            ));
    }

}
