<?php

namespace FOS\MessageBundle\FormModel;

use FOS\MessageBundle\Model\ThreadInterface;

class ReplyMessage extends AbstractMessage
{

    protected ThreadInterface $thread;

    public function getThread(): ThreadInterface
    {
        return $this->thread;
    }

    public function setThread(ThreadInterface $thread): void
    {
        $this->thread = $thread;
    }
}
