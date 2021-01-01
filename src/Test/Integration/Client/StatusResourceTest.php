<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Client\Client;
use MB\ShipXSDK\Method\Status\GetList;
use MB\ShipXSDK\Model\Status;
use MB\ShipXSDK\Model\StatusCollection;
use PHPUnit\Framework\TestCase;

class StatusResourceTest extends TestCase
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
        $this->assertInstanceOf(StatusCollection::class, $payload);
        /** @var StatusCollection $payload */
        $this->assertInstanceOf(Status::class, $payload->items[0]);
    }
}
