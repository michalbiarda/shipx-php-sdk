<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Method\SendingMethod\GetList;
use MB\ShipXSDK\Model\DescriptiveEntity;
use MB\ShipXSDK\Model\SendingMethodCollection;

class SendingMethodResourceTest extends TestCase
{
    public function testGetListSuccessfulCall(): void
    {
        $response = $this->client->callMethod(
            new GetList(),
            [],
            ['service' => 'inpost_locker_standard']
        );
        $payload = $response->getPayload();
        $this->assertSuccess($response, $payload, SendingMethodCollection::class);
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
        $this->assertError($response, $response->getPayload());
    }
}
