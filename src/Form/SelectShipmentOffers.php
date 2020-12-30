<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Form;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class SelectShipmentOffers extends DataTransferObject
{
    /**
     * @var \MB\ShipXSDK\Form\SelectShipmentOffers\Item[]
     */
    public array $shipments;
}
