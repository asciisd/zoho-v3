<?php

namespace Asciisd\Zoho\Http\Controllers;

use Asciisd\Zoho\Zoho;
use com\zoho\crm\api\exception\SDKException;
use Illuminate\Routing\Controller;
use Asciisd\Zoho\Http\Requests\ZohoRedirectRequest;

class ZohoController extends Controller
{
    public function oauth2callback(ZohoRedirectRequest $request)
    {
        try {
            Zoho::initialize($request->code);
        } catch (SDKException $e) {
            return 'Error while setting up Zoho CRM: ' . $e->getMessage();
        }

        return 'Zoho CRM has been set up successfully.';
    }
}
