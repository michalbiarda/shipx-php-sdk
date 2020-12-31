<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Form;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class ShipmentOffersCollection extends DataTransferObject
{
    /**
     * @var \MB\ShipXSDK\Form\ShipmentOfferItem[]
     */
    public array $shipments;
}
