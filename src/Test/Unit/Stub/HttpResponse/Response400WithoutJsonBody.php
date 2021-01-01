<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

class Response400WithoutJsonBody extends AbstractResponse
{
    public function getStatusCode()
    {
        return 400;
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
        return new StreamWithoutContents();
    }
}
