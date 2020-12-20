<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Test\Unit\Stub;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithJsonArrayResponseInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;

class MethodWithArrayResponsePayload implements
    MethodInterface,
    WithJsonResponseInterface,
    WithJsonArrayResponseInterface
{
    public function getRequestMethod(): string
    {
        return 'GET';
    }

    public function getUriTemplate(): string
    {
        return '/some/uri';
    }

    public function getResponsePayloadModelName(): string
    {
        return ModelWithItemsArray::class;
    }
}
