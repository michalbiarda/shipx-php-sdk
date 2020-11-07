<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class ParcelsSimple extends DataTransferObject
{
    public ?DimensionsSimple $dimensions;

    public ?string $template;

    public ?WeightSimple $weight;

    public ?string $id;

    public ?bool $is_non_standard;

    public ?string $tracking_number;
}
