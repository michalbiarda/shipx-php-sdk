<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

class OkResponse extends AbstractResponse
{
    private int $statusCode;

    public function __construct(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function getHeaderLine($name)
    {
        if ($name === 'Content-Type') {
            return 'application/json; charset=UTF-8';
        }
        return '';
    }

    public function getBody()
    {
        return new StreamWithJsonFooBarContents();
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
