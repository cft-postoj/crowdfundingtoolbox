<?php

namespace Modules\Payment\Services;


use Modules\Payment\Entities\DonationInitialize;

class DonationService
{

    public function initialize($data)
    {
        try {
            return DonationInitialize::create([
                'show_id' => $data['show_id'],
                'email' => $data['email'],
                'terms' => $data['terms'],
                'frequency' => $data['frequency'],
                'donation_value' => $data['donation_value']
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }



}