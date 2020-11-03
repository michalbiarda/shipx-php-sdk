<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Test\Unit\Stub;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithJsonRequestInterface;

class MethodWithPayload implements MethodInterface, WithJsonRequestInterface
{
    public function getRequestMethod(): string
    {
        return 'GET';
    }

    public function getUriTemplate(): string
    {
        return '/some/uri';
    }

    public function getRequestPayloadModelName(): string
    {
        return ModelWithFooBarSimpleProperties::class;
    }
}
