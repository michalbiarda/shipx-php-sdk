<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class DescriptiveEntity extends DataTransferObject
{
    public string $id;

    public string $name;

    public string $description;
}
