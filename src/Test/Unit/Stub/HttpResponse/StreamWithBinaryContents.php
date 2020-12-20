<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

class StreamWithBinaryContents extends AbstractStreamWithContents
{
    public function getContents(): string
    {
        return 'some binary content';
    }
}
