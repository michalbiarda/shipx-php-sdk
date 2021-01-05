<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Client;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;
use Psr\Http\Message\ResponseInterface;

use function is_null;
use function strpos;

class RequestSender
{
    private ?HttpClient $httpClient;

    public function __construct(?HttpClient $httpClient = null)
    {
        if (is_null($httpClient)) {
            $httpClient = new HttpClient();
        }
        $this->httpClient = $httpClient;
    }

    public function send(string $httpMethod, string $uri, array $options, int $repeatsOnTimeout): ResponseInterface
    {
        try {
            $counter = 0;
            do {
                $counter++;
                $timeout = false;
                $connectException = null;
                try {
                    $httpResponse = $this->httpClient->request($httpMethod, $uri, $options);
                } catch (ConnectException $e) {
                    $connectException = $e;
                    if (strpos($e->getMessage(), 'cURL error 28') !== false) {
                        $timeout = true;
                    }
                    if (!$timeout) {
                        throw $e;
                    }
                }
            } while ($counter <= $repeatsOnTimeout && $timeout);
            if (!is_null($connectException)) {
                throw $connectException;
            }
        } catch (BadResponseException $e) {
            $httpResponse = $e->getResponse();
        }
        return $httpResponse;
    }
}
