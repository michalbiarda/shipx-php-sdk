<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Form\CreateShipmentBatch;

use MB\ShipXSDK\Form\AbstractCreateShipment;

class Item extends AbstractCreateShipment
{
    public int $id;

    public string $service;
}
