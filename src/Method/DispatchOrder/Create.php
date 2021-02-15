<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method\DispatchOrder;

use MB\ShipXSDK\Model\DispatchOrderForm;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithJsonRequestInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Model\DispatchOrder;
use MB\ShipXSDK\Request\Request;

class Create implements
    MethodInterface,
    WithJsonRequestInterface,
    WithJsonResponseInterface,
    WithAuthorizationInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_POST;
    }

    public function getUriTemplate(): string
    {
        return '/v1/organizations/:organization_id/dispatch_orders';
    }

    public function getRequestPayloadModelName(): string
    {
        return DispatchOrderForm::class;
    }

    public function getResponsePayloadModelName(): string
    {
        return DispatchOrder::class;
    }
}
