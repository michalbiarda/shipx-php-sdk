<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method;

interface WithQueryParamsInterface
{
    public function getRequiredQueryParams(): array;

    public function getOptionalQueryParams(): array;
}
