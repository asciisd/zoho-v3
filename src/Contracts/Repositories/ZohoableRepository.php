<?php

namespace Asciisd\Zoho\Contracts\Repositories;

interface ZohoableRepository
{
    /**
     * Array for mandatory fields that required to create new record
     *
     * @return array
     */
    public function zohoMandatoryFields();
}
