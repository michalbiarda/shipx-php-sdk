<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

class Response200WithJsonArrayBody extends AbstractResponse
{
    public function getStatusCode(): int
    {
        return 200;
    }

    public function getHeaderLine($name): string
    {
        if ($name === 'Content-Type') {
            return 'application/json; charset=UTF-8';
        }
        return '';
    }

    public function getBody(): StreamWithJsonArrayContents
    {
        return new StreamWithJsonArrayContents();
    }
}
