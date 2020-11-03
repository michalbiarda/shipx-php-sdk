<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class Person extends DataTransferObject
{
    public int $id;

    public ?string $email;

    public ?string $phone;

    public ?string $first_name;

    public ?string $last_name;
}
