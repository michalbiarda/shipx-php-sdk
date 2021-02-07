<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

class Response200WithErrorData extends AbstractResponse
{
    public function getHeaderLine($name)
    {
        if ($name === 'Content-Type') {
            return 'application/json; charset=UTF-8';
        }
        return '';
    }

    public function getBody()
    {
        return new StreamWithSimpleErrorContents();
    }

    public function getStatusCode()
    {
        return 200;
    }
}
