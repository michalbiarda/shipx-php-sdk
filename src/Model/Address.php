<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class Address extends DataTransferObject
{
    public ?int $id;

    public ?string $line1;

    public ?string $line2;

    public string $street;

    public string $building_number;

    public string $post_code;

    public string $city;

    public string $country_code;
}
