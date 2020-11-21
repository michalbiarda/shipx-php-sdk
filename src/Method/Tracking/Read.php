<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method\Tracking;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Model\Tracking;
use MB\ShipXSDK\Request\Request;

class Read implements
    MethodInterface,
    WithJsonResponseInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getUriTemplate(): string
    {
        return '/v1/tracking/:tracking_number';
    }

    public function getResponsePayloadModelName(): string
    {
        return Tracking::class;
    }
}
