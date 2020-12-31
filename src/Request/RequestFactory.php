<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Request;

use InvalidArgumentException;
use MB\ShipXSDK\DataTransferObject\DataTransferObject;
use MB\ShipXSDK\Exception\InvalidQueryParamsException;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Method\WithAuthorizationInterface;
use MB\ShipXSDK\Method\WithFilterableResultsInterface;
use MB\ShipXSDK\Method\WithJsonRequestInterface;
use MB\ShipXSDK\Method\WithPaginatedResultsInterface;
use MB\ShipXSDK\Method\WithQueryParamsInterface;
use MB\ShipXSDK\Method\WithSortableResultsInterface;

class RequestFactory
{
    public function create(
        MethodInterface $method,
        array $uriParams = [],
        array $queryParams = [],
        ?DataTransferObject $payload = null,
        ?string $authToken = null
    ): Request {
        return new Request(
            $method->getRequestMethod(),
            $this->buildUri($method, $uriParams, $queryParams),
            $this->buildPayloadArray($method, $payload),
            $this->buildHeadersArray($method, $authToken)
        );
    }

    /**
     * @param MethodInterface $method
     * @param array $uriParams
     * @param array $queryParams
     * @return string
     * @throws InvalidArgumentException
     * @throws InvalidQueryParamsException
     */
    private function buildUri(MethodInterface $method, array $uriParams, array $queryParams): string
    {
        $uri = $method->getUriTemplate();
        $uriParamsFromTemplate = $this->getUriParamsFromTemplate($uri);
        foreach ($uriParamsFromTemplate as $param) {
            if (!array_key_exists($param, $uriParams)) {
                throw new InvalidArgumentException(sprintf('Value for "%s" param is missing.', $param));
            }
            $uri = str_replace(':' . $param, $uriParams[$param], $uri);
        }
        $this->validateQueryParams($queryParams, $method);
        $query = http_build_query($queryParams);
        $query = preg_replace('/%5B\d+%5D/', '%5B%5D', $query);
        return $uri . ($query ? '?' . $query : '');
    }

    /**
     * @param MethodInterface $method
     * @param DataTransferObject|null $payload
     * @return array|null
     */
    private function buildPayloadArray(MethodInterface $method, ?DataTransferObject $payload): ?array
    {
        if ($method instanceof WithJsonRequestInterface) {
            if (is_null($payload)) {
                throw new InvalidArgumentException('Payload cannot be null.');
            } elseif (get_class($payload) !== $method->getRequestPayloadModelName()) {
                throw new InvalidArgumentException(
                    sprintf('Payload must be an instance of "%s".', $method->getRequestPayloadModelName())
                );
            }
            return $payload->toArray();
        }
        if (!is_null($payload)) {
            throw new InvalidArgumentException('Payload must be null.');
        }
        return null;
    }

    /**
     * @param MethodInterface $method
     * @param string|null $authToken
     * @return array|null
     */
    private function buildHeadersArray(MethodInterface $method, ?string $authToken): ?array
    {
        $headersArray = null;
        if ($method instanceof WithAuthorizationInterface && is_null($authToken)) {
            throw new InvalidArgumentException('Auth token cannot be null.');
        }
        if (!$method instanceof WithAuthorizationInterface && !is_null($authToken)) {
            throw new InvalidArgumentException('Auth token must be null.');
        }
        if (!is_null($authToken)) {
            $headersArray['Authorization'] = 'Bearer ' . $authToken;
        }
        return $headersArray;
    }

    /**
     * @param string $param
     * @param string|null $value
     */
    private function throwInvalidQueryParamException(string $param, ?string $value = null): void
    {
        if (is_null($value)) {
            throw new InvalidQueryParamsException(
                sprintf('Query param "%s" is not allowed for this method.', $param)
            );
        }
        throw new InvalidQueryParamsException(
            sprintf('Value "%s" is not allowed for param "%s" for this method.', $value, $param)
        );
    }

    /**
     * @param string $uriTemplate
     * @return string[]
     * @SuppressWarnings(PHPMD.UndefinedVariable)
     */
    private function getUriParamsFromTemplate(string $uriTemplate): array
    {
        preg_match_all('/:([a-z_]+)/', $uriTemplate, $matches);
        return $matches[1];
    }

    private function validateQueryParams(array $queryParams, MethodInterface $method): void
    {
        $this->validateRequiredParams($method, $queryParams);
        foreach ($queryParams as $param => $value) {
            switch ($param) {
                case WithSortableResultsInterface::SORT_BY_QUERY_PARAM:
                    $this->validateSortByQueryParam($method, $param, $value);
                    break;
                case WithSortableResultsInterface::SORT_ORDER_QUERY_PARAM:
                    $this->validateSortOrderQueryParam($method, $param, $value);
                    break;
                case WithPaginatedResultsInterface::PAGE_QUERY_PARAM:
                    $this->validatePageQueryParam($method, $param);
                    break;
                default:
                    $this->validateDefaultQueryParam($method, $param);
                    break;
            }
        }
    }

    private function validateRequiredParams(MethodInterface $method, array $queryParams): void
    {
        $requiredParams = [];
        if ($method instanceof WithQueryParamsInterface) {
            /** @var WithQueryParamsInterface $method */
            $requiredParams = array_merge($requiredParams, $method->getRequiredQueryParams());
        }
        $missingRequiredParams = array_diff($requiredParams, array_keys($queryParams));
        if (!empty($missingRequiredParams)) {
            throw new InvalidQueryParamsException(sprintf(
                'Values for the following query params are missing: %s',
                join(', ', $missingRequiredParams)
            ));
        }
    }

    private function validateSortByQueryParam(MethodInterface $method, string $param, $value): void
    {
        if (!$method instanceof WithSortableResultsInterface) {
            $this->throwInvalidQueryParamException($param);
        }
        /** @var $method WithSortableResultsInterface */
        if (!in_array($value, $method->getSortableFields())) {
            $this->throwInvalidQueryParamException($param, $value);
        }
    }

    private function validateSortOrderQueryParam(MethodInterface $method, string $param, $value): void
    {
        if (!$method instanceof WithSortableResultsInterface) {
            $this->throwInvalidQueryParamException($param);
        }
        /** @var $method WithSortableResultsInterface */
        if (
            !in_array(
                $value,
                [
                    WithSortableResultsInterface::SORT_ORDER_ASC,
                    WithSortableResultsInterface::SORT_ORDER_DESC
                ]
            )
        ) {
            $this->throwInvalidQueryParamException($param, $value);
        }
    }

    private function validatePageQueryParam(MethodInterface $method, string $param): void
    {
        if (!$method instanceof WithPaginatedResultsInterface) {
            $this->throwInvalidQueryParamException($param);
        }
    }

    private function validateDefaultQueryParam(MethodInterface $method, string $param): void
    {
        $validParams = [];
        if ($method instanceof WithFilterableResultsInterface) {
            /** @var $method WithFilterableResultsInterface */
            $validParams = array_merge($validParams, $method->getFilters());
        }
        if ($method instanceof WithQueryParamsInterface) {
            /** @var $method WithQueryParamsInterface */
            $validParams = array_merge(
                $validParams,
                $method->getOptionalQueryParams(),
                $method->getRequiredQueryParams()
            );
        }
        if (!in_array($param, $validParams)) {
            $this->throwInvalidQueryParamException($param);
        }
    }
}
