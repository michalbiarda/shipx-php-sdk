<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Form;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class ShipmentOffersCollection extends DataTransferObject
{
    /**
     * @var \MB\ShipXSDK\Form\ShipmentOfferItem[]
     */
    public array $shipments;
}
