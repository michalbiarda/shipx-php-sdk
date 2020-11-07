<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class StatusCollection extends DataTransferObject
{
    public string $href;

    /**
     * @var \MB\ShipXSDK\Model\Status[]
     */
    public array $items;
}
