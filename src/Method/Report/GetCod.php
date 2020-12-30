<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method\Report;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithBinaryResponseInterface;
use MB\ShipXSDK\Method\WithQueryParamsInterface;
use MB\ShipXSDK\Request\Request;

class GetCod implements
    MethodInterface,
    WithQueryParamsInterface,
    WithAuthorizationInterface,
    WithBinaryResponseInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getUriTemplate(): string
    {
        return '/v1/organizations/:organization_id/reports/cod';
    }

    public function getRequiredQueryParams(): array
    {
        return ['start_date', 'end_date', 'format'];
    }

    public function getOptionalQueryParams(): array
    {
        return [];
    }
}
