<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method\Mpk;

use MB\ShipXSDK\Form\CreateMpk;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithJsonRequestInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Model\Mpk;
use MB\ShipXSDK\Request\Request;

class Create implements
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
        return '/v1/organizations/:organization_id/mpks';
    }

    public function getRequestPayloadModelName(): string
    {
        return CreateMpk::class;
    }

    public function getResponsePayloadModelName(): string
    {
        return Mpk::class;
    }
}
