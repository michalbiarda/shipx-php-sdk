<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

/**
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class AddressBookForm extends DataTransferObject
{
    public ?string $name;

    public ?string $first_name;

    public ?string $last_name;

    public ?string $phone;

    public ?string $email;

    public ?int $organization_id;

    public ?AddressForm $main_address;

    public ?AddressForm $delivery_address;

    public ?bool $sender_parcel;

    public ?bool $sender_courier;

    public ?bool $sender_letter;

    public ?string $kind;

    public ?string $company_name;

    public ?string $preferred_dropoff_point;
}
