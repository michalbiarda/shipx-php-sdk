<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class PointAddressDetails extends DataTransferObject
{
    public ?string $city;

    public ?string $province;

    public ?string $post_code;

    public ?string $street;

    public ?string $building_number;

    public ?string $flat_number;
}
