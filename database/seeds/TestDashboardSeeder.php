<?php

use Illuminate\Database\Seeder;
use Modules\Campaigns\Database\Seeders\CreateDummyCampaignSeeder;
use Modules\Payment\Entities\CampaignDonation;
use Modules\Payment\Entities\Donation;
use Modules\UserManagement\Database\Seeders\PortalUserSeeder;
use Modules\UserManagement\Entities\PortalUser;

class TestDashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create 5 campaigns
        for ($i = 0; $i < 5; $i++) {
            $this->call(CreateDummyCampaignSeeder::class);
        }

        //create 50 users
        for ($i = 0; $i < 5; $i++) {
            $this->call(PortalUserSeeder::class);
        }


        $widgets = \Modules\Campaigns\Entities\Widget::get()->toArray();
        $users = PortalUser::with('user')->get()->toArray();
        $monthlySupporters = array_slice($users, 0, 50);
        // $i users (30) will be monthly supporters
        for ($i = 0; $i < 30; $i++) {
            $currentSupporter = $monthlySupporters[$i];
            $referralWidget = $widgets[array_rand($widgets)];
            $userDonation = $this->getRandomDonation();
            //get random time in current date to simulate different times of donations
            $donationDate = Carbon\Carbon::now()->setHour(rand(8, 23))->setMinute(rand(0, 59))->setSecond(rand(0, 59));
            //get random months, when user stopped with supporting ($rand is number of months)
            $rand = rand(0, 20) - 15;
            $j = $rand < 0 ? 0 : $rand;
            var_dump($j);
            for (; $j < rand($j, 20); $j++) {
                $userDonation = $this->changeMonthlySupport($userDonation, 0.1);
                Donation::create([
                    'portal_user_id' => $currentSupporter['id'],
                    'widget_id' => $referralWidget['id'],
                    'referral_widget_id' => $referralWidget['id'],
                    'donation' => $userDonation,
                    'is_monthly_donation' => true,
                    //sub $j from months of current date to simulate donation before $j months
                    'created_at' => $donationDate->copy()->subMonth($j),
                    'updated_at' => $donationDate->copy()->subMonth($j),
                ]);
            }
        }
//create 300 one time donations
        for ($i = 0; $i < 300; $i++) {
            $currentSupporter = $users[array_rand($users)];
            $referralWidget = $widgets[array_rand($widgets)];
            $donationDate = Carbon\Carbon::now()->setHour(rand(8, 23))->setMinute(rand(0, 59))->setSecond(rand(0, 59));
            $donationDate->subDays(rand(0,365));
            Donation::create([
                    'portal_user_id' => $currentSupporter['id'],
                    'widget_id' => $referralWidget['id'],
                    'referral_widget_id' => $referralWidget['id'],
                    'donation' => rand(1,50),
                    'is_monthly_donation' => false,
                    'created_at' => $donationDate,
                    'updated_at' => $donationDate,
                ]);
        }
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
}
