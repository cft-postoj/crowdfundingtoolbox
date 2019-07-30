<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Payment\Services\PaymentMethodsService;
use Modules\Payment\Services\PaymentService;

class PaymentsSeederTableSeeder extends Seeder
{
    protected $paymentService;
    protected $paymentMehhodService;

    public function __construct(PaymentService $paymentService, PaymentMethodsService $paymentMehhodService)
    {
        $this->paymentService = $paymentService;
        $this->paymentMehhodService = $paymentMehhodService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create 100 payments
    }

    private function paymentMethod()
    {
        $methods = $this->paymentMehhodService->all();
        return $methods[array_rand($methods)]->id;
    }

    private function createdBy()
    {
        // randomly return one of next values
        $createdByArr = ['API', 'parsing', 'import'];
        return $createdByArr[array_rand($createdByArr)];
    }
}
