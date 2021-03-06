<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\DataTransferObject;

use DateTime;
use Exception;
use Spatie\DataTransferObject\FieldValidator;
use Spatie\DataTransferObject\ValueCaster as OriginalValueCaster;

class ValueCaster extends OriginalValueCaster
{
    public function cast($value, FieldValidator $validator)
    {
        if (is_array($value)) {
            return parent::cast($value, $validator);
        }
        foreach ($validator->allowedTypes as $type) {
            if ($type === DateTime::class) {
                if (is_null($value)) {
                    return null;
                }
                return new DateTime($value);
            }
        }
        return $value;
    }
}
