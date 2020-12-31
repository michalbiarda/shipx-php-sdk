<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use DateTime;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class Transaction extends DataTransferObject
{
    public int $id;

    public string $status;

    public int $offer_id;

    /**
     * @todo Check what is the correct type
     */
    public array $details;

    public DateTime $created_at;

    public DateTime $updated_at;
}
