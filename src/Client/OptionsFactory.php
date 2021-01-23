<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Client;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use MB\ShipXSDK\Request\Request;

class OptionsFactory
{
    /**
     * @param Request $request
     * @param array $requestMap
     * @param array $responseMap
     * @param int $timeout
     * @return array
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function create(
        Request $request,
        array $requestMap,
        array $responseMap,
        int $timeout
    ): array {
        $options = [];
        if ($request->getHeaders()) {
            $options['headers'] = $request->getHeaders();
        }
        if ($request->getPayload()) {
            $options['json'] = $request->getPayload();
        }
        $stack = HandlerStack::create();
        foreach ($requestMap as $fn) {
            $stack->push(Middleware::mapRequest($fn));
        }
        foreach ($responseMap as $fn) {
            $stack->push(Middleware::mapResponse($fn));
        }
        $options['handler'] = $stack;
        $options['connect_timeout'] = $timeout;
        $options['timeout'] = $timeout;
        return $options;
    }
}
