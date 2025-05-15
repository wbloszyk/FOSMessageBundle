<?php

namespace FOS\MessageBundle\Event;

use FOS\MessageBundle\Model\ThreadInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ThreadEvent extends Event
{
    private ThreadInterface $thread;

    public function __construct(ThreadInterface $thread)
    {
        $this->thread = $thread;
    }

    public function getThread(): ThreadInterface
    {
        return $this->thread;
    }
}
