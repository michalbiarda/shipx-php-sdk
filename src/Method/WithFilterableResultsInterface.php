<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method;

interface WithFilterableResultsInterface
{
    public function getFilters(): array;
}
