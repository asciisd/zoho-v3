<?php

namespace Asciisd\Zoho\Concerns;

use com\zoho\crm\api\modules\APIException;
use com\zoho\crm\api\modules\ModulesOperations;
use com\zoho\crm\api\modules\ResponseWrapper as ModulesResponseWrapper;

trait ManagesModules
{
    public function getAllModules(): array
    {
        return $this->handleModuleResponse(
            (new ModulesOperations())->getModules()
        );
    }

    public function getModule()
    {
        return $this->handleModuleResponse(
            (new ModulesOperations())->getModule($this->module_api_name)
        )[0];
    }

    private function handleModuleResponse($response): array
    {
        if ($response != null) {
            if (in_array($response->getStatusCode(), array(204, 304))) {
                logger()->error($response->getStatusCode() == 204 ? "No Content\n" : "Not Modified\n");

                return [];
            }

            $responseHandler = $response->getObject();

            if ($responseHandler instanceof ModulesResponseWrapper) {
                return $responseHandler->getModules();
            } elseif ($responseHandler instanceof APIException) {
                logger()->error($responseHandler->getMessage());
            }
        }

        return [];
    }
}
