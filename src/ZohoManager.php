<?php

namespace Asciisd\Zoho;

use Asciisd\Zoho\Concerns\CriteriaBuilder;
use Asciisd\Zoho\Concerns\ManagesActions;
use Asciisd\Zoho\Concerns\ManagesBulkActions;
use Asciisd\Zoho\Concerns\ManagesModules;
use Asciisd\Zoho\Concerns\ManagesRecords;
use Asciisd\Zoho\Concerns\ManagesTags;
use Asciisd\Zoho\Concerns\Lead;
use Asciisd\Zoho\Concerns\Deal;
use Asciisd\Zoho\Concerns\Contact;
use com\zoho\crm\api\exception\SDKException;

class ZohoManager
{
    use CriteriaBuilder;
    use ManagesModules;
    use ManagesRecords;
    use ManagesTags;
    use ManagesActions;
    use ManagesBulkActions;
    use Lead;
    use Deal;
    use Contact;

    protected string $module_api_name;
    protected string $token;

    public function __construct($module_api_name = 'Leads')
    {
        try {
            $this->module_api_name = $module_api_name;
            Zoho::initialize();
            $this->token = Zoho::getToken();
        } catch (SDKException $e) {
            logger()->error($e->getMessage());
        }
    }

    public static function useModule(string $module_name = 'Leads'): static
    {
        return new static($module_name);
    }

    public static function make(string $module_name = 'Leads'): static
    {
        return static::useModule($module_name);
    }
}
