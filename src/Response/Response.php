<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Response;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

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

    public function getPayload(): ?DataTransferObject
    {
        return $this->payload;
    }
}
