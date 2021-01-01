<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Response\HttpResponseProcessor;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Response\Response;
use Psr\Http\Message\ResponseInterface;

use function json_decode;

abstract class AbstractJsonContentProcessor implements ProcessorInterface
{
    public function run(MethodInterface $method, ResponseInterface $httpResponse): ?Response
    {
        if (in_array($httpResponse->getStatusCode(), $this->getHttpStatusCodes())) {
            $contentType = explode('; ', $httpResponse->getHeaderLine('Content-Type'));
            $mediaType = reset($contentType);
            if ($mediaType === 'application/json') {
                $httpResponse->getBody()->rewind();
                $data = json_decode($httpResponse->getBody()->getContents(), true);
                if (!is_null($data)) {
                    $payload = $this->getPayload($method, $data, $httpResponse);
                    if ($payload) {
                        return new Response($this->getStatus(), $payload);
                    }
                }
            }
        }
        return null;
    }

    /**
     * @return int[]
     */
    abstract protected function getHttpStatusCodes(): array;

    abstract protected function getStatus(): bool;

    abstract protected function getPayload(
        MethodInterface $method,
        array $data,
        ResponseInterface $httpResponse
    ): ?DataTransferObject;
}
