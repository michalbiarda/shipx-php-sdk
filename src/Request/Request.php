<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Request;

class Request
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';

    private string $method;

    private string $uri;

    private ?array $payload;

    private ?array $headers;

    public function __construct(string $method, string $uri, ?array $payload, ?array $headers)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->payload = $payload;
        $this->headers = $headers;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getPayload(): ?array
    {
        return $this->payload;
    }

    public function getHeaders(): ?array
    {
        return $this->headers;
    }
}
