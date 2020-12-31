<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

class Response400WithoutJsonHeader extends AbstractResponse
{
    public function getStatusCode()
    {
        return 400;
    }

    public function getHeaderLine($name)
    {
        return '';
    }

    public function getBody()
    {
        return new StreamWithJsonFooBarContents();
    }
}
