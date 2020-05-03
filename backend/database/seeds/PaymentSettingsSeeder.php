<?php

use Illuminate\Database\Seeder;

class PaymentSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Bank transfer
        $this->bankTransferSeeder();

        // Card pay
        $this->cardPaySeeder();

        // Pay by square seeder
        $this->payBySquareSeeder();
    }

    private function bankTransferSeeder()
    {
        \Modules\Payment\Entities\PaymentOption::create([
            'payment_method' => 1,
            'payment_settings' => '{"title":"Bank Transfer","oneTimePayment":{"accountNumber":"SK5211000000002943460300","specificSymbol":null,"constantSymbol":"0308","swift":"TATRA","bankName":"TATRA BANKA","accountOwner":"Postoj, o.z.","paymentNote":null,"available":true},"monthlyPayment":{"accountNumber":"SK5211000000002943460300","specificSymbol":null,"constantSymbol":"0308","swift":"TATRA","bankName":"TATRA BANKA","accountOwner":"Postoj, o.z.","paymentNote":null,"available":true}}',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        \Modules\Campaigns\Entities\Image::create([
            'path' => 'tatrabanka-logo.png',
            'type' => 'image/png',
            'size' => '11634',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        \Modules\Payment\Entities\BankButton::create([
            'order' => 0,
            'title' => 'Tatra Banka',
            'image_id' => 5,
            'redirect_link' => 'https://tatrabanka.sk',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        \Modules\Campaigns\Entities\Image::create([
            'path' => 'slsp-logo.png',
            'type' => 'image/png',
            'size' => '11634',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        \Modules\Payment\Entities\BankButton::create([
            'order' => 0,
            'title' => 'Slovenska Sporitelna',
            'image_id' => 6,
            'redirect_link' => 'https://slsp.sk',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    private function cardPaySeeder()
    {
        \Modules\Payment\Entities\PaymentOption::create([
            'payment_method' => 2,
            'payment_settings' => '{"title":"Card Pay","oneTimePayment":{"emailNotify":"support@crowdfundingtoolbox.news"},"monthlyPayment":{"emailNotify":"support@crowdfundingtoolbox.news"}}',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    private function payBySquareSeeder()
    {
        \Modules\Payment\Entities\PaymentOption::create([
            'payment_method' => 3,
            'payment_settings' => '{"title":"Pay By Square","oneTimePayment":{"accountNumber":"SK5211000000002943460300","specificSymbol":null,"constantSymbol":"0308","swift":"TATRA","bankName":"TATRA BANKA","accountOwner":"Postoj, o.z.","paymentNote":null,"available":true}}',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
