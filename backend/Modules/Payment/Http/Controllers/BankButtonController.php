<?php

namespace Modules\Payment\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Payment\Services\BankButtonService;

class BankButtonController extends Controller
{


    private $bankButtonService;

    public function __construct(BankButtonService $bankButtonService)
    {
        return $this->bankButtonService = $bankButtonService;
    }

    protected function getBankButtons()
    {
        return $this->bankButtonService->getBankButtons();
    }

    protected function updateBankButtons(Request $request)
    {
        return $this->bankButtonService->updateBankButtons($request->all());
    }

}