<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Form;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class CreateShipmentBatch extends DataTransferObject
{
    public bool $only_choice_of_offer = false;

    /**
     * @var \MB\ShipXSDK\Form\CreateShipmentBatch\Item[]
     */
    public array $shipments;
}
