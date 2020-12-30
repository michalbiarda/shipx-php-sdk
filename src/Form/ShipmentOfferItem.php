<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Form;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class ShipmentOfferItem extends DataTransferObject
{
    public int $id;

    public int $shipment_id;

    public int $offer_id;
}
