<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method;

interface MethodInterface
{
    public function getRequestMethod(): string;

    public function getUriTemplate(): string;
}
