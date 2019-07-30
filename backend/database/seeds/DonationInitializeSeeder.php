<?php

use Illuminate\Database\Seeder;
use Modules\Campaigns\Entities\Widget;
use Modules\Payment\Entities\Donation;
use Modules\UserManagement\Entities\PortalUser;
use Modules\UserManagement\Entities\TrackingShow;
use Modules\UserManagement\Entities\TrackingVisit;

class DonationInitializeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $widgets = Widget::get()->toArray();
        $users = PortalUser::with('user')->get()->toArray();

        for ($i = 0; $i < 30; $i++) {
            $randomDate = Carbon\Carbon::now()->subDays(rand(0, 60))->subHours(rand(0, 24));
            $user = $users[array_rand($users)];
            $widgetId = $widgets[array_rand($widgets)]['id'];
            $trackingVisit = TrackingVisit::create([
                'portal_user_id' => $user['id'],
                'user_cookie' => null,
                'url' => 'https://www.postoj.sk/45165/zazitky-namiesto-prazdnej-hlavy',
                'article_id' => rand(0, 10),
                'title' => 'Ideálne prázdniny: Dobrodružstvo namiesto rezortov'
            ]);
            $trackingShow = TrackingShow::create([
                'tracking_visit_id' => $trackingVisit['id'],
                'widget_id' => $widgetId
            ]);
            Donation::create([
                'tracking_show_id' => $trackingShow['id'],
                'widget_id' => $widgetId,
                'referral_widget_id' => $widgetId,
                'portal_user_id' => $user['id'],
                'created_at' => $randomDate,
                'status' => 'initialized',
                'payment_method' => rand(1, 5),
                'is_monthly_donation' => rand(0, 1) == 1,
                'amount' => rand(1, 5) * 5
            ]);
        };
    }
}
