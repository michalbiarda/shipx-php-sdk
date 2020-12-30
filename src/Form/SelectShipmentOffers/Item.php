<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Form\SelectShipmentOffers;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class Item extends DataTransferObject
{
    public int $id;

    public int $shipment_id;

    public int $offer_id;
}
