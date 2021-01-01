<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Client\Client;
use RuntimeException;

use function getenv;

class ClientFactory
{
    private const ENV_SHIPX_BASE_URI = 'SHIPX_BASE_URI';
    private const ENV_SHIPX_AUTH_TOKEN = 'SHIPX_AUTH_TOKEN';

    public function create(bool $withAuthToken): Client
    {
        $baseUri = getenv(self::ENV_SHIPX_BASE_URI);
        if (!$baseUri) {
            throw new RuntimeException(sprintf('Missing env variable: %s', self::ENV_SHIPX_BASE_URI));
        }
        if ($withAuthToken) {
            $authToken = getenv(self::ENV_SHIPX_AUTH_TOKEN);
            if (!$authToken) {
                throw new RuntimeException(sprintf('Missing env variable: %s', self::ENV_SHIPX_AUTH_TOKEN));
            }
            return new Client($baseUri, $authToken);
        }
        return new Client($baseUri);
    }
}
