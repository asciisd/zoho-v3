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

    private function handleModuleResponse($response): array
    {
        if ($response != null) {
            if (in_array($response->getStatusCode(), array(204, 304))) {
                logger()->error($response->getStatusCode() == 204 ? "Zoho SDK API | ManagesModules | handleModuleResponse | No Content\n" : "Zoho SDK API | ManagesModules | handleModuleResponse | Not Modified\n");

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

    public function getModule()
    {
        return $this->handleModuleResponse(
            (new ModulesOperations())->getModule($this->module_api_name)
        )[0];
    }
}
