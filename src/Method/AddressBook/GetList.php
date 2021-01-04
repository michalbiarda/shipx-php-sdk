<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method\AddressBook;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithFilterableResultsInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Method\WithPaginatedResultsInterface;
use MB\ShipXSDK\Method\WithSortableResultsInterface;
use MB\ShipXSDK\Model\AddressBookCollection;
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
        return '/v1/organizations/:organization_id/address_books';
    }

    public function getResponsePayloadModelName(): string
    {
        return AddressBookCollection::class;
    }

    public function getSortableFields(): array
    {
        return [
            'id',
            'name',
            'first_name',
            'last_name',
            'email',
            'phone',
            'sender_parcel',
            'sender_courier',
            'sender_letter',
            'kind',
            'created_at',
            'company_name',
            'preferred_dropoff_point'
        ];
    }

    public function getFilters(): array
    {
        return [
            'id',
            'name',
            'first_name',
            'last_name',
            'email',
            'phone',
            'sender_parcel',
            'sender_courier',
            'sender_letter',
            'kind',
            'created_at',
            'created_at_gteq',
            'created_at_lteq',
            'main_address_street',
            'delivery_address_street',
            'company_name',
            'preferred_dropoff_point'
        ];
    }
}
