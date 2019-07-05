<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PaymentController extends Controller
{
    /*
     * FOR PORTAL USERS
     */

    protected function getAllAvailableMethods()
    {
        /* TODO get all available payment methods from toolbox */
    }

    // BANK TRASNSFER
    protected function getBankTransferDetails()
    {

    }

    protected function payViaBankTransfer(Request $request)
    {

    }

    // **************************************************************

    // CARD PAY
    protected function getCardDetails()
    {

    }

    protected function payViaCard(Request $request)
    {

    }

    // **************************************************************

    // PAY BY SQUARE
    protected function getPayBySquareDetails()
    {

    }

    protected function payViaPayBySquare(Request $request)
    {

    }

    // **************************************************************

    // GOOGLE PAY
    protected function getGooglePayDetails()
    {

    }

    protected function payViaGooglePay(Request $request)
    {

    }

    // ************************************************************

    // APPLE PAY
    protected function getApplePayDetails()
    {

    }

    protected function payViaApplePay(Request $request)
    {

    }
}
