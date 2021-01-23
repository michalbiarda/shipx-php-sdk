<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method\Shipment;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Model\Shipment;
use MB\ShipXSDK\Request\Request;

class Read implements
    MethodInterface,
    WithJsonResponseInterface,
    WithAuthorizationInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getUriTemplate(): string
    {
        return '/v1/shipments/:id';
    }

    public function getResponsePayloadModelName(): string
    {
        return Shipment::class;
    }
}
