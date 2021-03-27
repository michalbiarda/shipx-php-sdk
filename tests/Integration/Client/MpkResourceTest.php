<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Method\Mpk\Create;
use MB\ShipXSDK\Method\Mpk\GetList;
use MB\ShipXSDK\Method\Mpk\Read;
use MB\ShipXSDK\Method\Mpk\Update;
use MB\ShipXSDK\Model\Mpk;
use MB\ShipXSDK\Model\MpkCollection;
use MB\ShipXSDK\Model\MpkForm;

use function time;

class MpkResourceTest extends TestCase
{
    protected bool $withAuthToken = true;

    private string $testName;

    public function setUp(): void
    {
        parent::setUp();
        $this->testName = 'Name ' . time();
    }

    public function testSuccessfulCruFlow(): void
    {
        $createdMpk = $this->create(false);
        $readMpk = $this->read($createdMpk->id, false);
        $this->update($readMpk->id, false);
        $this->getList(false);
    }

    public function testCreateFailedCall(): void
    {
        $this->create(true);
    }

    public function testReadFailedCall(): void
    {
        $this->read(0, true);
    }

    public function testGetListFailedCall(): void
    {
        $this->getList(true);
    }

    public function testUpdateFailedCall(): void
    {
        $this->update(0, true);
    }

    private function create(bool $expectError): ?Mpk
    {
        $response = $this->client->callMethod(
            new Create(),
            ['organization_id' => $this->organizationId],
            [],
            $this->createMpkForm($expectError ? '' : $this->testName)
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return null;
        }
        $this->assertSuccess($response, $payload, Mpk::class);
        /** @var Mpk $payload */
        return $payload;
    }

    private function update(int $mpkId, bool $expectError): ?Mpk
    {
        $response = $this->client->callMethod(
            new Update(),
            ['id' => $mpkId],
            [],
            $this->createMpkForm('New ' . $this->testName)
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return null;
        }
        $this->assertSuccess($response, $payload, Mpk::class);
        /** @var Mpk $payload */
        $this->assertSame('New ' . $this->testName, $payload->name);
        return $payload;
    }

    private function getList(bool $expectError): ?MpkCollection
    {
        $response = $this->client->callMethod(
            new GetList(),
            ['organization_id' => $expectError ? '0' : $this->organizationId]
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return null;
        }
        $this->assertSuccess($response, $payload, MpkCollection::class);
        /** @var MpkCollection $payload */
        return $payload;
    }

    private function read(int $mpkId, bool $expectError): ?Mpk
    {
        $response = $this->client->callMethod(
            new Read(),
            ['id' => $mpkId]
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return null;
        }
        $this->assertSuccess($response, $payload, Mpk::class);
        /** @var Mpk $payload */
        $this->assertSame($mpkId, $payload->id);
        return $payload;
    }

    private function createMpkForm(string $name): MpkForm
    {
        $mpkForm = new MpkForm();
        $mpkForm->name = $name;
        $mpkForm->description = 'Test MPK';
        return $mpkForm;
    }
}
