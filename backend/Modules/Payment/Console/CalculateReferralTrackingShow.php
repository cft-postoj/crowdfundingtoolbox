<?php

namespace Modules\Payment\Console;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Modules\Payment\Entities\Donation;
use Modules\UserManagement\Entities\TrackingVisit;
use Modules\UserManagement\Entities\UserCookieCouple;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CalculateReferralTrackingShow extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'donations:referral-calc-tracking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalc referral tracking show for donations to reproduce data needed to track donation to article.';

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
            ->whereNull('referral_tracking_show_id')
            ->with('trackingShow')
            ->get();

        $donationUpdate = [];

        foreach ($donations as $donation) {
            //try to find correct $referral tracking show id, which was created before user supported
            $portalUserId = $donation->portal_user_id;
            $donationTrackingVisitId = $donation->trackingShow->tracking_visit_id;
            //get last tracking visit before donation using tracking tracking show of campaign
            $trackingVisitPrevious = TrackingVisit::query()
                ->where(function (Builder $q) use ($portalUserId) {
                    $q->where('portal_user_id', $portalUserId)
                        ->orWhereIn('user_cookie',
                            UserCookieCouple::query()
                                ->select('user_cookie_id')
                                ->where('portal_user_id', $portalUserId));
                })
                ->with(['show.widget'])
                ->where('id', '<', $donationTrackingVisitId)
                ->orderByDesc('id')
                ->first();
            if ($trackingVisitPrevious == null) {
                continue;
            }
            if (strpos($trackingVisitPrevious->url, 'podpora') === false) {
                $referralTrackingShowId = $this->firstTrackingShow($trackingVisitPrevious);
                if ($referralTrackingShowId !== false) {
                    array_push($donationUpdate, [
                        'donation_id' => $donation->id,
                        'referral_tracking_show_id' => $referralTrackingShowId
                    ]);
                }
            }
        }
        foreach ($donationUpdate as $singleUpdate) {
            Donation::query()
                ->where('id', $singleUpdate['donation_id'])
                ->update(['referral_tracking_show_id' => $singleUpdate['referral_tracking_show_id']]);
        }
        dump($donationUpdate);
    }

    public function firstTrackingShow($trackingVisit)
    {
        $trackingShow = $trackingVisit->show->first();
        if ($trackingShow != null && !in_array($trackingShow->widget->id, [
                //excluding some campaigns to avoid false positive pairing
                1, 2, 3,
                58, 59, 60, 61, 62, 63, 64, 65, 66,
                76, 77, 78, 79, 80, 81, 82, 83, 84
            ])) {
            return $trackingShow->id;
        }
        return false;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
        ];
    }
}
