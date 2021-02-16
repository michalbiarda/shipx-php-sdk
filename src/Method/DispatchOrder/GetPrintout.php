<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method\DispatchOrder;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithBinaryResponseInterface;
use MB\ShipXSDK\Method\WithQueryParamsInterface;
use MB\ShipXSDK\Request\Request;

class GetPrintout implements
    MethodInterface,
    WithAuthorizationInterface,
    WithQueryParamsInterface,
    WithBinaryResponseInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getUriTemplate(): string
    {
        return '/v1/organizations/:organization_id/dispatch_orders/printouts';
    }

    public function getRequiredQueryParams(): array
    {
        return ['dispatch_order_id'];
    }

    public function getOptionalQueryParams(): array
    {
        return ['format'];
    }
}
