<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Client;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Request\RequestFactory;
use MB\ShipXSDK\Response\Response;
use MB\ShipXSDK\Response\ResponseFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client
{
    private string $baseUri;

    private ?string $authToken;

    private RequestSenderInterface $requestSender;

    private RequestFactory $requestFactory;

    private ResponseFactory $responseFactory;

    private ?ResponseInterface $lastHttpResponse;

    public function __construct(
        string $baseUri,
        ?string $authToken = null,
        ?RequestSenderInterface $requestSender = null,
        ?RequestFactory $requestFactory = null,
        ?ResponseFactory $responseFactory = null
    ) {
        $this->baseUri = $baseUri;
        $this->authToken = $authToken;
        $this->requestSender = $requestSender ?? new RequestSender();
        $this->requestFactory = $requestFactory ?? new RequestFactory();
        $this->responseFactory = $responseFactory ?? new ResponseFactory();
    }

    public function callMethod(
        MethodInterface $method,
        array $uriParams = [],
        array $queryParams = [],
        ?DataTransferObject $payload = null
    ): Response {
        $request = $this->requestFactory->create(
            $method,
            $uriParams,
            $queryParams,
            $payload,
            $method instanceof WithAuthorizationInterface ? $this->authToken : null
        );
        $httpResponse = $this->requestSender->send(
            $request->getMethod(),
            $this->baseUri . $request->getUri(),
            $request->getHeaders() ?? [],
            $request->getPayload() ?? []
        );
        $this->lastHttpResponse = $httpResponse;
        return $this->responseFactory->create($method, $httpResponse);
    }

    public function getLastHttpRequest(): ?RequestInterface
    {
        return $this->requestSender->getLastHttpRequest();
    }

    public function getLastHttpResponse(): ?ResponseInterface
    {
        return $this->lastHttpResponse;
    }
}
