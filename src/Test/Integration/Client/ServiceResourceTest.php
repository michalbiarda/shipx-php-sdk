<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Client\Client;
use MB\ShipXSDK\Method\Service\GetList;
use MB\ShipXSDK\Model\Service;
use MB\ShipXSDK\Model\ServiceCollection;
use PHPUnit\Framework\TestCase;

class ServiceResourceTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        $this->client = (new ClientFactory())->create(false);
    }

    public function testGetListSuccessfulCall(): void
    {
        $response = $this->client->callMethod(new GetList());
        $this->assertTrue($response->getSuccess());
        $payload = $response->getPayload();
        $this->assertInstanceOf(ServiceCollection::class, $payload);
        /** @var ServiceCollection $payload */
        $this->assertInstanceOf(Service::class, $payload->items[0]);
    }
}
