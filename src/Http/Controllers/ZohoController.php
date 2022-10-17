<?php

namespace Asciisd\Zoho\Http\Controllers;

use Asciisd\Zoho\Zoho;
use Illuminate\Routing\Controller;
use com\zoho\crm\api\exception\SDKException;
use Asciisd\Zoho\Http\Requests\ZohoRedirectRequest;

class ZohoController extends Controller
{
    public function oauth2callback(ZohoRedirectRequest $request)
    {
        try {
//            Zoho::initialize($request->code);
        } catch (SDKException $e) {
        }

        return 'Zoho CRM has been set up successfully.';
    }
}
