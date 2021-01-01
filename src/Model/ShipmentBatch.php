<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use DateTime;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class ShipmentBatch extends DataTransferObject
{
    public string $href;

    public int $id;

    public string $status;

    /**
     * @var \MB\ShipXSDK\Model\ShipmentSimple[]
     */
    public array $shipments;

    public DateTime $created_at;

    public DateTime $updated_at;
}
