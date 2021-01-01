<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Response\HttpResponseProcessor;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Model\Error;

class ErrorProcessor extends AbstractJsonContentProcessor
{
    protected function getHttpStatusCodes(): array
    {
        return [400, 401, 403, 404, 500];
    }

    protected function getStatus(): bool
    {
        return false;
    }

    protected function getPayload(MethodInterface $method, array $data): ?DataTransferObject
    {
        return new Error($data);
    }
}
