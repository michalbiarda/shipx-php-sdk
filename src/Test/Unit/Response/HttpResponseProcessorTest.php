<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Response;

use InvalidArgumentException;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Model\BinaryContent;
use MB\ShipXSDK\Model\Error;
use MB\ShipXSDK\Response\HttpResponseProcessor;
use MB\ShipXSDK\Response\Response;
use MB\ShipXSDK\Test\Unit\Stub\HttpResponse\ErrorResponse;
use MB\ShipXSDK\Test\Unit\Stub\HttpResponse\NoContentResponse;
use MB\ShipXSDK\Test\Unit\Stub\HttpResponse\OkResponse;
use MB\ShipXSDK\Test\Unit\Stub\HttpResponse\Response200WithBinaryBody;
use MB\ShipXSDK\Test\Unit\Stub\HttpResponse\Response200WithErrorData;
use MB\ShipXSDK\Test\Unit\Stub\HttpResponse\Response200WithJsonArrayBody;
use MB\ShipXSDK\Test\Unit\Stub\HttpResponse\Response200WithoutJsonBody;
use MB\ShipXSDK\Test\Unit\Stub\HttpResponse\Response200WithoutJsonHeader;
use MB\ShipXSDK\Test\Unit\Stub\HttpResponse\Response400WithoutJsonBody;
use MB\ShipXSDK\Test\Unit\Stub\HttpResponse\Response400WithoutJsonHeader;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithArrayResponsePayload;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithBinaryResponse;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithoutPayload;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithResponsePayload;
use MB\ShipXSDK\Test\Unit\Stub\ProcessorReturningNull;
use MB\ShipXSDK\Test\Unit\Stub\ProcessorReturningSimpleResponse;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class HttpResponseProcessorTest extends TestCase
{
    /**
     * @var MockObject|MethodInterface
     */
    private MockObject $methodMock;

    /**
     * @var MockObject|ResponseInterface
     */
    private MockObject $httpResponseMock;

    public function setUp(): void
    {
        $this->methodMock = $this->getMockBuilder(MethodInterface::class)->getMockForAbstractClass();
        $this->httpResponseMock = $this->getMockBuilder(ResponseInterface::class)->getMockForAbstractClass();
    }

    public function testProcessReturnsNullIfNoProcessesAreDefined(): void
    {
        $responseProcessor = new HttpResponseProcessor([]);
        $result = $responseProcessor->process($this->methodMock, $this->httpResponseMock);
        $this->assertNull($result);
    }

    public function testProcessThrowsExceptionIfNthObjectInProcessesArrayIsNotAProcess(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $notProcessMock = $this->getMockBuilder('\Not\Process')->getMock();
        $responseProcessor = new HttpResponseProcessor([new ProcessorReturningNull(), $notProcessMock]);
        $responseProcessor->process($this->methodMock, $this->httpResponseMock);
    }

    public function testProcessReturnsNullIfAllDefinedProcessesReturnNull(): void
    {
        $responseProcessor = new HttpResponseProcessor(
            [new ProcessorReturningNull(), new ProcessorReturningNull()]
        );
        $result = $responseProcessor->process($this->methodMock, $this->httpResponseMock);
        $this->assertNull($result);
    }

    public function testProcessReturnsResponseIfOneOfDefinedProcessesReturnsResponse(): void
    {
        $responseProcessor = new HttpResponseProcessor(
            [new ProcessorReturningNull(), new ProcessorReturningSimpleResponse()]
        );
        $result = $responseProcessor->process($this->methodMock, $this->httpResponseMock);
        $this->assertInstanceOf(Response::class, $result);
    }

    /**
     * @dataProvider errorStatusCodesDataProvider()
     * @param int $errorStatusCode
     */
    public function testProcessReturnsProperResponseForCorrectHttpErrorResponses(int $errorStatusCode): void
    {
        $responseProcessor = new HttpResponseProcessor();
        $result = $responseProcessor->process($this->methodMock, new ErrorResponse($errorStatusCode));
        $this->assertInstanceOf(Response::class, $result);
        $this->assertFalse($result->getSuccess());
        $this->assertInstanceOf(Error::class, $result->getPayload());
        $this->assertSame($errorStatusCode, $result->getPayload()->toArray()['status']);
    }

    public function testProcessReturnsProperResponseForHttp200ResponseWithErrorData(): void
    {
        $responseProcessor = new HttpResponseProcessor();
        $result = $responseProcessor->process($this->methodMock, new Response200WithErrorData());
        $this->assertInstanceOf(Response::class, $result);
        $this->assertFalse($result->getSuccess());
        $this->assertInstanceOf(Error::class, $result->getPayload());
    }

    /**
     * @dataProvider incorrectResponse400DataProvider()
     * @param ResponseInterface $response
     */
    public function testProcessReturnsNullForIncorrectHttp400Response(ResponseInterface $response): void
    {
        $responseProcessor = new HttpResponseProcessor();
        $result = $responseProcessor->process($this->methodMock, $response);
        $this->assertNull($result);
    }

    /**
     * @dataProvider okStatusCodesDataProvider()
     * @param int $okStatusCode
     */
    public function testProcessReturnsProperResponseForCorrectOkResponse(int $okStatusCode): void
    {
        $responseProcessor = new HttpResponseProcessor();
        $result = $responseProcessor->process(new MethodWithResponsePayload(), new OkResponse($okStatusCode));
        $this->assertInstanceOf(Response::class, $result);
        $this->assertTrue($result->getSuccess());
        $this->assertInstanceOf(DataTransferObject::class, $result->getPayload());
    }

    public function testProcessReturnsProperResponseForOkResponseWithJsonArray(): void
    {
        $responseProcessor = new HttpResponseProcessor();
        $result = $responseProcessor
            ->process(new MethodWithArrayResponsePayload(), new Response200WithJsonArrayBody());
        $this->assertInstanceOf(Response::class, $result);
        $this->assertTrue($result->getSuccess());
        $this->assertInstanceOf(DataTransferObject::class, $result->getPayload());
    }

    public function testProcessReturnsProperResponseForOkResponseWithBinaryContent(): void
    {
        $responseProcessor = new HttpResponseProcessor();
        $result = $responseProcessor->process(new MethodWithBinaryResponse(), new Response200WithBinaryBody());
        $this->assertInstanceOf(Response::class, $result);
        $this->assertTrue($result->getSuccess());
        $this->assertInstanceOf(BinaryContent::class, $result->getPayload());
    }

    /**
     * @dataProvider incorrectResponse200DataProvider()
     * @param ResponseInterface $response
     */
    public function testProcessReturnsNullForIncorrectHttp200Response(ResponseInterface $response): void
    {
        $responseProcessor = new HttpResponseProcessor();
        $result = $responseProcessor->process(new MethodWithResponsePayload(), $response);
        $this->assertNull($result);
    }

    public function testProcessReturnsNullForCorrectHttp200ResponseAndIncorrectMethod(): void
    {
        $responseProcessor = new HttpResponseProcessor();
        $result = $responseProcessor->process(new MethodWithoutPayload(), new OkResponse(200));
        $this->assertNull($result);
    }

    public function testProcessReturnsProperResponseForCorrectNoContentResponse(): void
    {
        $responseProcessor = new HttpResponseProcessor();
        $result = $responseProcessor->process(new MethodWithoutPayload(), new NoContentResponse());
        $this->assertInstanceOf(Response::class, $result);
        $this->assertTrue($result->getSuccess());
        $this->assertNull($result->getPayload());
    }

    public function testProcessReturnsNullForCorrectNoContentResponseAndIncorrectMethod(): void
    {
        $responseProcessor = new HttpResponseProcessor();
        $result = $responseProcessor->process(new MethodWithResponsePayload(), new NoContentResponse());
        $this->assertNull($result);
    }

    public function errorStatusCodesDataProvider(): array
    {
        return [[400], [401], [403], [404], [500]];
    }

    public function okStatusCodesDataProvider(): array
    {
        return [[200], [201]];
    }

    public function incorrectResponse400DataProvider(): array
    {
        return [
            [new Response400WithoutJsonHeader()],
            [new Response400WithoutJsonBody()]
        ];
    }

    public function incorrectResponse200DataProvider(): array
    {
        return [
            [new Response200WithoutJsonHeader()],
            [new Response200WithoutJsonBody()]
        ];
    }
}
