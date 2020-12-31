<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

use function json_encode;

class StreamWithJsonArrayContents extends AbstractStreamWithContents
{
    public function getContents(): string
    {
        return json_encode([
            [
                'foo' => 'far1',
                'bar' => 'boo1'
            ],
            [
                'foo' => 'far2',
                'bar' => 'boo2'
            ]
        ]);
    }
}
