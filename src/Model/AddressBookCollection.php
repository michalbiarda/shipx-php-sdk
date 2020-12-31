<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

class AddressBookCollection extends AbstractCollection
{
    /**
     * @var \MB\ShipXSDK\Model\AddressBook[]
     */
    public array $items;
}
