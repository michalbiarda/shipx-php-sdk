<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Method\Point\GetList;
use MB\ShipXSDK\Method\Point\Read;
use MB\ShipXSDK\Model\Point;
use MB\ShipXSDK\Model\PointCollection;

class PointResourceTest extends TestCase
{
    public function testReadSuccessfulCall(): void
    {
        $response = $this->client->callMethod(new Read(), ['name' => 'BBI01HO']);
        $payload = $response->getPayload();
        $this->assertSuccess($response, $payload, Point::class);
        /** @var Point $payload */
        $this->assertSame('BBI01HO', $payload->name);
    }

    public function testReadFailedCall(): void
    {
        $response = $this->client->callMethod(new Read(), ['name' => 'FAIL01']);
        $payload = $response->getPayload();
        $this->assertError($response, $payload);
    }

    public function testGetListSuccessfulCall(): void
    {
        $response = $this->client->callMethod(
            new GetList(),
            [],
            [
                'name' => 'BBI01HO',
                'sort_order' => 'desc',
                'sort_by' => 'name'
            ]
        );
        $payload = $response->getPayload();
        $this->assertSuccess($response, $payload, PointCollection::class);
        /** @var PointCollection $payload */
        $this->assertSame('BBI01HO', $payload->items[0]->name);
    }

    public function testGetListFailedCall(): void
    {
        $response = $this->client->callMethod(new GetList(), [], ['updated_from' => 'fail']);
        $payload = $response->getPayload();
        $this->assertError($response, $payload);
    }
}
