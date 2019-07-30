<?php

namespace Modules\Campaigns\Services;


interface CampaignServiceInterface
{
    //row campagin data contains data from request with data used inf all connected entities to campaign
    public function create($rawCampaignData);

    public function get($id);

    public function update($rawCampaignData);

    public function addTracking($campaignId, $userId, $data);

    public function show($id);

    public function clone($id);
    public function smartUpdate($data, $id, $value);
    public function getAll();

    /**
     * @param $id
     */
    public function delete($id);

}