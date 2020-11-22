<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Form;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class DeleteComment extends DataTransferObject
{
    /**
     * @var int[]
     */
    public array $comment_ids;
}