<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use DateTime;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class Tracking extends DataTransferObject
{
    public string $tracking_number;

    public string $type;

    public string $service;

    public TrackingCustomAttributes $custom_attributes;

    public string $status;

    public DateTime $created_at;

    public DateTime $updated_at;

    /**
     * @var \MB\ShipXSDK\Model\TrackingDetails[]
     */
    public array $tracking_details;

    public array $expected_flow;
}
