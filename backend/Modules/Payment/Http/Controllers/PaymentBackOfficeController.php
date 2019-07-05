<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Payment\Services\PaymentMethodsSevice;

class PaymentBackOfficeController extends Controller
{
    /*
    * Payment method can be created, updated, deleted. Administrator can turn on/off once payment method
    * or disable payment method for monthly/onc-time supports.
    * Available payment methods (depended on enable payment method per monthly/one-time support)
    * are display in monetization widget.
    * Get methods are available from portal and backoffice. Other methods only from backoffice.
    */

    private $paymentMethodsService;

    public function __construct(PaymentMethodsSevice $paymentMethodsService)
    {
        $this->paymentMethodsService = $paymentMethodsService;
    }

    protected function getAllMethods()
    {
        return $this->paymentMethodsService->getAllMethods();
    }

    // BANK TRASNSFER
    protected function getBankTransferDetails()
    {

    }

    protected function createBankTransferDetails(Request $request)
    {

    }

    protected function updateBankTransferDetails(Request $request)
    {

    }

    protected function deleteBankTransferDetails(Request $request)
    {

    }


    // **************************************************************

    // CARD PAY
    protected function getCardDetails()
    {

    }

    protected function createCardDetails(Request $request)
    {

    }

    protected function updateCardDetails(Request $request)
    {

    }

    protected function deleteCardDetails(Request $request)
    {

    }


    // **************************************************************

    // PAY BY SQUARE
    protected function getPayBySquareDetails()
    {

    }

    protected function createPayBySquareDetails(Request $request)
    {

    }

    protected function updatePayBySquareDetails(Request $request)
    {

    }

    protected function deletePayBySquareDetails(Request $request)
    {

    }


    // **************************************************************

    // GOOGLE PAY
    protected function getGooglePayDetails()
    {

    }

    protected function createGooglePayDetails(Request $request)
    {

    }

    protected function updateGooglePayDetails(Request $request)
    {

    }

    protected function deleteGooglePayDetails(Request $request)
    {

    }


    // ************************************************************

    // APPLE PAY
    protected function getApplePayDetails()
    {

    }

    protected function createApplePayDetails(Request $request)
    {

    }

    protected function updateApplePayDetails(Request $request)
    {

    }

    protected function deleteApplePayDetails(Request $request)
    {

    }

}
