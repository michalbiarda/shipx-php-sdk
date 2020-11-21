<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Model;

use DateTime;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;

class User extends DataTransferObject
{
    public string $href;

    public int $id;

    public string $email;

    public string $first_name;

    public string $last_name;

    public string $status;

    public DateTime $created_at;

    public DateTime $updated_at;
}