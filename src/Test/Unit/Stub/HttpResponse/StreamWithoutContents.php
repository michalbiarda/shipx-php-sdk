<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

class StreamWithoutContents extends AbstractStreamWithContents
{
    public function getContents()
    {
        return '';
    }
}
