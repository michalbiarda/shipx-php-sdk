<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

class Response400 extends ErrorResponse
{
    public function getStatusCode()
    {
        return 400;
    }
}
