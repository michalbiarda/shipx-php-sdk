<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method\Shipment;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Request\Request;

class Cancel implements
    MethodInterface,
    WithAuthorizationInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_DELETE;
    }

    public function getUriTemplate(): string
    {
        return '/v1/shipments/:shipment_id';
    }
}
