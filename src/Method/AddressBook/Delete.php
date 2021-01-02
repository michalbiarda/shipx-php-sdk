<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method\AddressBook;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Request\Request;

/**
 * @todo Check why incorrect request (with incorrect ID) lasts infinitely, instead of returning error response.
 */
class Delete implements
    MethodInterface,
    WithAuthorizationInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_DELETE;
    }

    public function getUriTemplate(): string
    {
        return '/v1/address_books/:id';
    }
}
