<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Stub;

use MB\ShipXSDK\Method\MethodInterface;

class MethodWithoutUriParams implements MethodInterface
{
    public function getRequestMethod(): string
    {
        return 'GET';
    }

    public function getUriTemplate(): string
    {
        return '/some/uri/without/params';
    }
}
