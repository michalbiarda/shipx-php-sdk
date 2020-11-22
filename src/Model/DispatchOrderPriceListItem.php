<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class DispatchOrderPriceListItem extends DataTransferObject
{
    public int $count;

    public Price $price;

    /**
     * @var int[]
     */
    public int $shipments;
}