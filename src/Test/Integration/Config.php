<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration;

use RuntimeException;

use function getenv;

class Config
{
    private const ENV_SHIPX_BASE_URI = 'SHIPX_BASE_URI';
    private const ENV_SHIPX_AUTH_TOKEN = 'SHIPX_AUTH_TOKEN';
    private const ENV_SHIPX_ORGANIZATION_ID = 'SHIPX_ORGANIZATION_ID';
    private const ENV_WAIT_FOR_ASYNC = 'WAIT_FOR_ASYNC';

    public const MAX_TRIES_FOR_ASYNC = 120;
    public const WAITING_INTERVAL_FOR_ASYNC = 5;

    public static function getBaseUri(): string
    {
        return self::getValue(self::ENV_SHIPX_BASE_URI);
    }

    public static function getAuthToken(): string
    {
        return self::getValue(self::ENV_SHIPX_AUTH_TOKEN);
    }

    public static function getOrganizationId(): string
    {
        return self::getValue(self::ENV_SHIPX_ORGANIZATION_ID);
    }

    public static function shouldWaitForAsync(): bool
    {
        return (bool) self::getValue(self::ENV_WAIT_FOR_ASYNC);
    }

    private static function getValue(string $variable): string
    {
        $value = getenv($variable);
        if ($value === false) {
            throw new RuntimeException(sprintf('Missing env variable: %s', $variable));
        }
        return $value;
    }
}
