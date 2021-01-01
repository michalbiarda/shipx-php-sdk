<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Client\Client;
use MB\ShipXSDK\Method\SendingMethod\GetList;
use MB\ShipXSDK\Model\DescriptiveEntity;
use MB\ShipXSDK\Model\Error;
use MB\ShipXSDK\Model\SendingMethodCollection;
use PHPUnit\Framework\TestCase;

class SendingMethodResourceTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        $this->client = (new ClientFactory())->create(false);
    }

    public function testGetListSuccessfulCall(): void
    {
        $response = $this->client->callMethod(
            new GetList(),
            [],
            ['service' => 'inpost_locker_standard']
        );
        $this->assertTrue($response->getSuccess());
        $payload = $response->getPayload();
        $this->assertInstanceOf(SendingMethodCollection::class, $payload);
        /** @var SendingMethodCollection $payload */
        $this->assertInstanceOf(DescriptiveEntity::class, $payload->items[0]);
    }

    public function testGetListFailedCall(): void
    {
        $response = $this->client->callMethod(
            new GetList(),
            [],
            ['service' => 'non_existent_service']
        );
        $this->assertFalse($response->getSuccess());
        $payload = $response->getPayload();
        $this->assertInstanceOf(Error::class, $payload);
    }
}
