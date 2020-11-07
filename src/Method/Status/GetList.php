<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method\Status;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithFilterableResultsInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Model\StatusCollection;
use MB\ShipXSDK\Request\Request;

class GetList implements
    MethodInterface,
    WithJsonResponseInterface,
    WithFilterableResultsInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getUriTemplate(): string
    {
        return '/v1/statuses';
    }

    public function getResponsePayloadModelName(): string
    {
        return StatusCollection::class;
    }

    public function getFilters(): array
    {
        return ['lang', 'shipment_type'];
    }
}
