<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class DispatchOrderCommentUpdateForm extends DataTransferObject
{
    public ?int $id;

    public ?string $comment;
}
