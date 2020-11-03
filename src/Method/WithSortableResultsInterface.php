<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method;

interface WithSortableResultsInterface
{
    const SORT_BY_QUERY_PARAM = 'sort_by';
    const SORT_ORDER_QUERY_PARAM = 'sort_order';
    const SORT_ORDER_ASC = 'asc';
    const SORT_ORDER_DESC = 'desc';

    public function getSortableFields(): array;
}
