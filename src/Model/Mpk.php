<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use DateTime;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class Mpk extends DataTransferObject
{
    public int $id;

    public string $href;

    public string $name;

    public string $description;

    public DateTime $created_at;

    public DateTime $updated_at;
}
