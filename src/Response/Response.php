<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Response;

use Spatie\DataTransferObject\DataTransferObject;

class Response
{
    private bool $success;

    private ?DataTransferObject $payload;

    public function __construct(bool $success, ?DataTransferObject $payload)
    {
        $this->success = $success;
        $this->payload = $payload;
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }

    public function getPayload():? DataTransferObject
    {
        return $this->payload;
    }
}
