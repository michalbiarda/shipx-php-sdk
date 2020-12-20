<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;
use Psr\Http\Message\StreamInterface;

class BinaryContent extends DataTransferObject
{
    public StreamInterface $stream;

    public string $content_type;
}
