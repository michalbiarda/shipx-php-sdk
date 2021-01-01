<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Stub;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Response\HttpResponseProcessor\ProcessorInterface;
use MB\ShipXSDK\Response\Response;
use Psr\Http\Message\ResponseInterface;

class ProcessorReturningNull implements ProcessorInterface
{
    public function run(MethodInterface $method, ResponseInterface $httpResponse): ?Response
    {
        return null;
    }
}
