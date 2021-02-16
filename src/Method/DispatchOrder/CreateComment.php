<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Method\DispatchOrder;

use MB\ShipXSDK\Model\DispatchOrderCommentForm;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithJsonRequestInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Model\Comment;
use MB\ShipXSDK\Request\Request;

class CreateComment implements
    MethodInterface,
    WithJsonRequestInterface,
    WithJsonResponseInterface,
    WithAuthorizationInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_POST;
    }

    public function getUriTemplate(): string
    {
        return '/v1/organizations/:organization_id/dispatch_orders/:dispatch_order_id/comment';
    }

    public function getRequestPayloadModelName(): string
    {
        return DispatchOrderCommentForm::class;
    }

    public function getResponsePayloadModelName(): string
    {
        return Comment::class;
    }
}
