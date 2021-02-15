<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Model\AddressForm;
use MB\ShipXSDK\Model\ShipmentAbstractForm;
use MB\ShipXSDK\Model\ShipmentBatchItemForm;
use MB\ShipXSDK\Model\ShipmentBuyForm;
use MB\ShipXSDK\Model\ShipmentForm;
use MB\ShipXSDK\Model\ShipmentBatchForm;
use MB\ShipXSDK\Model\ShipmentOfferForm;
use MB\ShipXSDK\Model\ShipmentOfferItemForm;
use MB\ShipXSDK\Model\ShipmentOfferCollectionForm;
use MB\ShipXSDK\Method\Shipment\Buy;
use MB\ShipXSDK\Method\Shipment\BuyBulk;
use MB\ShipXSDK\Method\Shipment\Cancel;
use MB\ShipXSDK\Method\Shipment\Create;
use MB\ShipXSDK\Method\Shipment\CreateBatch;
use MB\ShipXSDK\Method\Shipment\CreateOffer;
use MB\ShipXSDK\Method\Shipment\GetBatch;
use MB\ShipXSDK\Method\Shipment\GetLabel;
use MB\ShipXSDK\Method\Shipment\GetLabels;
use MB\ShipXSDK\Method\Shipment\GetList;
use MB\ShipXSDK\Method\Shipment\GetReturnLabels;
use MB\ShipXSDK\Method\Shipment\Read;
use MB\ShipXSDK\Model\DimensionsSimple;
use MB\ShipXSDK\Model\ParcelsSimple;
use MB\ShipXSDK\Model\Shipment;
use MB\ShipXSDK\Model\ShipmentBatch;
use MB\ShipXSDK\Model\ShipmentCollection;
use MB\ShipXSDK\Model\TransactionPartyForm;
use MB\ShipXSDK\Model\WeightSimple;
use MB\ShipXSDK\Test\Integration\Config;
use PHPUnit\Framework\Error\Notice;

use function is_null;
use function sleep;
use function time;

/**
 * @SuppressWarnings(PHPMD)
 */
class ShipmentResourceTest extends TestCase
{
    protected bool $withAuthToken = true;

    private string $testName;

    public function setUp(): void
    {
        parent::setUp();
        $this->testName = 'Name ' . time();
    }

    public function testSuccessfulOfferFlow(): void
    {
        $createdShipment = $this->createOffer(false);
        if (!Config::shouldWaitForAsync()) {
            $this->markTestIncomplete('Asynchronous nature of API makes the rest of this test unstable.');
        }
        $shipment = $this->getShipment($createdShipment->id, 'offers_prepared');
        $availableOfferId = null;
        foreach ($shipment->offers as $offer) {
            if ($offer->status === 'available') {
                $availableOfferId = $offer->id;
            }
        }
        $this->assertNotNull($availableOfferId);
        $this->buy($shipment->id, $availableOfferId, false);
    }

    public function testSuccessfulSimpleFlow(): void
    {
        $createdShipment = $this->create(false);
        if (!Config::shouldWaitForAsync()) {
            $this->markTestIncomplete('Asynchronous nature of API makes the rest of this test unstable.');
        }
        $shipment = $this->getShipment($createdShipment->id, 'confirmed');
        $this->getLabel($shipment->id, false);
        $this->getReturnLabel($shipment->id, false);
    }

    public function testSuccessfulBatchFlowWithBuying(): void
    {
        $itemsCount = 2;
        $createdShipmentBatch = $this->createBatch($itemsCount, false);
        if (!Config::shouldWaitForAsync()) {
            $this->markTestIncomplete('Asynchronous nature of API makes the rest of this test unstable.');
        }
        $shipmentBatch = $this->loadCreatedShipmentBatch($createdShipmentBatch, $itemsCount, 'done');
        $shipmentIds = [];
        foreach ($shipmentBatch->shipments as $shipment) {
            $shipmentIds[] = $shipment->id;
        }
        $this->getLabels($shipmentIds, false);
    }

    public function testSuccessfulBatchFlowWithoutBuying(): void
    {
        $itemsCount = 2;
        $createdShipmentBatch = $this->createBatch($itemsCount, false, true);
        $this->debug(print_r($createdShipmentBatch->toArray(), true));
        if (!Config::shouldWaitForAsync()) {
            $this->markTestIncomplete('Asynchronous nature of API makes the rest of this test unstable.');
        }
        $shipmentBatch = $this->loadCreatedShipmentBatch($createdShipmentBatch, $itemsCount, 'generated');
        $this->debug(print_r($shipmentBatch->toArray(), true));
        $bulkBuyData = [];
        foreach ($shipmentBatch->shipments as $batchShipment) {
            $shipment = $this->getShipment($batchShipment->id, 'offer_selected');
            $this->assertNotNull($shipment->selected_offer);
            $bulkBuyData[$batchShipment->id] = $shipment->selected_offer->id;
        }
        $this->bulkBuy($bulkBuyData, false);
        $shipmentIds = [];
        foreach ($shipmentBatch->shipments as $batchShipment) {
            $shipment = $this->getShipment($batchShipment->id, 'confirmed');
            $shipmentIds[] = $shipment->id;
        }
        $this->getLabels(array_keys($bulkBuyData), false);
    }

    public function testSuccessfulCancellation(): void
    {
        $this->markTestSkipped('From time to time Sandbox API responds with empty body instead of error payload. '
            . 'Empty body is expected for successful call.');
        $createdShipment = $this->createOffer(false);
        $this->cancel($createdShipment->id, false);
    }

    public function testCreateFailedCall(): void
    {
        $this->create(true);
    }

    public function testCreateOfferFailedCall(): void
    {
        $this->createOffer(true);
    }

    public function testGetListSuccessCall(): void
    {
        $this->markTestSkipped('Quite often Sandbox shipment search cannot find shipment by ID, even though '
            . 'it is reachable using standard get method.');
        $createdShipment = $this->create(false);
        $this->getShipment($createdShipment->id, 'confirmed');
        $this->getList($createdShipment->id, false);
    }

    public function testGetListFailedCall(): void
    {
        $this->getList(0, true);
    }

    public function testGetLabelFailedCall(): void
    {
        $this->markTestSkipped('From time to time Sandbox API responds with empty body instead of error payload.');
        $this->getLabel(0, true);
    }

    public function testGetLabelsFailedCall(): void
    {
        $this->getLabels([12345678], true);
    }

    public function testGetReturnLabelFailedCall(): void
    {
        $this->getReturnLabel(0, true);
    }

    public function testCreateBatchFailedCall(): void
    {
        $this->createBatch(1, true);
    }

    public function testBuyFailedCall(): void
    {
        $this->buy(0, 0, true);
    }

    public function testBuyBulkFailedCall(): void
    {
        $this->bulkBuy([], true);
    }

    public function testCancelFailedCall(): void
    {
        $this->markTestSkipped('From time to time Sandbox API responds with empty body instead of error payload.');
        $this->cancel(0, true);
    }

    private function create(bool $expectError): ?Shipment
    {
        $response = $this->client->callMethod(
            new Create(),
            ['organization_id' => $this->organizationId],
            [],
            $this->createCreateShipmentForm($expectError ? '' : $this->testName)
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return null;
        }
        $this->assertSuccess($response, $payload, Shipment::class);
        /** @var Shipment $payload */
        return $payload;
    }

    private function read(int $shipmentId, bool $expectError): ?Shipment
    {
        $response = $this->client->callMethod(
            new Read(),
            ['id' => $expectError ? self::WRONG_ID : $shipmentId]
        );
        $payload = $response->getPayload();
        $this->debug(print_r($payload->toArray(), true));
        if ($expectError) {
            $this->assertError($response, $payload);
            return null;
        }
        $this->assertSuccess($response, $payload, Shipment::class);
        /** @var Shipment $payload */
        $this->assertSame($shipmentId, $payload->id);
        $this->assertSame($this->testName, $payload->receiver->first_name);
        return $payload;
    }

    private function getList(int $shipmentId, bool $expectError): ?ShipmentCollection
    {
        $response = $this->client->callMethod(
            new GetList(),
            ['organization_id' => $expectError ? '0' : $this->organizationId],
            ['id' => $shipmentId]
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return null;
        }
        $this->assertSuccess($response, $payload, ShipmentCollection::class);
        /** @var ShipmentCollection $payload */
        $this->assertSame($shipmentId, $payload->items[0]->id);
        $this->assertSame($this->testName, $payload->items[0]->receiver->first_name);
        return $payload;
    }

    private function getLabel(int $shipmentId, bool $expectError): void
    {
        $response = $this->client->callMethod(
            new GetLabel(),
            ['shipment_id' => $expectError ? static::WRONG_ID : $shipmentId],
            ['format' => 'Pdf', 'type' => 'normal']
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return;
        }
        $this->assertSuccessWithFile($response, $payload, 'application/pdf');
    }

    private function getLabels(array $shipmentIds, bool $expectError): void
    {
        $response = $this->client->callMethod(
            new GetLabels(),
            ['organization_id' => $this->organizationId],
            [
                'format' => 'Pdf',
                'type' => 'normal',
                'shipment_ids' => $expectError ? [] : $shipmentIds
            ]
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return;
        }
        $this->assertSuccessWithFile($response, $payload, 'application/pdf');
    }

    private function getReturnLabel(int $shipmentId, bool $expectError): void
    {
        $response = $this->client->callMethod(
            new GetReturnLabels(),
            ['organization_id' => $expectError ? static::WRONG_ID : $this->organizationId],
            ['shipment_ids' => [$shipmentId], 'format' => 'Pdf']
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return;
        }
        $this->assertSuccessWithFile($response, $payload, 'application/pdf');
    }

    private function createBatch(int $itemsCount, bool $expectError, bool $onlyChoiceOfOffer = false): ?ShipmentBatch
    {
        $response = $this->client->callMethod(
            new CreateBatch(),
            ['organization_id' => $this->organizationId],
            [],
            $this->createCreateShipmentBatchForm(
                $itemsCount,
                $expectError ? '' : $this->testName,
                $onlyChoiceOfOffer
            )
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return null;
        }
        $this->assertSuccess($response, $payload, ShipmentBatch::class);
        /** @var ShipmentBatch $payload */
        return $payload;
    }

    private function getBatch(int $batchId, int $expectedShipmentCount, bool $expectError): ?ShipmentBatch
    {
        $response = $this->client->callMethod(
            new GetBatch(),
            ['batch_id' => $expectError ? static::WRONG_ID : $batchId]
        );
        $payload = $response->getPayload();
        $this->debug(print_r($payload->toArray(), true));
        if ($expectError) {
            $this->assertError($response, $payload);
            return null;
        }
        $this->assertSuccess($response, $payload, ShipmentBatch::class);
        /** @var ShipmentBatch $payload */
        $this->assertCount($expectedShipmentCount, $payload->shipments);
        return $payload;
    }

    private function createOffer(bool $expectError): ?Shipment
    {
        $response = $this->client->callMethod(
            new CreateOffer(),
            ['organization_id' => $this->organizationId],
            [],
            $this->createCreateShipmentOfferForm($expectError ? '' : $this->testName)
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return null;
        }
        $this->assertSuccess($response, $payload, Shipment::class);
        /** @var Shipment $payload */
        return $payload;
    }

    private function buy(int $shipmentId, int $offerId, bool $expectError): ?Shipment
    {
        $response = $this->client->callMethod(
            new Buy(),
            ['shipment_id' => $expectError ? self::WRONG_ID : $shipmentId],
            [],
            $this->createBuyShipmentForm($offerId)
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return null;
        }
        $this->assertSuccess($response, $payload, Shipment::class);
        /** @var Shipment $payload */
        return $payload;
    }

    private function bulkBuy(array $data, bool $expectError): void
    {
        $response = $this->client->callMethod(
            new BuyBulk(),
            ['organization_id' => $expectError ? self::WRONG_ID : $this->organizationId],
            [],
            $this->createShipmentOffersCollectionForm($data)
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return;
        }
        $this->assertSuccess($response, $payload, null);
    }

    private function cancel(int $shipmentId, bool $expectError): void
    {
        $response = $this->client->callMethod(
            new Cancel(),
            ['shipment_id' => $expectError ? self::WRONG_ID : $shipmentId]
        );
        $payload = $response->getPayload();
        if ($expectError) {
            $this->assertError($response, $payload);
            return;
        }
        $this->assertNull($payload);
    }

    private function createCreateShipmentForm(string $firstName): ShipmentForm
    {
        $shipmentForm = new ShipmentForm();
        $this->fillAbstractShipmentForm($shipmentForm, $firstName);
        $shipmentForm->service = 'inpost_courier_standard';
        return $shipmentForm;
    }

    private function createCreateShipmentOfferForm(string $firstName): ShipmentOfferForm
    {
        $shipmentForm = new ShipmentOfferForm();
        $this->fillAbstractShipmentForm($shipmentForm, $firstName);
        return $shipmentForm;
    }

    private function createCreateShipmentBatchForm(
        int $itemsCount,
        string $firstName,
        bool $onlyChoiceOfOffer = false
    ): ShipmentBatchForm {
        $shipmentBatchForm = new ShipmentBatchForm();
        $shipments = [];
        for ($i = 0; $i < $itemsCount; $i++) {
            $shipments[] = $this->createCreateShipmentBatchFormItem($i, $firstName, $onlyChoiceOfOffer);
        }
        $shipmentBatchForm->shipments = $shipments;
        return $shipmentBatchForm;
    }

    private function createCreateShipmentBatchFormItem(
        int $uniqueId,
        string $firstName,
        ?bool $onlyChoiceOfOffer = null
    ): ShipmentBatchItemForm {
        $shipmentBatchItemForm = new ShipmentBatchItemForm();
        $this->fillAbstractShipmentForm($shipmentBatchItemForm, $firstName);
        $shipmentBatchItemForm->service = 'inpost_courier_standard';
        $shipmentBatchItemForm->id = $uniqueId;
        if (!is_null($onlyChoiceOfOffer)) {
            $shipmentBatchItemForm->only_choice_of_offer = $onlyChoiceOfOffer;
        }
        return $shipmentBatchItemForm;
    }

    private function fillAbstractShipmentForm(ShipmentAbstractForm $shipmentForm, string $firstName): void
    {
        $addressForm = new AddressForm();
        $addressForm->city = 'Warszawa';
        $addressForm->post_code = '01-234';
        $addressForm->country_code = 'PL';
        $addressForm->street = 'Testowa 11';
        $addressForm->building_number = '12/23';

        $receiverForm = new TransactionPartyForm();
        $receiverForm->phone = '123456789';
        $receiverForm->email = 'some.guy@gmail.com';
        $receiverForm->first_name = $firstName;
        $receiverForm->last_name = 'Testowy';
        $receiverForm->address = $addressForm;

        $dimensions = new DimensionsSimple();
        $dimensions->height = 21.5;
        $dimensions->length = 2.1;
        $dimensions->width = 1.7;

        $weight = new WeightSimple();
        $weight->amount = 2.0;

        $parcel = new ParcelsSimple();
        $parcel->dimensions = $dimensions;
        $parcel->weight = $weight;
        $parcel->is_non_standard = false;

        $shipmentForm->receiver = $receiverForm;
        $shipmentForm->parcels = [$parcel];
        $shipmentForm->additional_services = [];
    }

    private function getShipment(int $shipmentId, string $status): Shipment
    {
        $shipment = null;
        // Shipments are processed asynchronously, so we need to wait a bit...
        for ($i = 0; $i < Config::MAX_TRIES_FOR_ASYNC; $i++) {
            sleep(Config::WAITING_INTERVAL_FOR_ASYNC);
            $this->debug(sprintf("Trying to get shipment #%s'\n", $shipmentId));
            $shipment = $this->read($shipmentId, false);
            if ($shipment && $shipment->status === $status) {
                break;
            }
        }
        if (!$shipment) {
            throw new Notice('Unable to load shipment.');
        }
        return $shipment;
    }

    private function createBuyShipmentForm(int $offerId): ShipmentBuyForm
    {
        $shipmentBuyForm = new ShipmentBuyForm();
        $shipmentBuyForm->offer_id = $offerId;
        return $shipmentBuyForm;
    }

    private function createShipmentOffersCollectionForm(array $data): ShipmentOfferCollectionForm
    {
        $shipmentOfferCollectionForm = new ShipmentOfferCollectionForm();
        $shipments = [];
        $i = 1;
        foreach ($data as $shipmentId => $offerId) {
            $shipmentOfferItemForm = new ShipmentOfferItemForm();
            $shipmentOfferItemForm->id = $i;
            $shipmentOfferItemForm->shipment_id = $shipmentId;
            $shipmentOfferItemForm->offer_id = $offerId;
            $shipments[] = $shipmentOfferItemForm;
            $i++;
        }
        $shipmentOfferCollectionForm->shipments = $shipments;
        return $shipmentOfferCollectionForm;
    }

    private function loadCreatedShipmentBatch(
        ShipmentBatch $createdShipmentBatch,
        int $itemsCount,
        string $status
    ): ShipmentBatch {
        // Shipments are processed asynchronously, so we need to wait a bit...
        for ($i = 0; $i < Config::MAX_TRIES_FOR_ASYNC; $i++) {
            sleep(Config::WAITING_INTERVAL_FOR_ASYNC);
            $this->debug(sprintf("Trying to get batch #%s\n", $createdShipmentBatch->id));
            $shipmentBatch = $this->getBatch($createdShipmentBatch->id, $itemsCount, false);
            if ($shipmentBatch->status === $status) {
                break;
            }
        }
        if (count($shipmentBatch->shipments) !== $itemsCount) {
            throw new Notice('Unable to load shipments.');
        }
        return $shipmentBatch;
    }
}
