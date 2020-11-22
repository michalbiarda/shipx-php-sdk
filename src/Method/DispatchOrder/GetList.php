<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method\DispatchOrder;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithFilterableResultsInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Method\WithPaginatedResultsInterface;
use MB\ShipXSDK\Method\WithSortableResultsInterface;
use MB\ShipXSDK\Model\DispatchOrderCollection;
use MB\ShipXSDK\Request\Request;

class GetList implements
    MethodInterface,
    WithJsonResponseInterface,
    WithAuthorizationInterface,
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
        return '/v1/organizations/:organization_id/dispatch_orders';
    }

    public function getResponsePayloadModelName(): string
    {
        return DispatchOrderCollection::class;
    }

    public function getSortableFields(): array
    {
        return [
            'id',
            'created_at',
            'address',
            'post_code',
            'country_code',
            'shipment_id',
            'tracking_number'
        ];
    }

    public function getFilters(): array
    {
        return [
            'id',
            'created_at',
            'created_at_gteq',
            'created_at_lteq',
            'status',
            'address',
            'post_code',
            'country_code',
            'city',
            'shipment_id',
            'tracking_number',
            'shipment_service',
            'status'
        ];
    }
}
