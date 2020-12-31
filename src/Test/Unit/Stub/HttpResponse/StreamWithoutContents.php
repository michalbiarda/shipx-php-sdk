<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

class StreamWithoutContents extends AbstractStreamWithContents
{
    public function getContents()
    {
        return '';
    }
}
