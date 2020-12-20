<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Response\HttpResponseProcessor;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithBinaryResponseInterface;
use MB\ShipXSDK\Model\BinaryContent;
use MB\ShipXSDK\Response\Response;
use Psr\Http\Message\ResponseInterface;

class BinaryContentProcessor implements ProcessorInterface
{
    public function run(MethodInterface $method, ResponseInterface $httpResponse): ?Response
    {
        if ($method instanceof WithBinaryResponseInterface &&
            $httpResponse->getStatusCode() === 200 &&
            $httpResponse->getHeaderLine('Content-Transfer-Encoding') === 'binary'
        ) {
            return new Response(true, new BinaryContent([
                'stream' => $httpResponse->getBody(),
                'content_type' => $httpResponse->getHeaderLine('Content-Type')
            ]));
        }
        return null;
    }
}
