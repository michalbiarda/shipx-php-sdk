<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Form;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;
use MB\ShipXSDK\Model\Cod;
use MB\ShipXSDK\Model\Insurance;
use MB\ShipXSDK\Model\Receiver;
use MB\ShipXSDK\Model\Sender;
use MB\ShipXSDK\Model\ShipmentCustomAttributes;

abstract class AbstractCreateShipment extends DataTransferObject
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

    // @todo This doesn't work with Paczkomaty. Check how to deal with it.
    // public ?bool $is_return;

    /**
     * @var string[]
     */
    public ?array $additional_services;

    public ?string $external_customer_id;

    public ?bool $only_choice_of_offer;

    public ?string $mpk;

    public ?string $comments;
}
