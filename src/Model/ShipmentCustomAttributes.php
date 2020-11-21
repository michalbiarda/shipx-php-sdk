<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class ShipmentCustomAttributes extends DataTransferObject
{
    public ?string $target_point;

    public ?string $dropoff_point;

    public ?string $sending_method;

    public ?string $open_code;
}
