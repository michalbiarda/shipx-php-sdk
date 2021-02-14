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
use Psr\Http\Message\ResponseInterface;

class ErrorProcessor extends AbstractJsonContentProcessor
{
    protected function getHttpStatusCodes(): array
    {
        return [200, 400, 401, 403, 404, 500];
    }

    protected function getStatus(): bool
    {
        return false;
    }

    protected function getPayload(
        MethodInterface $method,
        array $data,
        ResponseInterface $httpResponse
    ): ?DataTransferObject {
        if ($httpResponse->getStatusCode() === 200) {
            // This handles inconsistency in ShipX API. Some errors have HTTP status code 200 and error data in body.
            if (isset($data['status']) && $data['status'] !== 200 && isset($data['key']) && isset($data['error'])) {
                return new Error([
                    'status' => $data['status'],
                    'error' => $data['key'],
                    'message' => $data['error']
                ]);
            }
            return null;
        }
        return new Error($data);
    }
}
