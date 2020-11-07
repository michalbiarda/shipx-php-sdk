<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class DimensionsSimple extends DataTransferObject
{
    public float $height;

    public float $length;

    public float $width;

    public string $unit = 'mm';
}
