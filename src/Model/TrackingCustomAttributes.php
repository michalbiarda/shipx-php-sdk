<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class TrackingCustomAttributes extends DataTransferObject
{
    public string $size;

    public string $target_machine_id;

    public PointSimple $target_machine_detail;

    public ?string $dropoff_machine_id;

    public ?PointSimple $dropoff_machine_detail;
}