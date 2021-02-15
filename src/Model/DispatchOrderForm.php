<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class DispatchOrderForm extends DataTransferObject
{
    public ?int $dispatch_point_id;

    /**
     * @var int[]
     */
    public array $shipments = [];

    public ?string $comment;

    public ?AddressForm $address;

    public ?string $office_hours;

    public ?string $name;

    public ?string $phone;

    public ?string $email;
}
