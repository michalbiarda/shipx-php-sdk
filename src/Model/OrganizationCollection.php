<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\AbstractCollection;

class OrganizationCollection extends AbstractCollection
{
    /**
     * @var \MB\ShipXSDK\Model\Organization[]
     */
    public array $items;
}
