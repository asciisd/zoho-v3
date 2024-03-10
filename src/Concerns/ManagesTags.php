<?php

namespace Asciisd\Zoho\Concerns;

use com\zoho\crm\api\tags\AddTagsParam;
use com\zoho\crm\api\tags\Tag;
use com\zoho\crm\api\ParameterMap;
use com\zoho\crm\api\tags\GetTagsParam;
use com\zoho\crm\api\tags\BodyWrapper;
use com\zoho\crm\api\tags\MergeWrapper;
use com\zoho\crm\api\tags\TagsOperations;
use com\zoho\crm\api\tags\UpdateTagParam;
use com\zoho\crm\api\tags\UpdateTagsParam;
use com\zoho\crm\api\modules\APIException;
use com\zoho\crm\api\tags\ConflictWrapper;
use com\zoho\crm\api\tags\CreateTagsParam;
use com\zoho\crm\api\exception\SDKException;
use com\zoho\crm\api\tags\GetRecordCountForTagParam;
use com\zoho\crm\api\tags\AddTagsToMultipleRecordsParam;
use com\zoho\crm\api\tags\RemoveTagsFromMultipleRecordsParam;
use com\zoho\crm\api\tags\ResponseWrapper as TagResponseWrapper;


trait ManagesTags {

    /**
     * The method to get tags
     * @return array An instance of APIResponse
     * @throws SDKException
     */
    public function getTags(): array
    {
        $tagsOperations = new TagsOperations();
        $paramInstance  = new ParameterMap();
        $paramInstance->add(GetTagsParam::module(), $this->module_api_name);

        return $this->handleTagResponse(
            $tagsOperations->getTags($paramInstance)
        );

    }

    /**
     * @param array $tagNames
     * @return array
     * @throws SDKException
     */
    public function createTags(array $tagNames): array
    {
        //Get instance of TagsOperations Class
        $tagsOperations = new TagsOperations();

        //Get instance of BodyWrapper Class that will contain the request body
        $request = new BodyWrapper();

        //Get instance of ParameterMap Class
        $paramInstance = new ParameterMap();

        $paramInstance->add(CreateTagsParam::module(), $this->module_api_name);

        //List of Tag instances
        $tagList = array();

        foreach ($tagNames as $tagName) {
            $tag = new Tag();
            $tag->setName($tagName);
            $tagList[] = $tag;
        }

        $request->setTags($tagList);

        //Call createTags method that takes BodyWrapper instance and paramInstance as parameter
        return $this->handleTagResponse(
            $tagsOperations->createTags($request, $paramInstance)
        );
    }


    /**
     * @param array $tags
     * @return array
     * @throws SDKException
     */
    public function updateTags(array $tags): array
    {
        //Get instance of TagsOperations Class
        $tagsOperations = new TagsOperations();

        //Get instance of BodyWrapper Class that will contain the request body
        $request = new BodyWrapper();

        //Get instance of ParameterMap Class
        $paramInstance = new ParameterMap();

        $paramInstance->add(UpdateTagsParam::module(), $this->module_api_name);

        //List of Tag instances
        $tagList = array();

        foreach ($tags as $tag) {
            //Get instance of Tag Class
            $tag1 = new Tag();

            $tag1->setId($tag['id']);

            $tag1->setName($tag['name']);

        }


        $request->setTags($tagList);

        //Call updateTags method that takes BodyWrapper instance and paramInstance as parameter
        return $this->handleTagResponse(
            $tagsOperations->updateTags($request, $paramInstance)
        );
    }

    /**
     * @param array $tag
     * @return array
     * @throws SDKException
     */
    public function updateTag(array $tag): array
    {
        //Get instance of TagsOperations Class
        $tagsOperations = new TagsOperations();

        //Get instance of BodyWrapper Class that will contain the request body
        $request = new BodyWrapper();

        //Get instance of ParameterMap Class
        $paramInstance = new ParameterMap();

        $paramInstance->add(UpdateTagParam::module(), $this->module_api_name);

        //List of Tag instances
        $tagList = array();


        //Get instance of Tag Class
        $tag1 = new Tag();

        $tag1->setName($tag['name']);

        $tagList[] = $tag1;

        $request->setTags($tagList);

        //Call updateTags method that takes BodyWrapper instance, paramInstance and tagId as parameter
        return $this->handleTagResponse(
            $tagsOperations->updateTag($tag['id'], $request, $paramInstance)
        );
    }

    /**
     * @param string $id
     * @return array
     */
    public function deleteTag(string $id): array
    {
        //Get instance of TagsOperations Class
        $tagsOperations = new TagsOperations();

        //Call deleteTag method that takes tag id as parameter
        return $this->handleTagResponse(
            $tagsOperations->deleteTag($id)
        );

    }

    /**
     * @param string $id
     * @param string $conflictId
     * @return array
     */
    public function mergeTags(string $id, string $conflictId): array
    {

        //Get instance of TagsOperations Class
        $tagsOperations = new TagsOperations();

        //Get instance of MergeWrapper Class that will contain the request body
        $request = new MergeWrapper();

        //List of Tag ConflictWrapper
        $tags = array();

        //Get instance of ConflictWrapper Class
        $mergeTag = new ConflictWrapper();

        $mergeTag->setConflictId($conflictId);

        $tags[] = $mergeTag;

        $request->setTags($tags);

        //Call deleteTag method that takes MergeWrapper instance and tag id as parameter
        return $this->handleTagResponse(
            $tagsOperations->mergeTags($id, $request)
        );
    }

    /**
     * @param string $recordId
     * @param array $tagNames
     * @return array
     * @throws SDKException
     */
    public function addTagsToRecord(string $recordId, array $tagNames): array
    {
        //Get instance of TagsOperations Class
        $tagsOperations = new TagsOperations();

        //Get instance of ParameterMap Class
        $paramInstance = new ParameterMap();

        foreach ($tagNames as $tagName) {
            $paramInstance->add(AddTagsParam::overWrite(), $tagName);
        }

        $paramInstance->add(AddTagsParam::overWrite(), "false");

        //Call addTagsToRecord method that takes paramInstance, moduleAPIName and recordId as parameter
        return $this->handleTagResponse(
            $tagsOperations->addTagsToMultipleRecords(
                $recordId,
                $this->module_api_name,
                $paramInstance
            )
        );

    }

    /**
     * @param string $recordId
     * @param array $tagNames
     * @return array
     * @throws SDKException
     */
    public function removeTagsFromRecord(string $recordId, array $tagNames): array
    {

        //Get instance of TagsOperations Class
        $tagsOperations = new TagsOperations();

        //Get instance of ParameterMap Class
        $paramInstance = new ParameterMap();

        foreach($tagNames as $tagName)
        {
            $paramInstance->add(RemoveTagsFromMultipleRecordsParam::ids(), $tagName);
        }

        //Call removeTagsFromRecord method that takes paramInstance, moduleAPIName and recordId as parameter
        return $this->handleTagResponse(
        $tagsOperations->removeTagsFromMultipleRecords(
            $recordId,
            $this->module_api_name,
            $paramInstance)
        );
    }

    /**
     * @param array $recordIds
     * @param array $tagNames
     * @return array
     * @throws SDKException
     */
    public function addTagsToMultipleRecords( array $recordIds, array $tagNames): array
    {
        //Get instance of TagsOperations Class
        $tagsOperations = new TagsOperations();

        //Get instance of ParameterMap Class
        $paramInstance = new ParameterMap();

        foreach($tagNames as $tagName)
        {
            $paramInstance->add(AddTagsToMultipleRecordsParam::tagNames(), $tagName);
        }

        foreach($recordIds as $recordId)
        {
            $paramInstance->add(AddTagsToMultipleRecordsParam::ids(), $recordId);
        }

        $paramInstance->add(AddTagsToMultipleRecordsParam::overWrite(), "false");

        return $this->handleTagResponse(
            $tagsOperations->addTagsToMultipleRecords($this->module_api_name,$paramInstance)
        );
    }

    /**
     * @param array $recordIds
     * @param array $tagNames
     * @return array
     * @throws SDKException
     */
    public function removeTagsFromMultipleRecords(array $recordIds, array $tagNames): array
    {

        //Get instance of TagsOperations Class
        $tagsOperations = new TagsOperations();

        $paramInstance = new ParameterMap();

        foreach($tagNames as $tagName)
        {
            $paramInstance->add(RemoveTagsFromMultipleRecordsParam::tagNames(), $tagName);
        }

        foreach($recordIds as $recordId)
        {
            $paramInstance->add(RemoveTagsFromMultipleRecordsParam::ids(), $recordId);
        }

        //Call RemoveTagsFromMultipleRecordsParam method that takes paramInstance, moduleAPIName as parameter
        return $this->handleTagResponse(
            $tagsOperations->removeTagsFromMultipleRecords(
                $this->module_api_name,
                $paramInstance
            )
        );
    }

    /**
     * @param string $tagId
     * @return array
     * @throws SDKException
     */
    public function getRecordCountForTag(string $tagId): array
    {
        //Get instance of TagsOperations Class
        $tagsOperations = new TagsOperations();

        //Get instance of ParameterMap Class
        $paramInstance = new ParameterMap();

        $paramInstance->add(GetRecordCountForTagParam::module(), $this->module_api_name);

        //Call getRecordCountForTag method that takes paramInstance and tagId as parameter
        return $this->handleTagResponse(
            $tagsOperations->getRecordCountForTag($tagId,$paramInstance)
        );
    }

    private function handleTagResponse($response): array
    {
        if ($response !== null) {
            if (in_array($response->getStatusCode(), array(204, 304), true)) {
                logger()->error($response->getStatusCode() === 204 ? "No Content" : "Not Modified");

                return [];
            }

            if ($response->isExpected()) {
                $responseHandler = $response->getObject();

                if ($responseHandler instanceof TagResponseWrapper) {
                    return $responseHandler->getTags();
                }

                if ($responseHandler instanceof APIException) {
                    logger()->error($responseHandler->getMessage());
                }
            }
        }

        return [];
    }
}
