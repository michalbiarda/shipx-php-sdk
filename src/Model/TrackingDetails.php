<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use DateTime;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class TrackingDetails extends DataTransferObject
{
    public string $status;

    public string $origin_status;

    public ?string $agency;

    public DateTime $datetime;
}
