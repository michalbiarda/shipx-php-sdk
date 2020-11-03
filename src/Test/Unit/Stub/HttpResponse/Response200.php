<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

class Response200 extends OkResponse
{
    public function getStatusCode()
    {
        return 200;
    }
}
