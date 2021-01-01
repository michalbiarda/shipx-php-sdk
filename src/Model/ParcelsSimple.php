<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class ParcelsSimple extends DataTransferObject
{
    public ?DimensionsSimple $dimensions;

    public ?string $template;

    public ?WeightSimple $weight;

    public ?int $id;

    public ?bool $is_non_standard;

    public ?string $tracking_number;
}
