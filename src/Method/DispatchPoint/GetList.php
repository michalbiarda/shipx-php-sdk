<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method\DispatchPoint;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithFilterableResultsInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Method\WithPaginatedResultsInterface;
use MB\ShipXSDK\Method\WithSortableResultsInterface;
use MB\ShipXSDK\Model\DispatchPointCollection;
use MB\ShipXSDK\Request\Request;

class GetList implements
    MethodInterface,
    WithJsonResponseInterface,
    WithPaginatedResultsInterface,
    WithAuthorizationInterface,
    WithSortableResultsInterface,
    WithFilterableResultsInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getUriTemplate(): string
    {
        return '/v1/organizations/:organization_id/dispatch_points';
    }

    public function getResponsePayloadModelName(): string
    {
        return DispatchPointCollection::class;
    }

    public function getFilters(): array
    {
        return [
            'id',
            'name',
            'email',
            'phone',
            'address',
            'post_code',
            'country_code',
            'city'
        ];
    }

    public function getSortableFields(): array
    {
        return [
            'id',
            'name',
            'email',
            'phone',
            'address',
            'post_code',
            'country_code'
        ];
    }
}
