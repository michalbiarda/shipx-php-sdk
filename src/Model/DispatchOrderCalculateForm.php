<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class DispatchOrderCalculateForm extends DataTransferObject
{
    public ?int $dispatch_point_id;

    /**
     * @var int[]
     */
    public array $shipments = [];
}
