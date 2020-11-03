<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

use function json_encode;

class StreamWithJsonFooBarContents extends AbstractStreamWithContents
{
    public function getContents()
    {
        return json_encode([
            'foo' => 'far',
            'bar' => 'boo'
        ]);
    }
}
