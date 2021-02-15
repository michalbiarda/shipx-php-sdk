<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

abstract class ShipmentAbstractForm extends DataTransferObject
{
    public ?TransactionPartyForm $receiver;

    public ?TransactionPartyForm $sender;

    /**
     * @var \MB\ShipXSDK\Model\ParcelsSimple[]
     */
    public array $parcels = [];

    public ?ShipmentCustomAttributes $custom_attributes;

    public ?Price $cod;

    public ?Price $insurance;

    public ?string $reference;

    // @todo This doesn't work with Paczkomaty. Check how to deal with it.
    // public ?bool $is_return;

    /**
     * @var string[]
     */
    public array $additional_services = [];

    public ?string $external_customer_id;

    public ?bool $only_choice_of_offer;

    public ?string $mpk;

    public ?string $comments;
}
