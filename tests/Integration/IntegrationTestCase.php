<?php

namespace Asciisd\Zoho\Tests\Integration;

use Asciisd\Zoho\Tests\TestCase;
use Asciisd\Zoho\Tests\Fixture\Models\User;

abstract class IntegrationTestCase extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    public function getUser(): User
    {
        return new User([
            'first_name' => 'Create',
            'last_name'  => 'From User',
            'email'      => 'user@asciisd.com',
            'phone'      => '555555555551',
        ]);
    }
}
