<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

class Service extends DescriptiveEntity
{
    /**
     * @var \MB\ShipXSDK\Model\DescriptiveEntity[]
     */
    public array $additional_services;
}
