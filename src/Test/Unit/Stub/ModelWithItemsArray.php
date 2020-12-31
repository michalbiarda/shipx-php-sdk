<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Stub;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class ModelWithItemsArray extends DataTransferObject
{
    /**
     * @var \MB\ShipXSDK\Test\Unit\Stub\ModelWithFooBarSimpleProperties[]
     */
    public array $items;
}
