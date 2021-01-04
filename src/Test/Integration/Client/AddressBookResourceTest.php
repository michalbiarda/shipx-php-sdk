<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;
use MB\ShipXSDK\Method\AddressBook\Create;
use MB\ShipXSDK\Method\AddressBook\Delete;
use MB\ShipXSDK\Method\AddressBook\GetList;
use MB\ShipXSDK\Method\AddressBook\Read;
use MB\ShipXSDK\Method\AddressBook\Update;
use MB\ShipXSDK\Model\Address;
use MB\ShipXSDK\Model\AddressBook;
use MB\ShipXSDK\Model\AddressBookCollection;
use MB\ShipXSDK\Model\Error;
use MB\ShipXSDK\Response\Response;

use function time;

class AddressBookResourceTest extends TestCase
{
    protected bool $withAuthToken = true;

    private string $testName;

    public function setUp(): void
    {
        parent::setUp();
        $this->testName = 'Name ' . time();
    }

    public function testSuccessfulCrudFlow(): void
    {
        $createdAddressBook = $this->create(false);
        $readAddressBook = $this->read($createdAddressBook->id, false);
        $updatedAddressBook = $this->update($readAddressBook->id, false);
        $addressBookList = $this->getList($updatedAddressBook->id, false);
        $this->delete($addressBookList->items[0]->id, false);
        $this->read($addressBookList->items[0]->id, true);
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
        $this->getList(0, true);
    }

    public function testUpdateFailedCall(): void
    {
        $this->update(0, true);
    }

    public function testDeleteFailedCall(): void
    {
        $this->delete(0, true);
    }

    private function create(bool $expectError): ?AddressBook
    {
        $response = $this->client->callMethod(
            new Create(),
            ['organization_id' => $this->organizationId],
            [],
            $this->createAddressBookModel($expectError ? '' : $this->testName)
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return null;
        }
        $this->assertSuccess($response, $payload, AddressBook::class);
        /** @var AddressBook $payload */
        return $payload;
    }

    private function update(int $addressBookId, bool $expectError): ?AddressBook
    {
        $response = $this->client->callMethod(
            new Update(),
            ['id' => $addressBookId],
            [],
            $this->createAddressBookModel('New ' . $this->testName)
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return null;
        }
        $this->assertSuccess($response, $payload, AddressBook::class);
        /** @var AddressBook $payload */
        $this->assertSame('New ' . $this->testName, $payload->name);
        return $payload;
    }

    private function getList(int $addressBookId, bool $expectError): ?AddressBookCollection
    {
        $queryParams = ['id' => $addressBookId];
        $response = $this->client->callMethod(
            new GetList(),
            ['organization_id' => $expectError ? 0 : $this->organizationId],
            $queryParams
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return null;
        }
        $this->assertSuccess($response, $payload, AddressBookCollection::class);
        /** @var AddressBookCollection $payload */
        $this->assertSame($addressBookId, $payload->items[0]->id);
        return $payload;
    }

    private function read(int $addressBookId, bool $expectError): ?AddressBook
    {
        $response = $this->client->callMethod(
            new Read(),
            ['id' => $addressBookId]
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return null;
        }
        $this->assertSuccess($response, $payload, AddressBook::class);
        /** @var AddressBook $payload */
        $this->assertSame($addressBookId, $payload->id);
        return $payload;
    }

    private function delete(int $addressBookId, bool $expectError): void
    {
        $response = $this->client->callMethod(
            new Delete(),
            ['id' => $expectError ? static::WRONG_ID : $addressBookId]
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return;
        }
        $this->assertSuccess($response, $payload, null);
    }

    private function createAddressBookModel(string $name): AddressBook
    {
        return new AddressBook([
            'name' => $name,
            'first_name' => 'Jan',
            'last_name' => 'Nowak',
            'phone' => '500123456',
            'email' => 'jan@niepodam.pl',
            'kind' => 'sender',
            'main_address' => new Address([
                'city' => 'Warszawa',
                'post_code' => '02-234',
                'country_code' => 'PL',
                'street' => 'Testowa',
                'building_number' => '122/23'
            ]),
            'delivery_address' => new Address([
                'city' => 'Warszawa',
                'post_code' => '01-422',
                'country_code' => 'PL',
                'street' => 'Kolorowa',
                'building_number' => '82/1'
            ])
        ]);
    }
}
