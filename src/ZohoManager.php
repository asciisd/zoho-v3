<?php

namespace Asciisd\Zoho;

use Asciisd\Zoho\Concerns\ManagesModules;
use Asciisd\Zoho\Concerns\ManagesRecords;
use Asciisd\Zoho\Concerns\ManagesActions;
use Asciisd\Zoho\Concerns\CriteriaBuilder;
use Asciisd\Zoho\Concerns\ManagesTags;
use com\zoho\crm\api\exception\SDKException;
use Asciisd\Zoho\Concerns\ManagesBulkActions;

class ZohoManager
{
    use CriteriaBuilder;
    use ManagesModules;
    use ManagesRecords;
    use ManagesTags;
    use ManagesActions;
    use ManagesBulkActions;

    protected string $module_api_name;

    public function __construct($module_api_name = 'Leads')
    {
        try {
            Zoho::initialize();
            $this->module_api_name = $module_api_name;
        } catch (SDKException $e) {
            //
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
