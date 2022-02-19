<?php

/**
 * Copyright © Michał Biarda. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MB\ShipXSDK\Test\Unit\Stub\HttpResponse;

use Psr\Http\Message\StreamInterface;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
abstract class AbstractStreamWithContents implements StreamInterface
{
    public function __toString()
    {
        return $this->getContents();
    }

    public function close()
    {
    }

    public function detach()
    {
    }

    public function getSize()
    {
    }

    public function tell()
    {
        return 0;
    }

    public function eof()
    {
        return true;
    }

    public function isSeekable()
    {
        return false;
    }

    public function seek($offset, $whence = SEEK_SET)
    {
    }

    public function rewind()
    {
    }

    public function isWritable()
    {
        return false;
    }

    public function write($string)
    {
        return strlen($string);
    }

    public function isReadable()
    {
        return false;
    }

    public function read($length)
    {
        return '';
    }

    abstract public function getContents();

    public function getMetadata($key = null)
    {
    }
}
