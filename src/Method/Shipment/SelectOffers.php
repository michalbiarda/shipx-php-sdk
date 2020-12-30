<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method\Shipment;

use MB\ShipXSDK\Form\SelectShipmentOffers;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithJsonRequestInterface;
use MB\ShipXSDK\Request\Request;

class SelectOffers implements
    MethodInterface,
    WithJsonRequestInterface,
    WithAuthorizationInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_POST;
    }

    public function getUriTemplate(): string
    {
        return '/v1/organizations/:organization_id/shipments/select_offers';
    }

    public function getRequestPayloadModelName(): string
    {
        return SelectShipmentOffers::class;
    }
}
