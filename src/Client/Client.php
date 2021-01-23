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
use MB\ShipXSDK\Request\Request;
use MB\ShipXSDK\Request\RequestFactory;
use MB\ShipXSDK\Response\Response;
use MB\ShipXSDK\Response\ResponseFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use function is_null;

class Client
{
    public const DEFAULT_TIMEOUT = 30;

    private string $baseUri;

    private ?string $authToken;

    private RequestSender $requestSender;

    private RequestFactory $requestFactory;

    private ResponseFactory $responseFactory;

    private OptionsFactory $optionsFactory;

    private ?RequestInterface $lastHttpRequest;

    private ?ResponseInterface $lastHttpResponse;

    private int $repeatsOnTimeout;

    private ?int $timeout;

    public function __construct(
        string $baseUri,
        ?string $authToken = null,
        int $repeatsOnTimeout = 0,
        ?int $timeout = null,
        ?RequestSender $requestSender = null,
        ?RequestFactory $requestFactory = null,
        ?ResponseFactory $responseFactory = null,
        ?OptionsFactory $optionsFactory = null
    ) {
        $this->baseUri = $baseUri;
        $this->authToken = $authToken;
        if (is_null($requestSender)) {
            $requestSender = new RequestSender();
        }
        if (is_null($requestFactory)) {
            $requestFactory = new RequestFactory();
        }
        if (is_null($responseFactory)) {
            $responseFactory = new ResponseFactory();
        }
        if (is_null($optionsFactory)) {
            $optionsFactory = new OptionsFactory();
        }
        $this->repeatsOnTimeout = $repeatsOnTimeout;
        $this->timeout = $timeout;
        $this->requestSender = $requestSender;
        $this->requestFactory = $requestFactory;
        $this->responseFactory = $responseFactory;
        $this->optionsFactory = $optionsFactory;
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
            $this->buildOptions($request, $this->timeout),
            $this->repeatsOnTimeout
        );
        return $this->responseFactory->create($method, $httpResponse);
    }

    public function getLastHttpRequest(): ?RequestInterface
    {
        return $this->lastHttpRequest;
    }

    public function getLastHttpResponse(): ?ResponseInterface
    {
        return $this->lastHttpResponse;
    }

    private function buildOptions(Request $request, ?int $timeout = null): array
    {
        return $this->optionsFactory->create(
            $request,
            [
                function (RequestInterface $request) {
                    $this->lastHttpRequest = $request;
                    return $request;
                }
            ],
            [
                function (ResponseInterface $response) {
                    $this->lastHttpResponse = $response;
                    return $response;
                }
            ],
            is_null($timeout) ? static::DEFAULT_TIMEOUT : $timeout
        );
    }
}
