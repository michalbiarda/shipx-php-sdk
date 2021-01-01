<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Response\HttpResponseProcessor;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithJsonArrayResponseInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use Psr\Http\Message\ResponseInterface;

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

    protected function getPayload(
        MethodInterface $method,
        array $data,
        ResponseInterface $httpResponse
    ): ?DataTransferObject
    {
        if (!$method instanceof WithJsonResponseInterface) {
            return null;
        }
        if ($method instanceof WithJsonArrayResponseInterface) {
            $data = ['items' => $data];
        }
        $modelClass = $method->getResponsePayloadModelName();
        return new $modelClass($data);
    }
}
