<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method\Shipment;

use MB\ShipXSDK\Model\ShipmentOfferCollectionForm;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithJsonRequestInterface;
use MB\ShipXSDK\Request\Request;

class BuyBulk implements
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
        return '/v1/organizations/:organization_id/shipments/bulk_buy';
    }

    public function getRequestPayloadModelName(): string
    {
        return ShipmentOfferCollectionForm::class;
    }
}
