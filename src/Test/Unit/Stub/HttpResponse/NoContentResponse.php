<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

class NoContentResponse extends AbstractResponse
{
    public function getBody()
    {
        return new StreamWithoutContents();
    }

    public function getStatusCode()
    {
        return 204;
    }

    public function getHeaderLine($name)
    {
        return '';
    }
}
