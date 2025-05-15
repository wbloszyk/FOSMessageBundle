<?php

namespace FOS\MessageBundle\Event;

use FOS\MessageBundle\Model\ReadableInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ReadableEvent extends Event
{
    private ReadableInterface $readable;

    public function __construct(ReadableInterface $readable)
    {
        $this->readable = $readable;
    }

    public function getReadable(): ReadableInterface
    {
        return $this->readable;
    }
}
