<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class TransactionPartyForm extends DataTransferObject
{
    public ?string $company_name;

    public ?string $email;

    public ?string $phone;

    public ?AddressForm $address;

    public ?string $first_name;

    public ?string $last_name;
}
