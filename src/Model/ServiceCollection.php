<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class ServiceCollection extends DataTransferObject
{
    /**
     * @var \MB\ShipXSDK\Model\Service[]
     */
    public array $items;
}
