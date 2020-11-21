<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

abstract class AbstractShipmentForm extends DataTransferObject
{
    public Receiver $receiver;

    public ?Sender $sender;

    /**
     * @var \MB\ShipXSDK\Model\ParcelsSimple[]
     */
    public array $parcels;

    public ?ShipmentCustomAttributes $custom_attributes;

    public ?Cod $cod;

    public ?Insurance $insurance;

    public ?string $reference;

    public ?bool $is_return;

    /**
     * @var string[]
     */
    public ?array $additional_services;

    public ?string $external_customer_id;

    public ?bool $only_choice_of_offer;

    public ?string $mpk;

    public ?string $comments;
}
