<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Method\Service\GetList;
use MB\ShipXSDK\Model\Service;
use MB\ShipXSDK\Model\ServiceCollection;

class ServiceResourceTest extends TestCase
{
    public function testGetListSuccessfulCall(): void
    {
        $response = $this->client->callMethod(new GetList());
        $payload = $response->getPayload();
        $this->assertSuccess($response, $payload, ServiceCollection::class);
        /** @var ServiceCollection $payload */
        $this->assertInstanceOf(Service::class, $payload->items[0]);
    }
}
