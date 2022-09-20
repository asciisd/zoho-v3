<?php

namespace Asciisd\Zoho\Contracts\Repositories;

interface ZohoableRepository
{
    /**
     * This used when we need to search for your current model record on zoho
     */
    public function searchCriteria();

    /**
     * Array for mandatory fields that required to create new record on Zoho Module
     */
    public function zohoMandatoryFields(): array;
}
