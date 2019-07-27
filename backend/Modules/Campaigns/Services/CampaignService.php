<?php

namespace Modules\Campaigns\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Campaigns\Entities\Campaign;
use Modules\Campaigns\Entities\Widget;
use Modules\Campaigns\Providers\CampaignPromoteService;
use Modules\Campaigns\Repositories\CampaignRepository;
use Modules\Campaigns\Transformers\CampaignResourceDetail;
use Modules\Targeting\Providers\TargetingService;
use Modules\UserManagement\Http\Controllers\UserServiceController;


class CampaignService implements CampaignServiceInterface
{

    private $targetingService;
    private $userService;
    private $promoteService;
    private $widgetService;
    private $campaignRepository;
    private $campaignPromoteService;

    public function __construct()
    {
        $this->userService = new UserServiceController();
        $this->targetingService = new TargetingService();
        $this->promoteService = new CampaignPromoteService();
        $this->widgetService = new WidgetService();
        $this->campaignRepository = new CampaignRepository();
        $this->campaignPromoteService = new CampaignPromoteService();
    }

    //raw campaign data contains data from request with data used inf all connected entities to campaign
    public function create($rawCampaignData)
    {
        $campaign = $this->campaignRepository->create($rawCampaignData);

        // Create Promote settings
        $campaign->promote = $this->promoteService->createCampaignPromoteSettings($campaign->id, $rawCampaignData['promote_settings']);
        $campaign->targeting = $this->targetingService->createTargetingFromRequest($campaign->id, $rawCampaignData['targeting']);
        $campaign->widgets = $this->widgetService->createWidgetsForCampaign($campaign->id);

        $user = Auth::user();
        //id 1 should have user with username admin created during migration
        $userId = Auth::user() != null ? $user->id : 1;
        $campaign->tracking = $this->addTracking($campaign->id, $userId, $this->show($campaign->id));
        return $campaign;
    }

    public function get($id): Campaign
    {
        return $this->campaignRepository->get($id);
    }

    public function update($rawCampaignData)
    {

        $campaign = $this->campaignRepository->update($rawCampaignData);
        $campaign->promote = $this->promoteService->updateCampaignPromoteSettings($campaign->id, $rawCampaignData['promote_settings']);
        $campaign->targeting = $this->targetingService->updateTargetingFromRequest($campaign->id, $rawCampaignData['targeting']);
        $user = Auth::user();

        $this->addTracking($campaign->id, $user->id, $this->show($campaign->id));

        return $campaign;
    }


    public function addTracking($campaignId, $userId, $data)
    {
        return $this->campaignRepository->addTracking($campaignId, $userId, $data);
    }

    public function show($id)
    {
        $campaign = Campaign::with('targeting.urls')->with('promote')->find($id);
        if ($campaign == null) {
            return response()->json([
                'message' => 'No results found.'
            ], Response::HTTP_NOT_FOUND);
        }
        return CampaignResourceDetail::make($campaign);
    }

    public function clone($id)
    {
        $campaign = $this->get($id);

        $newCampaign = $campaign->replicate();

        // create new campaign from old data
        $newCampaign->name = $campaign->name . ' (Copy)';
        $newCampaign->active = false;
        $newCampaign->save();

        $newPromote = $campaign->promote->replicate();

        $this->campaignPromoteService->createCampaignPromoteSettings($newCampaign->id, $newPromote);

//        $newPromote->campaign_id = $newCampaign->id;
//        $newCampaign->promote = $newPromote;



        $this->widgetService->cloneWidgetsInCampaign($campaign, $newCampaign);
        $this->targetingService->cloneTargeting($campaign, $newCampaign);

        return $newCampaign;
    }

    /**
     * @param Request $request
     * @param $id
     * @param $value
     */
    public function smartUpdate($data, $id, $value): Campaign
    {
        $campaign = $this->get($id);
        if ($value === 'dates_value') {
            $campaign['promote'] = $this->promoteService->smart($data, $id, $value);
        } else {
            $campaign->update([
                $value => $data[$value]
            ]);
        }
        return $campaign;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return Campaign::orderBy('active', 'desc')
            ->orderBy('updated_at', 'desc')
            ->with('targeting')
            ->with('promote')
            ->with('widget')
            ->with('widget.show')
            ->with('widget.donation')
            ->get();
    }

    /**
     * @param $id
     */
    public function delete($id): void
    {
        Campaign::find($id)->delete();
    }

    public function getByWidgetId($id)
    {
        return Campaign::where('id', Widget::where('id', $id)->first()['campaign_id'])
            ->first();
    }

}