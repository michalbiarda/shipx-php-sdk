<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Method\Report\GetCod;

class ReportResourceTest extends TestCase
{
    protected bool $withAuthToken = true;

    public function testGetCodSuccessfulCall(): void
    {
        $response = $this->client->callMethod(
            new GetCod(),
            ['organization_id' => $this->organizationId],
            ['format' => 'csv', 'start_date' => '2021-01-01', 'end_date' => '2021-05-30']
        );
        $this->assertSuccessWithFile($response, $response->getPayload(), 'application/csv');
    }

    public function testGetCodFailedCall(): void
    {
        $response = $this->client->callMethod(
            new GetCod(),
            ['organization_id' => $this->organizationId],
            ['format' => 'docx', 'start_date' => '2021-01-01', 'end_date' => '2020-12-30']
        );
        $this->assertError($response, $response->getPayload());
    }
}
