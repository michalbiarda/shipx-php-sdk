<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Response\HttpResponseProcessor;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Response\Response;
use Psr\Http\Message\ResponseInterface;

class NoContentProcessor implements ProcessorInterface
{
    public function run(MethodInterface $method, ResponseInterface $httpResponse): ?Response
    {
        if ($httpResponse->getStatusCode() === 204 && !$method instanceof WithJsonResponseInterface) {
            return new Response(true, null);
        }
        return null;
    }
}
