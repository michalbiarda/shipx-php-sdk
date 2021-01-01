<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method\Service;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithJsonArrayResponseInterface;
use MB\ShipXSDK\Model\ServiceCollection;
use MB\ShipXSDK\Request\Request;

class GetList implements
    MethodInterface,
    WithJsonArrayResponseInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getUriTemplate(): string
    {
        return '/v1/services';
    }

    public function getResponsePayloadModelName(): string
    {
        return ServiceCollection::class;
    }
}
