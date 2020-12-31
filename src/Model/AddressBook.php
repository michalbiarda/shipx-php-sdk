<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use DateTime;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class AddressBook extends DataTransferObject
{
    public ?int $id;

    public ?string $href;

    public string $name;

    public string $first_name;

    public string $last_name;

    public string $phone;

    public string $email;

    public ?int $organization_id;

    public Address $main_address;

    public Address $delivery_address;

    public ?bool $sender_parcel;

    public ?bool $sender_courier;

    public ?bool $sender_letter;

    public string $kind;

    public ?string $company_name;

    public ?string $preferred_dropoff_point;

    public DateTime $created_at;

    public DateTime $updated_at;
}
