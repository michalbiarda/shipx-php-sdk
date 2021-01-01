<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method\Shipment;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithFilterableResultsInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Method\WithPaginatedResultsInterface;
use MB\ShipXSDK\Method\WithSortableResultsInterface;
use MB\ShipXSDK\Model\ShipmentCollection;
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
        return '/v1/organizations/:organization_id/shipments';
    }

    public function getResponsePayloadModelName(): string
    {
        return ShipmentCollection::class;
    }

    public function getFilters(): array
    {
        return [
            'id',
            'created_at',
            'created_at_gteq',
            'created_at_lteq',
            'tracking_number',
            'tracking_number_cont',
            'status',
            'service',
            'carrier',
            'insurance_amount_gteq',
            'insurance_amount_lteq',
            'cod_amount_gteq',
            'cod_amount_lteq',
            'receiver_name',
            'receiver_address',
            'receiver_city',
            'receiver_post_code',
            'receiver_country_code',
            'receiver_phone',
            'receiver_email',
            'sender_name',
            'sender_address',
            'sender_city',
            'sender_post_code',
            'sender_country_code',
            'sender_phone',
            'sender_email',
            'monitoring',
            'external_customer_id',
            'sending_method',
            'only_choice_active_offers',
            'offers_status'
        ];
    }

    public function getSortableFields(): array
    {
        return [
            'id',
            'created_at',
            'tracking_number',
            'service',
            'status',
            'insurance_amount',
            'cod_amount',
            'external_customer_id'
        ];
    }
}
