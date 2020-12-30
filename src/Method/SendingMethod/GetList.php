<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method\SendingMethod;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithFilterableResultsInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Model\SendingMethodCollection;
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
        return '/v1/sending_methods';
    }

    public function getResponsePayloadModelName(): string
    {
        return SendingMethodCollection::class;
    }

    public function getFilters(): array
    {
        return ['service'];
    }
}
