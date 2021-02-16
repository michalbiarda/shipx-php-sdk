<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use DateTime;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class DispatchOrder extends DataTransferObject
{
    public string $href;

    public int $id;

    public string $status;

    public DateTime $created_at;

    public DateTime $updated_at;

    public Address $address;

    /**
     * @var \MB\ShipXSDK\Model\ShipmentSimple[]
     */
    public array $shipments;

    /**
     * @var \MB\ShipXSDK\Model\Comment[]
     */
    public array $comments;
}
