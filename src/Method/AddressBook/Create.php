<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method\AddressBook;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithJsonRequestInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Model\AddressBook;
use MB\ShipXSDK\Model\AddressBookForm;
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
        return '/v1/organizations/:organization_id/address_books';
    }

    public function getRequestPayloadModelName(): string
    {
        return AddressBookForm::class;
    }

    public function getResponsePayloadModelName(): string
    {
        return AddressBook::class;
    }
}
