<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method\Shipment;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithBinaryResponseInterface;
use MB\ShipXSDK\Method\WithQueryParamsInterface;
use MB\ShipXSDK\Request\Request;

class GetLabels implements
    MethodInterface,
    WithBinaryResponseInterface,
    WithAuthorizationInterface,
    WithQueryParamsInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getUriTemplate(): string
    {
        return '/v1/organizations/:organization_id/shipments/labels';
    }

    public function getRequiredQueryParams(): array
    {
        return ['shipment_ids'];
    }

    public function getOptionalQueryParams(): array
    {
        return ['format', 'type'];
    }
}
