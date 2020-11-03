<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Response\HttpResponseProcessor;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;

class OkProcessor extends AbstractJsonContentProcessor
{
    protected function getHttpStatusCodes(): array
    {
        return [200, 201];
    }

    protected function getStatus(): bool
    {
        return true;
    }

    protected function getPayload(MethodInterface $method, array $data): ?DataTransferObject
    {
        if (!$method instanceof WithJsonResponseInterface) {
            return null;
        }
        $modelClass = $method->getResponsePayloadModelName();
        return new $modelClass($data);
    }
}
