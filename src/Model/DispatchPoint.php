<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class DispatchPoint extends DataTransferObject
{
    public ?string $href;

    public int $id;

    public string $name;

    public string $office_hours;

    public ?string $phone;

    public ?string $email;

    public ?string $comments;

    public Address $address;

    public string $status;
}