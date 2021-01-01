<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use DateTime;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class Organization extends DataTransferObject
{
    public string $href;

    public int $id;

    public int $owner_id;

    public string $name;

    public string $tax_id;

    public DateTime $created_at;

    public DateTime $updated_at;

    public array $services;

    public ?string $bank_account_number;

    public Address $address;

    public array $carriers;

    public ?Address $invoice_address;

    public Person $contact_person;
}
