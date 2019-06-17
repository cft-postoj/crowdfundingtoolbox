<?php

namespace Modules\Campaigns\Services;


use Modules\Campaigns\Entities\Campaign;

interface WidgetServiceInterface
{

    public function createWidgetsForCampaign($campaignId);

    public function update($rawWidgetData);


    public function initialWidgetSettings($id, $widgetTypeId);
    public function createSettingsJson($widgetType);

    public function getGeneralSettings();
    public function overrideMonetization($deviceType, $settings, $widgetTypeId);

    public function widgetSettingsStructure();

    public function updateWidgetSettingsFromCampaign($campaignId, $promoteSettings);

    public function overrideGeneralSettings($type, $settings, $widgetType);
    public function paymentSettingsStructure($widgetTypeId);

    public function getAdditionalWidgetSettings($widgetType, $generalSettings);

    public function addTracking($widgetId, $userId, $data);
    public function get($id);
    public function getWidgetsByCampaignId($campaignId);
    public function updateResults($request);
    public function getCampaignWidgets($user);
    public function getWidgetsByCampaginReduced($campaign);
    public function getWidgets($origin, $title, $userCookie, $userId);


    public function cloneWidgetsInCampaign(Campaign $campaign, $newCampaign);

}