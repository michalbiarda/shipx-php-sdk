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
    public const TIMEOUT = 30;

    /**
     * @param Request $request
     * @param \Closure[] $requestMap
     * @param \Closure[] $responseMap
     * @return array
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function create(Request $request, array $requestMap, array $responseMap): array
    {
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
        // @todo Unhardcode timeout value
        $options['connect_timeout'] = self::TIMEOUT;
        $options['timeout'] = self::TIMEOUT;
        return $options;
    }
}
