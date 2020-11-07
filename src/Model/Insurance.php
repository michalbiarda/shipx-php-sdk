<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class Insurance extends DataTransferObject
{
    public ?float $insurance_amount;

    public ?string $insurance_currency;
}
