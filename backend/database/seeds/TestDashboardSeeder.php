<?php

use Illuminate\Database\Seeder;
use Modules\Payment\Entities\CampaignDonation;
use Modules\Payment\Entities\Donation;
use Modules\Payment\Services\PaymentMethodsService;
use Modules\Payment\Services\PaymentService;
use Modules\UserManagement\Database\Seeders\PortalUserSeeder;
use Modules\UserManagement\Entities\DonorStatus;
use Modules\UserManagement\Entities\PortalUser;
use Modules\UserManagement\Entities\TrackingVisit;
use Modules\UserManagement\Entities\TrackingShow;
use Modules\Campaigns\Entities\Widget;

class TestDashboardSeeder extends Seeder
{
    protected $variableSymbolService;
    protected $userGdprRepository;

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
        //create 7 campaigns
//        for ($i = 0; $i < 7; $i++) {
//            $this->call(\Modules\Campaigns\Database\Seeders\CreateDummyCampaignSeeder::class);
//        }

        //create 250 users
//        for ($i = 0; $i < 80; $i++) {
//            $this->call(PortalUserSeeder::class);
//        }
        $users = PortalUser::all();
        foreach ($users as $user) {
            if ($user->id > 900) {
                $this->generateTrackingAndPayments($user->id);
            }
        }


//        $widgets = \Modules\Campaigns\Entities\Widget::get()->toArray();
//        $users = PortalUser::with('user')->get()->toArray();
//        $monthlySupporters = array_slice($users, 0, 50);
//        $paymentMethods = [1, 2, 3, 4, 5];
//        // $i users (30) will be monthly supporters
//        for ($i = 0; $i < 30; $i++) {
//            $currentSupporter = $monthlySupporters[$i];
//            $referralWidget = $widgets[array_rand($widgets)];
//            $userDonation = $this->getRandomDonation();
//            //get random time in current date to simulate different times of donations, sub random days to simulate donations during whole month
//            $donationDate = Carbon\Carbon::now()->setHour(rand(8, 23))->setMinute(rand(0, 59))->setSecond(rand(0, 59))->subDays(rand(0, 30));
//            //get random months, when user stopped with supporting ($rand is number of months)
//            $rand = rand(0, 20) - 15;
//            $j = $rand < 0 ? 0 : $rand;
//            for (; $j < rand($j, 20); $j++) {
//                $userDonation = $this->changeMonthlySupport($userDonation, 0.1);
//                $amountInitialized = $userDonation;
//                if ($j % 7 === 0) {
//                    $amountInitialized = abs($userDonation - rand(1.5, 10.4));
//                }
//                $donation = Donation::create([
//                    'portal_user_id' => $currentSupporter['id'],
//                    'widget_id' => $referralWidget['id'],
//                    'referral_widget_id' => $referralWidget['id'],
//                    'amount' => $userDonation,
//                    'amount_initialized' => $amountInitialized,
//                    'is_monthly_donation' => true,
//                    //sub $j from months of current date to simulate donation before $j months
//                    'created_at' => $donationDate->copy()->subMonth($j),
//                    'updated_at' => $donationDate->copy()->subMonth($j),
//                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
//                    'status' => 'waiting_for_payment'
//                ]);
//                // every 21th payment to unpaired
//                $portal_user_id = $donation->portal_user_id;
//                if ($i % 21 === 0 || $i % 15 === 0 || $i % 18 === 0 || $i % 6 === 0) {
//                    $portal_user_id = null;
//                }
//                $payment = $this->createPayment($donation->id, $portal_user_id, $donation->amount, $donation->created_at);
//                if ($portal_user_id !== null) {
//                    Donation::where('id', $donation->id)->update(array(
//                        'status' => 'processed',
//                        'payment_id' => $payment->id
//                    ));
////                    // monthly donation is true
////                    DonorStatus::where('portal_user_id', Donation::where('id', $donation->id)->first()['portal_user_id'])->update(array(
////                        'monthly_donor' => true
////                    ));
//                }
//            }
//        }
        // create 300 one time donations
//        for ($i = 0; $i < 300; $i++) {
//            $currentSupporter = $users[array_rand($users)];
//            $referralWidget = $widgets[array_rand($widgets)];
//            $donationDate = Carbon\Carbon::now()->setHour(rand(8, 23))->setMinute(rand(0, 59))->setSecond(rand(0, 59));
//            $donationDate->subDays(rand(0, 365));
//            $amountInitialized = $userDonation;
//            if ($j % 7 === 0) {
//                $amountInitialized = abs($userDonation - rand(1.5, 10.4));
//            }
//            $donation = Donation::create([
//                'portal_user_id' => $currentSupporter['id'],
//                'widget_id' => $referralWidget['id'],
//                'referral_widget_id' => $referralWidget['id'],
//                'amount' => rand(1, 50),
//                'amount_initialized' => $amountInitialized,
//                'is_monthly_donation' => false,
//                'created_at' => $donationDate,
//                'updated_at' => $donationDate,
//                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
//                'status' => 'processed'
//            ]);
//
//            // every 19th payment to unpaired
//            $portal_user_id = $donation->portal_user_id;
//            if ($i % 19 === 0) {
//                $portal_user_id = null;
//            }
//            $payment = $this->createPayment($donation->id, $portal_user_id, $donation->amount, $donation->created_at);
//            if ($portal_user_id !== null) {
//                Donation::where('id', $donation->id)->update(array(
//                    'status' => 'processed',
//                    'payment_id' => $payment->id
//                ));
//            }
//        }
    }

    private function changeMonthlySupport($previousUserDonation, float $probabilityToChangeDonation)
    {
        $probabilityPercent = $probabilityToChangeDonation * 100;
        $random = rand(0, 100);
        return $random < $probabilityPercent ? $this->getRandomDonation() : $previousUserDonation;
    }

    private function getRandomDonation()
    {
        return rand(1, 6) * 5;
    }

    private function createPayment($donation_id, $portal_user_id, $amount, $transaction_date)
    {
        if ($portal_user_id !== null) {
            $variable_symbol = PortalUser::where('id', $portal_user_id)
                ->with('variableSymbol')
                ->first()->variableSymbol['variable_symbol'];
        } else {
            $variable_symbol = 2019; // case for bad variable symbol
        }

        $request = array(
            'transaction_id' => $this->transactionId(10),
            'variable_symbol' => $variable_symbol,
            'iban' => $this->iban(16),
            'amount' => $amount,
            'transfer_type' => $this->paymentMethod(),
            'created_by' => $this->createdBy(),
            'transaction_date' => $transaction_date
        );
        $payment = $this->paymentService->createPayment($request);
        return $payment;
    }

    private function transactionId($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function iban($length)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = 'SK';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function paymentMethod()
    {
        $methods = $this->paymentMehhodService->all();
        return $methods[array_rand(json_decode($methods))]->id;
    }

    private function createdBy()
    {
        // randomly return one of next values
        $createdByArr = ['API', 'parsing', 'import'];
        return $createdByArr[array_rand($createdByArr)];
    }


    // TRACKING SEEDER (Flow -- trackingVisit -- trackingShow -- donations -- payments)
    private function generateTrackingAndPayments($portalUserId)
    {
        // generate 30 tracking records for each portal user
        $trackingSites = array();
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/74/ked-george-soros-a-charles-koch-financuju-katolickeho-konzervativca',
            'article_id' => 74,
            'title' => 'Keď George Soros a Charles Koch financujú katolíckeho konzervatívca'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/73/klerofasisticke-pokusenie-ladislava-hanusa',
            'article_id' => 73,
            'title' => 'Klérofašistické pokušenie Ladislava Hanusa'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/69/najvaecsia-reforma-smeru-v-zdravotnictve-za-dvanast-rokov-projekty-penty',
            'article_id' => 69,
            'title' => 'Najväčšia reforma Smeru v zdravotníctve za dvanásť rokov? Projekty Penty'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/72/v-centre-bratislavy-vylupili-zlatnictvo-ukradli-sperky-za-viac-ako-50-tisic-eur',
            'article_id' => 72,
            'title' => 'V centre Bratislavy vylúpili zlatníctvo, ukradli šperky za viac ako 50-tisíc eur'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/70/o-lobotku-udajne-prejavil-zaujem-ac-milano',
            'article_id' => 70,
            'title' => 'O Lobotku údajne prejavil záujem AC Miláno'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/68/zelensky-hovoril-s-putinom-aj-o-zajatych-ukrajinskych-namornikoch',
            'article_id' => 68,
            'title' => 'Zelenský hovoril s Putinom aj o zajatých ukrajinských námorníkoch'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news',
            'article_id' => null,
            'title' => ''
        ));

        for ($i = 0; $i < 5; $i++) {
            $tracking = $trackingSites[array_rand($trackingSites)];
            $donationDate = Carbon\Carbon::now()->setHour(rand(8, 23))->setMinute(rand(0, 59))->setSecond(rand(0, 59))->subDays(rand(30, 150));
            $trackingVisit = TrackingVisit::create([
                'portal_user_id' => $portalUserId,
                'user_cookie' => null,
                'url' => $tracking['url'],
                'article_id' => $tracking['article_id'],
                'title' => $tracking['title'],
                'created_at' => $donationDate
            ]);
            $widget = Widget::inRandomOrder()->first();
            TrackingShow::create([
                'tracking_visit_id' => $trackingVisit->id,
                'widget_id' => $widget->id,
                'created_at' => $donationDate
            ]);
            if ($widget->widget_type_id === 1) {
                $widgetReferral = Widget::inRandomOrder()->first();
                $amountInitialized = abs(rand(1.5, 30.4));
                $paymentMethods = [1, 2, 3, 4, 5];
                $donation = Donation::create([
                    'portal_user_id' => $portalUserId,
                    'widget_id' => $widget->id,
                    'referral_widget_id' =>  ($widgetReferral->widget_type_id !== 1) ? $widgetReferral->id : null,
                    'amount' => rand(1, 50),
                    'amount_initialized' => $amountInitialized,
                    'is_monthly_donation' => false,
                    'created_at' => $donationDate,
                    'updated_at' => $donationDate,
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'status' => 'waiting_for_payment'
                ]);
                if ($i % 4 !== 0) {
                    $payment = $this->createPayment($donation->id, $portalUserId, $donation->amount, $donation->created_at);
                    if ($portalUserId !== null) {
                        Donation::where('id', $donation->id)->update(array(
                            'status' => 'processed',
                            'payment_id' => $payment->id
                        ));
                    }
                }
            }
        }
    }

}
