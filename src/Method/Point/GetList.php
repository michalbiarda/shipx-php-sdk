<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method\Point;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithFilterableResultsInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Method\WithPaginatedResultsInterface;
use MB\ShipXSDK\Method\WithSortableResultsInterface;
use MB\ShipXSDK\Model\PointCollection;
use MB\ShipXSDK\Request\Request;

class GetList implements
    MethodInterface,
    WithJsonResponseInterface,
    WithSortableResultsInterface,
    WithFilterableResultsInterface,
    WithPaginatedResultsInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getUriTemplate(): string
    {
        return '/v1/points';
    }

    public function getResponsePayloadModelName(): string
    {
        return PointCollection::class;
    }

    public function getSortableFields(): array
    {
        return ['name', 'distance_to_relative_point', 'status'];
    }

    public function getFilters(): array
    {
        return [
            'name',
            'type',
            'functions',
            'partner_id',
            'is_next',
            'payment_available',
            'post_code',
            'city',
            'province',
            'virtual',
            'updated_from' ,
            'updated_to' ,
            'relative_point',
            'relative_post_code',
            'max_distance',
            'limit'
        ];
    }
}
