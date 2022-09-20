<?php

namespace Asciisd\Zoho\Tests\Integration;

use Asciisd\Zoho\ZohoManager;
use com\zoho\crm\api\record\SuccessResponse;

class ZohoUserTest extends IntegrationTestCase
{
    public const CONTACT_ID_FOR_TEST = '4226666000000882134';
    public const TESTING_MODULE = 'Contacts';

    /** @test */
    function it_can_create_contact_from_user_model() {
        $records = $this->getUser()->createAsZohoable();

        self::assertInstanceOf(SuccessResponse::class, $records);
        self::assertArrayHasKey('id', $records->getDetails());

        $id = $records->getDetails()['id'];
        ZohoManager::make(self::TESTING_MODULE)->deleteRecord($id);
    }

    protected function setUp(): void
    {
        $this->initialize();

        parent::setUp();
    }
}
