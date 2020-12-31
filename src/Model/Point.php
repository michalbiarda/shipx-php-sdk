<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Model;

use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class Point extends DataTransferObject
{
    public string $href;

    public string $name;

    /**
     * @var string[]
     */
    public array $type;

    public string $status;

    public Location $location;

    public ?string $location_type;

    public ?string $location_description;

    public ?string $location_description_1;

    public ?string $location_description_2;

    public ?int $distance;

    public ?string $opening_hours;

    public PointAddress $address;

    public PointAddressDetails $address_details;

    public ?string $phone_number;

    public ?string $payment_point_descr;

    /**
     * @var string[]
     */
    public array $functions;

    public int $partner_id;

    public bool $is_next;

    public bool $payment_available;

    /**
     * @var string[]
     */
    public array $payment_type;

    public string $virtual;

    public ?array $recommended_low_interest_box_machines_list;

    public ?string $location_date;

    public bool $location_247;

    public array $operating_hours_extended;

    public ?string $agency;
}
