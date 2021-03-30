<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Response;

use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Model\Error;
use MB\ShipXSDK\Response\Response;
use MB\ShipXSDK\Response\ResponseFactory;
use MB\ShipXSDK\Response\HttpResponseProcessor;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class ResponseFactoryTest extends TestCase
{
    private ResponseFactory $responseFactory;

    /**
     * @var MockObject|HttpResponseProcessor
     */
    private MockObject $responseProcessorMock;

    public function setUp(): void
    {
        $this->responseProcessorMock = $this->getMockBuilder(HttpResponseProcessor::class)
            ->disableOriginalConstructor()->getMock();
        $this->responseFactory = new ResponseFactory($this->responseProcessorMock);
    }

    public function testCreateReturnsErrorResponseWhenThereIsNoOneFromProcessor(): void
    {
        /** @var MockObject|MethodInterface $methodMock */
        $methodMock = $this->getMockBuilder(MethodInterface::class)->getMockForAbstractClass();
        /** @var MockObject|ResponseInterface $httpResponseMock */
        $httpResponseMock = $this->getMockBuilder(ResponseInterface::class)->getMockForAbstractClass();
        $result = $this->responseFactory->create($methodMock, $httpResponseMock);
        $this->assertFalse($result->getSuccess());
        $this->assertInstanceOf(Error::class, $result->getPayload());
    }

    public function testCreateReturnsResponseWhenProcessorReturnedOne(): void
    {
        /** @var MockObject|MethodInterface $methodMock */
        $methodMock = $this->getMockBuilder(MethodInterface::class)->getMockForAbstractClass();
        /** @var MockObject|ResponseInterface $httpResponseMock */
        $httpResponseMock = $this->getMockBuilder(ResponseInterface::class)->getMockForAbstractClass();
        $responseMock = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $this->responseProcessorMock->expects($this->any())->method('process')->willReturn($responseMock);
        $result = $this->responseFactory->create($methodMock, $httpResponseMock);
        $this->assertInstanceOf(Response::class, $result);
    }
}
