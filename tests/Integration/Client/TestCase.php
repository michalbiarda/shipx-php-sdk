<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Integration\Client;

use MB\ShipXSDK\Client\Client;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;
use MB\ShipXSDK\Model\BinaryContent;
use MB\ShipXSDK\Model\Error;
use MB\ShipXSDK\Response\Response;
use MB\ShipXSDK\Test\Integration\Config;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    protected const WRONG_ID = 'wrong_id';

    protected Client $client;

    protected string $organizationId;

    protected bool $withAuthToken = false;

    public function setUp(): void
    {
        $this->client = (new ClientFactory())->create($this->withAuthToken);
        $this->organizationId = Config::getOrganizationId();
    }

    protected function assertSuccess(Response $response, ?DataTransferObject $payload, ?string $payloadClass): void
    {
        $this->assertTrue($response->getSuccess());
        if ($payloadClass) {
            $this->assertInstanceOf($payloadClass, $payload);
            return;
        }
        $this->assertNull($payload);
    }

    protected function assertSuccessWithFile(Response $response, DataTransferObject $payload, string $contentType): void
    {
        if (!$response->getSuccess()) {
            $this->debug(print_r($response->getPayload()->toArray(), true));

            if ($response->getPayload()->status === 500) {
                $this->markTestSkipped('500 error: '. $response->getPayload()->message);
            }
        }

        $this->assertTrue($response->getSuccess());
        $this->assertInstanceOf(BinaryContent::class, $payload);
        /** @var BinaryContent $payload */
        $this->assertSame($contentType, $payload->content_type);
        $this->assertGreaterThan(0, $payload->stream->getSize());
    }

    protected function assertError(Response $response, DataTransferObject $payload): void
    {
        $this->assertFalse($response->getSuccess());
        $this->assertInstanceOf(Error::class, $payload);
    }

    protected function debug(string $message): void
    {
        if (Config::isDebugEnabled()) {
            $stdout = fopen('php://stdout', 'w');
            fwrite($stdout, $message);
            fclose($stdout);
        }
    }
}
