<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Client;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use MB\ShipXSDK\Exception\HttpClientException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use Psr\Http\Message\StreamFactoryInterface;
use function json_encode;

class RequestSender implements RequestSenderInterface
{
    private ClientInterface $httpClient;

    private RequestFactoryInterface $requestFactory;

    private StreamFactoryInterface $streamFactory;

    private ?RequestInterface $lastHttpRequest;

    public function __construct(
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null
    ) {
        $this->httpClient = $httpClient ?? Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
    }

    public function send(string $httpMethod, string $uri, array $headers, array $payload): ResponseInterface
    {
        try {
            $httpRequest = $this->requestFactory->createRequest($httpMethod, $uri);
            foreach ($headers as $name => $value) {
                $httpRequest = $httpRequest->withHeader($name, $value);
            }
            if (!empty($payload)) {
                $stream = $this->streamFactory->createStream(json_encode($payload));
                $httpRequest = $httpRequest->withBody($stream);
            }
            $this->lastHttpRequest = $httpRequest;
            $httpResponse = $this->httpClient->sendRequest($httpRequest);
        } catch (ClientExceptionInterface $e) {
            throw new HttpClientException($e->getMessage(), $e->getCode(), $e);
        }
        return $httpResponse;
    }

    public function getLastHttpRequest(): ?RequestInterface
    {
        return $this->lastHttpRequest;
    }
}
