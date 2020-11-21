<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class PointSimple extends DataTransferObject
{
    public ?string $href;

    public string $name;

    public ?string $opening_hours;

    public ?string $location_description;

    public Location $location;

    public PointAddress $address;

    /**
     * @var string[]
     */
    public array $type;

    public ?bool $location_247;
}
