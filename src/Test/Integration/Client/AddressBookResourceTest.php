<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Client\Client;
use MB\ShipXSDK\Method\AddressBook\Create;
use MB\ShipXSDK\Method\AddressBook\Delete;
use MB\ShipXSDK\Method\AddressBook\GetList;
use MB\ShipXSDK\Method\AddressBook\Read;
use MB\ShipXSDK\Method\AddressBook\Update;
use MB\ShipXSDK\Model\Address;
use MB\ShipXSDK\Model\AddressBook;
use MB\ShipXSDK\Model\AddressBookCollection;
use MB\ShipXSDK\Model\Error;
use MB\ShipXSDK\Test\Integration\Config;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class AddressBookResourceTest extends TestCase
{
    private Client $client;

    private string $organizationId;

    private string $testName;

    public function setUp(): void
    {
        $this->client = (new ClientFactory())->create(true);
        $this->organizationId = Config::getOrganizationId();
        $this->testName = 'Name ' . time();
    }

    public function testSuccessfulCrudFlow(): void
    {
        $createdAddressBook = $this->create();
        $readAddressBook = $this->read($createdAddressBook->id, false);
        $updatedAddressBook = $this->update($readAddressBook->id);
        $addressBookList = $this->getList($updatedAddressBook->id);
        $this->delete($addressBookList->items[0]->id);
        $this->read($addressBookList->items[0]->id, true);
    }

    private function create(): AddressBook
    {
        $response = $this->client->callMethod(
            new Create(),
            ['organization_id' => $this->organizationId],
            [],
            $this->createAddressBookModel($this->testName)
        );
        $payload = $response->getPayload();
        $this->assertTrue($response->getSuccess());
        $this->assertInstanceOf(AddressBook::class, $payload);
        /** @var AddressBook $payload */
        return $payload;
    }

    private function update(int $addressBookId): AddressBook
    {
        $response = $this->client->callMethod(
            new Update(),
            ['id' => $addressBookId],
            [],
            $this->createAddressBookModel('New ' . $this->testName)
        );
        $payload = $response->getPayload();
        $this->assertTrue($response->getSuccess());
        $this->assertInstanceOf(AddressBook::class, $payload);
        /** @var AddressBook $payload */
        $this->assertSame('New ' . $this->testName, $payload->name);
        return $payload;
    }

    private function getList(int $addressBookId): AddressBookCollection
    {
        $response = $this->client->callMethod(
            new GetList(),
            ['organization_id' => $this->organizationId],
            ['id' => $addressBookId]
        );
        $payload = $response->getPayload();
        $this->assertTrue($response->getSuccess());
        $this->assertInstanceOf(AddressBookCollection::class, $payload);
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
            $this->assertFalse($response->getSuccess());
            $this->assertInstanceOf(Error::class, $payload);
            return null;
        }
        $this->assertTrue($response->getSuccess());
        $this->assertInstanceOf(AddressBook::class, $payload);
        /** @var AddressBook $payload */
        $this->assertSame($addressBookId, $payload->id);
        return $payload;
    }

    private function delete(int $addressBookId): void
    {
        $response = $this->client->callMethod(
            new Delete(),
            ['id' => $addressBookId]
        );
        $this->assertTrue($response->getSuccess());
        $this->assertNull($response->getPayload());
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
