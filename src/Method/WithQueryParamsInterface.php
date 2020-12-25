<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method;

interface WithQueryParamsInterface
{
    public function getRequiredQueryParams(): array;

    public function getOptionalQueryParams(): array;
}
