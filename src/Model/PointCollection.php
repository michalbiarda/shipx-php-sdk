<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

class PointCollection extends AbstractCollection
{
    /**
     * @var \MB\ShipXSDK\Model\Point[]
     */
    public array $items;

    public int $total_pages;

    public array $meta;
}
