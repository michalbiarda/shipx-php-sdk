<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Test\Unit\Stub;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class ModelWithItemsArray extends DataTransferObject
{
    /**
     * @var \MB\ShipXSDK\Test\Unit\Stub\ModelWithFooBarSimpleProperties[]
     */
    public array $items;
}
