<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Client;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Request\Request;
use MB\ShipXSDK\Request\RequestFactory;
use MB\ShipXSDK\Response\Response;
use MB\ShipXSDK\Response\ResponseFactory;

class Client
{
    private HttpClient $httpClient;

    private RequestFactory $requestFactory;

    private ResponseFactory $responseFactory;

    private string $baseUri;

    private ?string $authToken;

    public function __construct(
        HttpClient $httpClient,
        RequestFactory $requestFactory, 
        ResponseFactory $responseFactory,
        string $baseUri,
        ?string $authToken
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->responseFactory = $responseFactory;
        $this->baseUri = $baseUri;
        $this->authToken = $authToken;
    }

    public function callMethod(
        MethodInterface $method,
        array $uriParams = [],
        array $queryParams = [],
        ?DataTransferObject $payload = null
    ): Response
    {
        $request = $this->requestFactory->create(
            $method,
            $uriParams,
            $queryParams,
            $payload,
            $method instanceof WithAuthorizationInterface ? $this->authToken : null
        );
        try {
            $httpResponse = $this->httpClient->request(
                $request->getMethod(),
                $this->baseUri . $request->getUri(),
                $this->buildOptions($request)
            );
        } catch (ClientException $e) {
            $httpResponse = $e->getResponse();
        }
        return $this->responseFactory->create($method, $httpResponse);
    }

    private function buildOptions(Request $request): array
    {
        $options = [];
        if ($request->getHeaders()) {
            $options['headers'] = $request->getHeaders();
        }
        if ($request->getPayload()) {
            $options['json'] = $request->getPayload();
        }
        return $options;
    }
}
