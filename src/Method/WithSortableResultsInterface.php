<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method;

interface WithSortableResultsInterface
{
    public const SORT_BY_QUERY_PARAM = 'sort_by';
    public const SORT_ORDER_QUERY_PARAM = 'sort_order';
    public const SORT_ORDER_ASC = 'asc';
    public const SORT_ORDER_DESC = 'desc';

    public function getSortableFields(): array;
}
