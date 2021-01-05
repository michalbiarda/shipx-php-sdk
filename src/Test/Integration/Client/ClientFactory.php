<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Client\Client;
use MB\ShipXSDK\Test\Integration\Config;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ClientFactory
{
    public function create(bool $withAuthToken): Client
    {
        $baseUri = Config::getBaseUri();
        if ($withAuthToken) {
            return new Client($baseUri, Config::getAuthToken());
        }
        return new Client($baseUri);
    }
}
