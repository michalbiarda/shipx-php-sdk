<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Client;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Request\Request;
use MB\ShipXSDK\Request\RequestFactory;
use MB\ShipXSDK\Response\HttpResponseProcessor;
use MB\ShipXSDK\Response\Response;
use MB\ShipXSDK\Response\ResponseFactory;

class Client
{
    private string $baseUri;

    private ?string $authToken;

    private ?HttpClient $httpClient;

    private ?RequestFactory $requestFactory;

    private ?ResponseFactory $responseFactory;

    public function __construct(
        string $baseUri,
        ?string $authToken = null,
        ?HttpClient $httpClient = null,
        ?RequestFactory $requestFactory = null,
        ?ResponseFactory $responseFactory = null
    ) {
        $this->baseUri = $baseUri;
        $this->authToken = $authToken;
        if (is_null($httpClient)) {
            $httpClient = new HttpClient();
        }
        if (is_null($requestFactory)) {
            $requestFactory = new RequestFactory();
        }
        if (is_null($responseFactory)) {
            $responseFactory = new ResponseFactory(new HttpResponseProcessor());
        }
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->responseFactory = $responseFactory;
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
        } catch (ClientException|ServerException $e) {
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
