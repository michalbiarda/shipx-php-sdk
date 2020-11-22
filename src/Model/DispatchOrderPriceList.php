<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class DispatchOrderPriceList extends DataTransferObject
{
    public int $total_success_count;

    public int $total_error_count;

    public Price $total_price;

    /**
     * @var \MB\ShipXSDK\Model\DispatchOrderPriceListItem[]
     */
    public array $price_list;

    /**
     * @var array[]
     */
    public array $invalid_shipments;
}
