<?php

namespace Modules\Payment\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Modules\Payment\Entities\Donation;
use Modules\UserManagement\Entities\TrackingVisit;
use Modules\UserManagement\Entities\UserCookieCouple;

class CalculateReferralWidgets extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'donations:referral-calc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate referral widget based on tracking shows.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // get all donations where widget_id is not null but referral_widget is null
        $donations = Donation::query()
            ->whereNotNull('widget_id')
            ->whereNotNull('tracking_show_id')
            ->whereNull('referral_widget_id')
            ->get();
        $donationUpdate = [];
        foreach ($donations as $donation) {
            //try to find correct $referral widget id, that user saw before he was redirected to donation
            $portalUserId = $donation->portal_user_id;

            $trackingVisit = TrackingVisit::query()
                ->where(function (Builder $q) use ($portalUserId) {
                    $q->where('portal_user_id', $portalUserId)
                        ->orWhereIn('user_cookie',
                            UserCookieCouple::query()
                                ->select('user_cookie_id')
                                ->where('portal_user_id', $portalUserId));
                })
                ->with(['show.widget'])
                ->orderByDesc('created_at')
                ->offset(1)
                ->first();
            if ($trackingVisit == null) {
                continue;
            }
            $widgetId = null;
            if (strpos($trackingVisit->url, 'podpora') === false &&
                $temp = $this->firstTrackingShow($trackingVisit->show)) {
                $widgetId = $temp;
            }
            if ($widgetId !== null) {
                array_push($donationUpdate, [
                    'donation_id' => $donation->id,
                    'referral_widget_id' => $widgetId
                ]);
            }
        }
        foreach ($donationUpdate as $singleUpdate) {
            Donation::query()
                ->where('id', $singleUpdate['donation_id'])
                ->update(['referral_widget_id' => $singleUpdate['referral_widget_id']]);
        }
        dump($donationUpdate);
    }

    public function firstTrackingShow($trackingShows)
    {
        $widgetId = null;
        foreach ($trackingShows as $trackingShow) {
            if (!in_array($trackingShow->widget->id, [
                //excluding some campaigns to avoid false positive pairing
                1, 2, 3,
                58, 59, 60, 61, 62, 63, 64, 65, 66, 76,
                77, 78, 79, 80, 81, 82, 83, 84
            ])) {
                return $trackingShow->widget->id;
            }
        }
        return null;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
