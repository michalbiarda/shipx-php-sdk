<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use DateTime;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class Offer extends DataTransferObject
{
    public ?DateTime $expires_at;

    public string $status;

    public int $id;

    /**
     * @todo Check what is the correct type
     */
    public ?float $rate;

    public ?string $currency;

    public DescriptiveEntity $carrier;

    public DescriptiveEntity $service;

    /**
     * @var \MB\ShipXSDK\Model\DictionaryItem[]|null
     */
    public ?array $unavailability_reasons;

    /**
     * @todo Check what is the correct type
     */
    public array $additional_services;
}
