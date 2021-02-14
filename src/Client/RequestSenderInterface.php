<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Client;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface RequestSenderInterface
{
    public function send(string $httpMethod, string $uri, array $headers, array $payload): ResponseInterface;

    public function getLastHttpRequest(): ?RequestInterface;
}
