<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use DateTime;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class Shipment extends DataTransferObject
{
    public string $href;

    public int $id;

    public string $status;

    /**
     * @var \MB\ShipXSDK\Model\ParcelsSimple[]
     */
    public array $parcels;

    /**
     * @todo Check what is the correct type
     */
    public ?string $external_customer_id;

    public ?MpkSimple $mpk;

    public ?string $comments;

    public ?ShipmentCustomAttributes $custom_attributes;

    public Sender $sender;

    public Receiver $receiver;

    /**
     * @todo Check what is the correct type
     */
    public ?int $created_by_id;

    public ?Cod $cod;

    public ?Insurance $insurance;

    /**
     * @var string[]|null
     */
    public ?array $additional_services;

    public ?string $reference;

    public ?bool $is_return;

    public ?string $tracking_number;

    /**
     * @var \MB\ShipXSDK\Model\Offer[]
     */
    public array $offers;

    public ?Offer $selected_offer;

    /**
     * @var \MB\ShipXSDK\Model\Transaction[]
     */
    public ?array $transactions;

    public ?bool $end_of_week_collection;

    public DateTime $created_at;

    public DateTime $updated_at;
}
