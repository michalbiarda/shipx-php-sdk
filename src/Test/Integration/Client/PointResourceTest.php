<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Client\Client;
use MB\ShipXSDK\Method\Point\GetList;
use MB\ShipXSDK\Method\Point\Read;
use MB\ShipXSDK\Model\Error;
use MB\ShipXSDK\Model\Point;
use MB\ShipXSDK\Model\PointCollection;
use PHPUnit\Framework\TestCase;

class PointResourceTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        $this->client = (new ClientFactory())->create(false);
    }

    public function testReadSuccessfulCall(): void
    {
        $response = $this->client->callMethod(new Read(), ['name' => 'AND01A']);
        $this->assertTrue($response->getSuccess());
        $payload = $response->getPayload();
        $this->assertInstanceOf(Point::class, $payload);
        /** @var Point $payload */
        $this->assertSame('AND01A', $payload->name);
    }

    public function testReadFailedCall(): void
    {
        $response = $this->client->callMethod(new Read(), ['name' => 'FAIL01']);
        $this->assertFalse($response->getSuccess());
        $payload = $response->getPayload();
        $this->assertInstanceOf(Error::class, $payload);
    }

    public function testGetListSuccessfulCall(): void
    {
        $response = $this->client->callMethod(
            new GetList(),
            [],
            [
                'name' => 'AND01A,ANR01A',
                'sort_order' => 'desc',
                'sort_by' => 'name'
            ]
        );
        $this->assertTrue($response->getSuccess());
        $payload = $response->getPayload();
        $this->assertInstanceOf(PointCollection::class, $payload);
        /** @var PointCollection $payload */
        $this->assertSame('ANR01A', $payload->items[0]->name);
        $this->assertSame('AND01A', $payload->items[1]->name);
    }

    public function testGetListFailedCall(): void
    {
        $response = $this->client->callMethod(new GetList(), [], ['limit' => -1]);
        $this->assertFalse($response->getSuccess());
        $payload = $response->getPayload();
        $this->assertInstanceOf(Error::class, $payload);
    }
}
