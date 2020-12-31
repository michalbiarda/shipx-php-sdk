<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method\Organization;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithFilterableResultsInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Method\WithPaginatedResultsInterface;
use MB\ShipXSDK\Method\WithSortableResultsInterface;
use MB\ShipXSDK\Model\OrganizationCollection;
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
        return '/v1/organizations';
    }

    public function getResponsePayloadModelName(): string
    {
        return OrganizationCollection::class;
    }

    public function getSortableFields(): array
    {
        return ['id', 'name', 'tax_id', 'address_street', 'created_at'];
    }

    public function getFilters(): array
    {
        return ['tax_id', 'name', 'address_street', 'owner_full_name', 'application_name'];
    }
}
