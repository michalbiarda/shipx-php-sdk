<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

abstract class AbstractResponse implements ResponseInterface
{
    public function getProtocolVersion()
    {
    }

    public function withProtocolVersion($version)
    {
    }

    public function getHeaders()
    {
    }

    public function hasHeader($name)
    {
    }

    public function getHeader($name)
    {
    }

    abstract public function getHeaderLine($name);

    public function withHeader($name, $value)
    {
    }

    public function withAddedHeader($name, $value)
    {
    }

    public function withoutHeader($name)
    {
    }

    abstract public function getBody();

    public function withBody(StreamInterface $body)
    {
    }

    abstract public function getStatusCode();

    public function withStatus($code, $reasonPhrase = '')
    {
    }

    public function getReasonPhrase()
    {
    }
}
