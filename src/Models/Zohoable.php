<?php

namespace Asciisd\Zoho\Models;

use Asciisd\Zoho\Contracts\Repositories\ZohoableRepository;
use Asciisd\Zoho\Traits\Zohoable as ZohoableModel;
use Asciisd\Zoho\ZohoManager;
use Illuminate\Database\Eloquent\Model;

abstract class Zohoable extends Model implements ZohoableRepository
{
    use ZohoableModel;

    protected string $zoho_module_name;
    protected ZohoManager $zoho_module;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->zoho_module = $this->getZohoModule();
    }
}
