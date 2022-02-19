<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
abstract class AbstractResponse implements ResponseInterface
{
    public function getProtocolVersion()
    {
        return '1.1';
    }

    public function withProtocolVersion($version)
    {
        return $this;
    }

    public function getHeaders()
    {
        return [];
    }

    public function hasHeader($name)
    {
        return false;
    }

    public function getHeader($name)
    {
        return [];
    }

    abstract public function getHeaderLine($name);

    public function withHeader($name, $value)
    {
        return $this;
    }

    public function withAddedHeader($name, $value)
    {
        return $this;
    }

    public function withoutHeader($name)
    {
        return $this;
    }

    abstract public function getBody();

    public function withBody(StreamInterface $body)
    {
        return $this;
    }

    abstract public function getStatusCode();

    public function withStatus($code, $reasonPhrase = '')
    {
        return $this;
    }

    public function getReasonPhrase()
    {
        return '';
    }
}
