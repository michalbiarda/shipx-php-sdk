<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Request;

use InvalidArgumentException;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;
use MB\ShipXSDK\Exception\InvalidQueryParamsException;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithSortableResultsInterface;
use MB\ShipXSDK\Request\RequestFactory;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithAuthorizationInterface;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithAuthorizationNeeded;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithFilterableResults;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithJsonRequestInterface;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithoutAuthorizationNeeded;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithoutPayload;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithoutUriParams;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithPaginatedResults;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithPayload;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithQueryParams;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithSortableResults;
use MB\ShipXSDK\Test\Unit\Stub\MethodWithUriParams;
use MB\ShipXSDK\Test\Unit\Stub\ModelWithFooBarSimpleProperties;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class RequestFactoryTest extends TestCase
{
    private RequestFactory $requestFactory;

    public function setUp(): void
    {
        $this->requestFactory = new RequestFactory();
    }

    public function testCreateThrowsExceptionWhenRequiredUriParamsNotFound(): void
    {
        $this->expectException(InvalidArgumentException::class);
        /** @var MockObject|MethodInterface $methodMock */
        $methodMock = $this->getMockBuilder(MethodInterface::class)->getMockForAbstractClass();
        $methodMock->expects($this->any())->method('getUriTemplate')
            ->willReturn('/uri/with/:param/inside');
        $this->requestFactory
            ->create($methodMock, ['wrong_param' => 'value']);
    }

    public function testCreateThrowsExceptionWhenPayloadIsNullButMethodNeedsSome(): void
    {
        $this->expectException(InvalidArgumentException::class);
        /** @var MockObject|MethodInterface $methodMock */
        $methodMock = $this->getMockBuilder(MethodWithJsonRequestInterface::class)->getMockForAbstractClass();
        $methodMock->expects($this->any())->method('getRequestPayloadModelName')
            ->willReturn('/Some/Model');
        $this->requestFactory->create($methodMock);
    }

    public function testCreateThrowsExceptionWhenPayloadIsNotNullButMethodDoesNotNeedOne(): void
    {
        $this->expectException(InvalidArgumentException::class);
        /** @var MockObject|MethodInterface $methodMock */
        $methodMock = $this->getMockBuilder(MethodInterface::class)->getMockForAbstractClass();
        /** @var MockObject|DataTransferObject $payloadMock */
        $payloadMock = $this->getMockBuilder(DataTransferObject::class)->getMock();
        $this->requestFactory->create($methodMock, [], [], $payloadMock);
    }

    public function testCreateThrowsExceptionWhenPayloadObjectIsNotAnInstanceOfClassSpecifiedInMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);
        /** @var MockObject|MethodInterface $methodMock */
        $methodMock = $this->getMockBuilder(MethodWithJsonRequestInterface::class)->getMockForAbstractClass();
        $methodMock->expects($this->any())->method('getRequestPayloadModelName')
            ->willReturn('/Some/Model');
        /** @var MockObject|DataTransferObject $payloadMock */
        $payloadMock = $this->getMockBuilder(DataTransferObject::class)->getMock();
        $this->requestFactory->create($methodMock, [], [], $payloadMock);
    }

    public function testCreateThrowsExceptionWhenAuthTokenIsNullButNeededByMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);
        /** @var MockObject|MethodInterface $methodMock */
        $methodMock = $this->getMockBuilder(MethodWithAuthorizationInterface::class)
            ->getMockForAbstractClass();
        $this->requestFactory->create($methodMock);
    }

    public function testCreateThrowsExceptionWhenAuthTokenIsNotNullButItIsNotNeededByMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);
        /** @var MockObject|MethodInterface $methodMock */
        $methodMock = $this->getMockBuilder(MethodInterface::class)->getMockForAbstractClass();
        $this->requestFactory->create($methodMock, [], [], null, 'token123');
    }

    /**
     * @dataProvider correctUriDataProvider
     */
    public function testCreateReturnsRequestWithCorrectUri(
        MethodInterface $methodStub,
        array $uriParams,
        string $expectedUri
    ): void {
        $result = $this->requestFactory->create($methodStub, $uriParams);
        $this->assertSame($expectedUri, $result->getUri());
    }

    /**
     * @dataProvider correctPayloadDataProvider
     */
    public function testCreateReturnsRequestWithCorrectPayload(
        MethodInterface $methodStub,
        ?DataTransferObject $payloadObject,
        ?array $expectedPayload
    ): void {
        $result = $this->requestFactory->create($methodStub, [], [], $payloadObject);
        $this->assertSame($expectedPayload, $result->getPayload());
    }

    /**
     * @dataProvider correctHeadersDataProvider
     */
    public function testCreateReturnsRequestWithCorrectHeaders(
        MethodInterface $methodStub,
        ?string $authToken,
        ?array $expectedHeaders
    ): void {
        $result = $this->requestFactory->create($methodStub, [], [], null, $authToken);
        $this->assertSame($expectedHeaders, $result->getHeaders());
    }

    /**
     * @dataProvider incorrectQueryParamsDataProvider()
     */
    public function testCreateThrowsExceptionWhenIncorrectQueryParamsWereUsed(
        MethodInterface $method,
        array $queryParams
    ): void {
        $this->expectException(InvalidQueryParamsException::class);
        $this->requestFactory->create($method, [], $queryParams);
    }

    /**
     * @dataProvider correctQueryParamsDataProvider()
     */
    public function testCreateReturnsRequestWithCorrectQueryParams(
        MethodInterface $method,
        array $queryParams,
        string $expectedUriSuffix
    ): void {
        $result = $this->requestFactory->create($method, [], $queryParams);
        $this->assertStringEndsWith($expectedUriSuffix, $result->getUri());
    }

    public function correctUriDataProvider(): array
    {
        return [
            [new MethodWithoutUriParams(), [], '/some/uri/without/params'],
            [new MethodWithUriParams(), ['foo' => 'far', 'bar' => 'boo'], '/some/uri/with/params/far/boo']
        ];
    }

    public function correctPayloadDataProvider(): array
    {
        return [
            [new MethodWithoutPayload(), null, null],
            [
                new MethodWithPayload(),
                new ModelWithFooBarSimpleProperties(['foo' => 'boo', 'bar' => 'far']),
                ['foo' => 'boo', 'bar' => 'far']]
        ];
    }

    public function correctHeadersDataProvider(): array
    {
        return [
            [new MethodWithoutAuthorizationNeeded(), null, null],
            [new MethodWithAuthorizationNeeded(), 'token123', ['Authorization' => 'Bearer token123']]
        ];
    }

    public function incorrectQueryParamsDataProvider(): array
    {
        return [
            [
                $this->getMockBuilder(MethodInterface::class)->getMockForAbstractClass(),
                ['any' => 'param']
            ],
            [
                $this->getMockBuilder(MethodInterface::class)->getMockForAbstractClass(),
                ['sort_by' => 'param']
            ],
            [
                $this->getMockBuilder(MethodInterface::class)->getMockForAbstractClass(),
                ['sort_order' => 'asc']
            ],
            [
                $this->getMockBuilder(MethodInterface::class)->getMockForAbstractClass(),
                ['page' => '10']
            ],
            [
                new MethodWithSortableResults(),
                ['sort_by' => 'wrong_field']
            ],
            [
                new MethodWithSortableResults(),
                ['sort_order' => 'wrong_order']
            ],
            [
                new MethodWithFilterableResults(),
                ['boo' => 'value']
            ],
            [
                new MethodWithQueryParams(),
                ['foo' => 'a']
            ],
            [
                new MethodWithQueryParams(),
                ['foo' => 'a', 'bar' => 'b', 'gar' => 'c']
            ]
        ];
    }

    public function correctQueryParamsDataProvider()
    {
        return [
            [
                new MethodWithSortableResults(),
                [WithSortableResultsInterface::SORT_BY_QUERY_PARAM => 'foo'],
                '?sort_by=foo'
            ],
            [
                new MethodWithSortableResults(),
                [
                    WithSortableResultsInterface::SORT_BY_QUERY_PARAM => 'foo',
                    WithSortableResultsInterface::SORT_ORDER_QUERY_PARAM => WithSortableResultsInterface::SORT_ORDER_ASC
                ],
                '?sort_by=foo&sort_order=asc'
            ],
            [
                new MethodWithSortableResults(),
                [
                    WithSortableResultsInterface::SORT_BY_QUERY_PARAM => 'foo',
                    WithSortableResultsInterface::SORT_ORDER_QUERY_PARAM
                        => WithSortableResultsInterface::SORT_ORDER_DESC
                ],
                '?sort_by=foo&sort_order=desc'
            ],
            [
                new MethodWithFilterableResults(),
                ['foo' => 'value'],
                '?foo=value'
            ],
            [
                new MethodWithFilterableResults(),
                ['foo' => 'boo', 'bar' => 'far'],
                '?foo=boo&bar=far'
            ],
            [
                new MethodWithPaginatedResults(),
                ['page' => '10'],
                '?page=10'
            ],
            [
                new MethodWithQueryParams(),
                ['foo' => 'a', 'bar' => 'b', 'boo' => 'c'],
                '?foo=a&bar=b&boo=c'
            ],
            [
                new MethodWithQueryParams(),
                ['foo' => 'a', 'bar' => ['b', 'c']],
                '?foo=a&bar%5B%5D=b&bar%5B%5D=c'
            ]
        ];
    }
}
