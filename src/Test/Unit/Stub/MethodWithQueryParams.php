<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Test\Unit\Stub;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithQueryParamsInterface;

class MethodWithQueryParams implements MethodInterface, WithQueryParamsInterface
{
    public function getRequestMethod(): string
    {
        return 'GET';
    }

    public function getUriTemplate(): string
    {
        return '/i/have/query/params';
    }

    public function getRequiredQueryParams(): array
    {
        return ['foo', 'bar'];
    }

    public function getOptionalQueryParams(): array
    {
        return ['boo', 'far'];
    }
}
