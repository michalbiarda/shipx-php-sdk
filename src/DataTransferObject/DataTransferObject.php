<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\DataTransferObject;

use MB\ShipXSDK\Exception\InvalidModelException;
use Spatie\DataTransferObject\DataTransferObject as OriginalDataTransferObject;
use Spatie\DataTransferObject\DataTransferObjectError;
use Spatie\DataTransferObject\FieldValidator;
use Spatie\DataTransferObject\ValueCaster as OriginalValueCaster;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
class DataTransferObject extends OriginalDataTransferObject
{
    protected bool $ignoreMissing = true;

    private const CODE_INVALID_PARAMS = 1;

    public function __construct(array $parameters = [])
    {
        try {
            parent::__construct($parameters);
        } catch (DataTransferObjectError $e) {
            throw new InvalidModelException(
                'Invalid params for model provided.',
                self::CODE_INVALID_PARAMS,
                $e
            );
        }
    }

    /**
     * @param OriginalValueCaster $valueCaster
     * @param FieldValidator      $fieldValidator
     * @param mixed               $value
     *
     * @return mixed
     */
    protected function castValue(OriginalValueCaster $valueCaster, FieldValidator $fieldValidator, $value)
    {
        return $valueCaster->cast($value, $fieldValidator);
    }

    protected function getValueCaster(): OriginalValueCaster
    {
        return new ValueCaster();
    }
}
