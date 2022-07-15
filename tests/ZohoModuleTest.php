<?php

namespace Asciisd\Zoho\Tests;

use com\zoho\crm\api\record\Leads;
use com\zoho\crm\api\record\Record;
use com\zoho\crm\api\modules\Module;
use com\zoho\crm\api\record\BodyWrapper;
use com\zoho\crm\api\record\ActionWrapper;
use com\zoho\crm\api\record\RecordOperations;
use com\zoho\crm\api\modules\ResponseWrapper;
use com\zoho\crm\api\modules\ModulesOperations;
use com\zoho\crm\api\record\ResponseWrapper as RecordsResponseWrapper;

class ZohoModuleTest extends IntegrationTestCase
{
    const LEAD_ID_FOR_TEST = '4226666000000339001';
    const TESTING_MODULE = 'Leads';

    /** @test */
    public function it_can_get_all_modules()
    {
        $response = (new ModulesOperations())->getModules();

        $responseHandler = $response->getObject();

        self::assertInstanceOf(ResponseWrapper::class, $responseHandler);

        $modules = $responseHandler->getModules();

        foreach ($modules as $module) {
            dump("Module Name: ".$module->getPluralLabel());
        }
    }

    /** @test */
    public function is_can_get_module_by_name()
    {
        $module = $this->getModule(self::TESTING_MODULE);

        self::assertInstanceOf(Module::class, $module);

        self::assertEquals(self::TESTING_MODULE, $module->getPluralLabel());
    }

    /** @test */
    public function it_can_get_records_for_given_module_api_name()
    {
        $response        = (new RecordOperations())->getRecords(self::TESTING_MODULE);
        $responseHandler = $response->getObject();

        self::assertInstanceOf(RecordsResponseWrapper::class, $responseHandler);

        dump($responseHandler->getData());
    }

    /** @test */
    public function it_can_instantiate_a_record_with_id()
    {
        $record = $this->getRecord(self::LEAD_ID_FOR_TEST, self::TESTING_MODULE);

        dump($record);

        self::assertEquals(self::LEAD_ID_FOR_TEST, $record->getId());
    }

    /** @test */
    public function it_can_search_for_word_on_specific_module()
    {
        $records = $this->searchRecordsByWord('Emad');

        dump($records);
        self::assertEquals('4226666000000327002', $records[0]->getId());
    }

    /** @test */
    public function it_can_search_for_phone_on_specific_module()
    {
        $records = $this->searchRecordsByPhone('01011441444');

        dump($records);
        self::assertInstanceOf(Record::class, $records[0]);
    }

    /** @test */
    public function it_can_create_new_record()
    {
        $recordOperations = new RecordOperations();
        $bodyWrapper      = new BodyWrapper();

        $recordClass = 'com\zoho\crm\api\record\Record';
        $record1     = new $recordClass();
        $record1->addFieldValue(Leads::FirstName(), "Amr");
        $record1->addFieldValue(Leads::LastName(), "Emad");
        $record1->addFieldValue(Leads::Company(), "Caveo Brokerage");
        $record1->addFieldValue(Leads::Email(), "test@caveo.com.kw");
        $record1->addFieldValue(Leads::Phone(), "01011441444");
        $records[] = $record1;

        $bodyWrapper->setData($records);
        $response        = $recordOperations->createRecords(self::TESTING_MODULE, $bodyWrapper);
        $actionResponses = $response->getObject();

        self::assertInstanceOf(ActionWrapper::class, $actionResponses);

        $ids = [];
        foreach($actionResponses->getData() as $actionResponse){
            $ids[] = $actionResponse->getDetails()['id'];
        }

        dump($ids);

        $this->deleteRecords($ids);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->initialize();
    }
}
