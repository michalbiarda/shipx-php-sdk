<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Method\Organization\GetList;
use MB\ShipXSDK\Method\Organization\Read;
use MB\ShipXSDK\Model\Organization;
use MB\ShipXSDK\Model\OrganizationCollection;

class OrganizationResourceTest extends TestCase
{
    protected bool $withAuthToken = true;

    public function testReadSuccessfulCall(): void
    {
        $response = $this->client->callMethod(new Read(), ['id' => $this->organizationId]);
        $payload = $response->getPayload();
        $this->assertSuccess($response, $payload, Organization::class);
        /** @var Organization $payload */
        $this->assertSame((int) $this->organizationId, $payload->id);
    }

    public function testReadFailedCall(): void
    {
        $this->markTestSkipped('Sandbox API always returns current organization data, '
            . 'no matter what ID was provided.');
    }

    public function testGetListSuccessfulCall(): void
    {
        $response = $this->client->callMethod(new GetList());
        $payload = $response->getPayload();
        $this->assertSuccess($response, $payload, OrganizationCollection::class);
        /** @var OrganizationCollection $payload */
        $this->assertInstanceOf(Organization::class, $payload->items[0]);
    }

    public function testGetListFailedCall(): void
    {
        $this->markTestSkipped('There is no way to make failed call.');
    }
}
