<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Test\Unit\Stub;

use MB\ShipXSDK\Method\MethodInterface;

class MethodWithoutAuthorizationNeeded implements MethodInterface
{
    public function getRequestMethod(): string
    {
        return 'GET';
    }

    public function getUriTemplate(): string
    {
        return '/some/uri';
    }
}
