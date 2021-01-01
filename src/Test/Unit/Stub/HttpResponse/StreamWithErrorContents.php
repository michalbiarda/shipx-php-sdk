<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

use function json_encode;

class StreamWithErrorContents extends AbstractStreamWithContents
{
    private int $statusCode;

    public function __construct(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function getContents()
    {
        return json_encode([
            'status' => $this->statusCode,
            'error' => 'some_error_code',
            'message' => 'Some error message',
            'details' => [
                'some' => 'details'
            ]
        ]);
    }
}
