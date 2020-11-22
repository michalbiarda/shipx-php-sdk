<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use DateTime;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class Comment extends DataTransferObject
{
    public int $id;

    public ?string $href;

    public string $comment;

    public DateTime $created_at;
}