<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Form;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class CreateMpk extends DataTransferObject
{
    public string $name;

    public string $description;
}
