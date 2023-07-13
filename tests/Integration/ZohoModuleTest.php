<?php

namespace Asciisd\Zoho\Tests\Integration;

use Asciisd\Zoho\ZohoManager;
use com\zoho\crm\api\record\Leads;
use com\zoho\crm\api\record\Record;
use com\zoho\crm\api\modules\Module;
use com\zoho\crm\api\record\SuccessResponse;

class ZohoModuleTest extends IntegrationTestCase
{
    public const LEAD_ID_FOR_TEST = '4226666000000882106';
    public const TESTING_MODULE = 'Leads';

    /** @test */
    public function it_can_get_all_modules()
    {
        $response = ZohoManager::make(self::TESTING_MODULE);

        $modules = $response->getAllModules();

        self::assertIsArray($modules);

        foreach ($modules as $module) {
            echo "Module Name: ".$module->getPluralLabel();
        }
    }

    /** @test */
    public function is_can_get_module_by_name()
    {
        $response = ZohoManager::make(self::TESTING_MODULE);
        $module = $response->getModule();

        self::assertInstanceOf(Module::class, $module);

        self::assertEquals(self::TESTING_MODULE, $module->getPluralLabel());
    }

    /** @test */
    public function it_can_get_records_for_given_module_api_name()
    {
        $records = ZohoManager::make(self::TESTING_MODULE)->getRecords();

        self::assertIsArray($records);
    }

    /** @test */
    public function it_can_instantiate_a_record_with_id()
    {
        $record = ZohoManager::make(self::TESTING_MODULE)->getRecord(self::LEAD_ID_FOR_TEST);

        self::assertEquals(self::LEAD_ID_FOR_TEST, $record->getId());
    }

    /** @test */
    public function it_can_search_for_word_on_specific_module()
    {
        $records = ZohoManager::make(self::TESTING_MODULE)->searchRecordsByWord('Testing Lead');

        self::assertEquals(self::LEAD_ID_FOR_TEST, $records[0]->getId());
    }

    /** @test */
    public function it_can_search_for_phone_on_specific_module()
    {
        $records = ZohoManager::make(self::TESTING_MODULE)->searchRecordsByPhone('555555555551');

        self::assertInstanceOf(Record::class, $records[0]);
        self::assertEquals(self::LEAD_ID_FOR_TEST, $records[0]->getId());
    }

    /** @test */
    public function it_can_search_by_criteria()
    {
        $records = ZohoManager::make(self::TESTING_MODULE)
                              ->searchRecordsByCriteria("(First_Name:equals:Testing) and (Last_Name:equals:Lead)");

        self::assertInstanceOf(Record::class, $records[0]);
        self::assertEquals(self::LEAD_ID_FOR_TEST, $records[0]->getId());
    }

    /** @test */
    public function it_can_search_by_criteria_builder()
    {
        $records = ZohoManager::make('Contacts')
                              ->where('First_Name', 'Testing')
                              ->andWhere('Last_Name', 'Lead')
                              ->search();

        self::assertInstanceOf(Record::class, $records[0]);
        self::assertEquals(self::LEAD_ID_FOR_TEST, $records[0]->getId());
    }

    /** @test */
    public function it_can_create_new_record()
    {
        $records = ZohoManager::make(self::TESTING_MODULE)->create([
            'First_Name' => 'Can',
            'Last_Name'  => 'Create',
            'Email'      => 'can_create@asciisd.com',
            'Phone'      => '555555555552',
        ]);

        self::assertInstanceOf(SuccessResponse::class, $records);
        self::assertArrayHasKey('id', $records->getDetails());

        $id = $records->getDetails()['id'];
        ZohoManager::make(self::TESTING_MODULE)->deleteRecord($id);
    }

    /** @test */
    function it_can_update_record() {
        $records = ZohoManager::make(self::TESTING_MODULE)->create([
            'First_Name' => 'Can',
            'Last_Name'  => 'Update',
            'Email'      => 'can_update@asciisd.com',
            'Phone'      => '555555555552',
        ]);

        self::assertInstanceOf(SuccessResponse::class, $records);
        self::assertArrayHasKey('id', $records->getDetails());


        $id = $records->getDetails()['id'];

        $record = new Record();

        $record->setId($id);
        $record->addFieldValue(Leads::FirstName(), 'Updated');
        $record->addFieldValue(Leads::LastName(), 'Record');

        ZohoManager::make(self::TESTING_MODULE)->update($record);

        self::assertInstanceOf(SuccessResponse::class, $records);
        self::assertArrayHasKey('id', $records->getDetails());

        ZohoManager::make(self::TESTING_MODULE)->deleteRecord($id);
    }

    /** @test */
    public function it_can_delete_record()
    {
        $records = ZohoManager::make(self::TESTING_MODULE)->create([
            'First_Name' => 'Can',
            'Last_Name'  => 'Delete',
            'Email'      => 'can_delete@asciisd.com',
            'Phone'      => '555555555553',
        ]);

        self::assertArrayHasKey('id', $records->getDetails());

        $id = $records->getDetails()['id'];

        ZohoManager::make(self::TESTING_MODULE)->deleteRecord($id);
    }
}
