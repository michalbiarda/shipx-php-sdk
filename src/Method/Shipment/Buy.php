<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method\Shipment;

use MB\ShipXSDK\Model\ShipmentBuyForm;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithJsonRequestInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Model\Shipment;
use MB\ShipXSDK\Request\Request;

class Buy implements
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
        return '/v1/shipments/:shipment_id/buy';
    }

    public function getRequestPayloadModelName(): string
    {
        return ShipmentBuyForm::class;
    }

    public function getResponsePayloadModelName(): string
    {
        return Shipment::class;
    }
}
