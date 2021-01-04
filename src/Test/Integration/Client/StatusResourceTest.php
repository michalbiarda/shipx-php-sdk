<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Method\Status\GetList;
use MB\ShipXSDK\Model\Status;
use MB\ShipXSDK\Model\StatusCollection;

class StatusResourceTest extends TestCase
{
    public function testGetListSuccessfulCall(): void
    {
        $response = $this->client->callMethod(new GetList());
        $payload = $response->getPayload();
        $this->assertSuccess($response, $payload, StatusCollection::class);
        /** @var StatusCollection $payload */
        $this->assertInstanceOf(Status::class, $payload->items[0]);
    }
}
