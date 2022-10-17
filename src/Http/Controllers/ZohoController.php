<?php

namespace Asciisd\Zoho\Http\Controllers;

use Asciisd\Zoho\Zoho;
use Illuminate\Routing\Controller;
use Asciisd\Zoho\Http\Requests\ZohoRedirectRequest;

class ZohoController extends Controller
{
    public function oauth2callback(ZohoRedirectRequest $request)
    {
        Zoho::initialize($request->code);

        return 'Zoho CRM has been set up successfully.';
    }
}
