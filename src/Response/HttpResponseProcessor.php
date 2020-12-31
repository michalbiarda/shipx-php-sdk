<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Response;

use InvalidArgumentException;
use MB\ShipXSDK\Method\MethodInterface;
use MB\ShipXSDK\Response\HttpResponseProcessor\BinaryContentProcessor;
use MB\ShipXSDK\Response\HttpResponseProcessor\ErrorProcessor;
use MB\ShipXSDK\Response\HttpResponseProcessor\NoContentProcessor;
use MB\ShipXSDK\Response\HttpResponseProcessor\OkProcessor;
use MB\ShipXSDK\Response\HttpResponseProcessor\ProcessorInterface;
use Psr\Http\Message\ResponseInterface;

class HttpResponseProcessor
{
    /**
     * @var ProcessorInterface[]
     */
    private ?array $processors;

    public function __construct(?array $processors = null)
    {
        if (is_null($processors)) {
            $this->processors = $this->getDefaultProcessors();
        } else {
            $this->processors = $processors;
        }
    }

    public function process(MethodInterface $method, ResponseInterface $httpResponse): ?Response
    {
        foreach ($this->processors as $process) {
            if (!$process instanceof ProcessorInterface) {
                throw new InvalidArgumentException(sprintf('Process must implement %s.', ProcessorInterface::class));
            }
        }
        foreach ($this->processors as $process) {
            $result = $process->run($method, $httpResponse);
            if (!is_null($result)) {
                return $result;
            }
        }
        return null;
    }

    /**
     * @return ProcessorInterface[]
     */
    private function getDefaultProcessors(): array
    {
        return [
            new ErrorProcessor(),
            new OkProcessor(),
            new BinaryContentProcessor(),
            new NoContentProcessor()
        ];
    }
}
