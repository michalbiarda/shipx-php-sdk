<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method\AddressBook;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithJsonRequestInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Model\AddressBook;
use MB\ShipXSDK\Request\Request;

class Update implements
    MethodInterface,
    WithJsonRequestInterface,
    WithJsonResponseInterface,
    WithAuthorizationInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_PUT;
    }

    public function getUriTemplate(): string
    {
        return '/v1/address_books/:id';
    }

    public function getRequestPayloadModelName(): string
    {
        return AddressBook::class;
    }

    public function getResponsePayloadModelName(): string
    {
        return AddressBook::class;
    }
}
