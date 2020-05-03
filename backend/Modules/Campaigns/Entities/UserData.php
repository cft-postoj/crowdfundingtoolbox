<?php


namespace Modules\Campaigns\Entities;


class UserData
{

    public $signed;

    // structure : { 'today': number, 'week': number, 'month':number}
    public $numberOfReadArticles;

    // boolean
    protected $validAddress;


    public function __construct($signed, $numberOfReadArticles)
    {
        $this->signed = $signed;
        $this->numberOfReadArticles = $numberOfReadArticles;
    }

    public function getValidAddress()
    {
        return $this->validAddress;
    }

    public function setValidAddress($validAddress): void
    {
        $this->validAddress = !!$validAddress;
    }


}