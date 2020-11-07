<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

abstract class AbstractTransactionParty extends DataTransferObject
{
    public ?string $company_name;

    public ?string $email;

    public string $phone;

    public Address $address;

    public ?string $first_name;

    public ?string $last_name;
}
