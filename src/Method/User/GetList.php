<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method\User;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithFilterableResultsInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Method\WithPaginatedResultsInterface;
use MB\ShipXSDK\Method\WithSortableResultsInterface;
use MB\ShipXSDK\Model\UserCollection;
use MB\ShipXSDK\Request\Request;

/**
 * @todo Check why this method is constantly producing 404 response
 */
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
        return '/v1/organizations/:organization_id/users';
    }

    public function getResponsePayloadModelName(): string
    {
        return UserCollection::class;
    }

    public function getSortableFields(): array
    {
        return ['id', 'email', 'phone', 'full_name', 'created_at'];
    }

    public function getFilters(): array
    {
        return ['q'];
    }
}
