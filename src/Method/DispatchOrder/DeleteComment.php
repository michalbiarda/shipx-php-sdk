<?php
/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MB\ShipXSDK\Method\DispatchOrder;

use MB\ShipXSDK\Form\DeleteComment as DeleteCommentForm;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithJsonRequestInterface;
use MB\ShipXSDK\Method\WithJsonResponseInterface;
use MB\ShipXSDK\Model\CreateDispatchOrder;
use MB\ShipXSDK\Request\Request;

class DeleteComment implements
    MethodInterface,
    WithJsonRequestInterface,
    WithJsonResponseInterface,
    WithAuthorizationInterface
{
    public function getRequestMethod(): string
    {
        return Request::METHOD_DELETE;
    }

    public function getUriTemplate(): string
    {
        return '/v1/organizations/:organization_id/dispatch_orders/:dispatch_order_id/comment';
    }

    public function getRequestPayloadModelName(): string
    {
        return DeleteCommentForm::class;
    }

    public function getResponsePayloadModelName(): string
    {
        return CreateDispatchOrder::class;
    }
}
