<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\AbstractCollection;

class PointCollection extends AbstractCollection
{
    /**
     * @var \MB\ShipXSDK\Model\Point[]
     */
    public array $items;

    public int $total_pages;

    public array $meta;
}