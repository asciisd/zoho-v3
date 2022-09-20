<?php

namespace Asciisd\Zoho\Tests\Fixture\Models;

use Asciisd\Zoho\ZohoManager;
use Asciisd\Zoho\Traits\Zohoable;
use Asciisd\Zoho\Models\Zohoable as ZohoableModel;
use Asciisd\Zoho\Contracts\Repositories\ZohoableRepository;

class User extends ZohoableModel implements ZohoableRepository
{
    use Zohoable;

    protected string $zoho_module_name = 'Contacts';

    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'zoho_id'];

    public function zohoMandatoryFields(): array
    {
        return [
            'First_Name' => $this->first_name,
            'Last_Name'  => $this->last_name,
            'Email'      => $this->email,
            'Phone'      => $this->phone,
        ];
    }

    public function searchCriteria()
    {
        ZohoManager::make($this->zoho_module_name)
                   ->where('First_Name', $this->first_name)
                   ->andWhere('Last_Name', $this->last_name)
                   ->getCriteria();
    }
}
