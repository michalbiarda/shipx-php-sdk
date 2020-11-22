<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Form;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class CalculateDispatchOrder extends DataTransferObject
{
    public int $dispatch_point_id;

    /**
     * @var int[]
     */
    public array $shipments;
}
