<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

class Response200WithBinaryBody extends AbstractResponse
{
    public function getStatusCode(): int
    {
        return 200;
    }

    public function getHeaderLine($name): string
    {
        switch ($name) {
            case 'Content-Transfer-Encoding':
                return 'binary';
            case 'Content-Type':
                return 'application/pdf';
            default:
                return '';
        }
    }

    public function getBody(): StreamWithBinaryContents
    {
        return new StreamWithBinaryContents();
    }
}
