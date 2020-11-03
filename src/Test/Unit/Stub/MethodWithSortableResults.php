<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Test\Unit\Stub;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithSortableResultsInterface;

class MethodWithSortableResults implements MethodInterface, WithSortableResultsInterface
{
    public function getRequestMethod(): string
    {
        return 'GET';
    }

    public function getUriTemplate(): string
    {
        return '/i/have/sortable/results';
    }

    public function getSortableFields(): array
    {
        return ['foo', 'bar'];
    }
}
