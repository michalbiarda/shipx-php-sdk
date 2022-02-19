<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Response;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Model\Error;
use Psr\Http\Message\ResponseInterface;

class ResponseFactory
{
    private HttpResponseProcessor $responseProcessor;

    public function __construct(?HttpResponseProcessor $responseProcessor = null)
    {
        if (is_null($responseProcessor)) {
            $responseProcessor = new HttpResponseProcessor();
        }
        $this->responseProcessor = $responseProcessor;
    }

    public function create(MethodInterface $method, ResponseInterface $httpResponse): Response
    {
        $response = $this->responseProcessor->process($method, $httpResponse);
        return $response ?: new Response(
            false,
            new Error(
                [
                'status' => -1,
                'error' => 'unprocessed_response',
                'message' => 'The response did not match any processor.',
                'details' => [
                'http_response' => $httpResponse
                ]
                ]
            )
        );
    }
}
