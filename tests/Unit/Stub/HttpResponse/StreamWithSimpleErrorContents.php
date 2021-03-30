<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

use function json_encode;

class StreamWithSimpleErrorContents extends AbstractStreamWithContents
{
    public function getContents()
    {
        return json_encode([
            'status' => 400,
            'key' => 'some_error_code',
            'error' => 'Some error message',
        ]);
    }
}
