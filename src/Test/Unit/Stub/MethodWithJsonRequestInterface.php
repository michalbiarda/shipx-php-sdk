<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Test\Unit\Stub;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithJsonRequestInterface;

interface MethodWithJsonRequestInterface extends MethodInterface, WithJsonRequestInterface
{

}