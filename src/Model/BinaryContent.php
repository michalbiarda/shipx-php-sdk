<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;
use Psr\Http\Message\StreamInterface;

class BinaryContent extends DataTransferObject
{
    public StreamInterface $stream;

    public string $content_type;
}
