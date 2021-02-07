<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Method\Tracking\Read;

class TrackingResourceTest extends TestCase
{
    public function testReadSuccessfulCall(): void
    {
        $this->markTestSkipped('Sandbox API constantly responds with "Resource not found" error.');
    }

    public function testReadFailedCall(): void
    {
        $response = $this->client->callMethod(new Read(), ['tracking_number' => 'non-existent']);
        $payload = $response->getPayload();
        $this->assertError($response, $payload);
    }
}
