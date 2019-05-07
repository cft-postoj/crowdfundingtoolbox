<?php
use \Illuminate\Foundation\Http\FormRequest;

class SmartCampaignUpdateRequest extends FormRequest {
    public function rules()
    {
        return [
            'active' => 'boolean',
            'date_from' => 'date',
            'date_to'   =>  'date'
        ];
    }
}
