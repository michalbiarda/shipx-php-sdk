<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class ShipmentSimple extends DataTransferObject
{
    public string $href;

    public int $id;

    public ?string $tracking_number;

    public ?string $status;
}
