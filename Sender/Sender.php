<?php

namespace FOS\MessageBundle\Sender;

use FOS\MessageBundle\Event\FOSMessageEvents;
use FOS\MessageBundle\Event\MessageEvent;
use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\ModelManager\MessageManagerInterface;
use FOS\MessageBundle\ModelManager\ThreadManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Sends messages.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class Sender implements SenderInterface
{
    protected MessageManagerInterface $messageManager;

    protected ThreadManagerInterface $threadManager;

    protected EventDispatcherInterface $dispatcher;

    public function __construct(MessageManagerInterface $messageManager, ThreadManagerInterface $threadManager, EventDispatcherInterface $dispatcher)
    {
        $this->messageManager = $messageManager;
        $this->threadManager = $threadManager;
        $this->dispatcher = $dispatcher;
    }

    public function send(MessageInterface $message): void
    {
        $this->threadManager->saveThread($message->getThread(), false);
        $this->messageManager->saveMessage($message, false);

        /* Note: Thread::setIsDeleted() depends on metadata existing for all
         * thread and message participants, so both objects must be saved first.
         * We can avoid flushing the object manager, since we must save once
         * again after undeleting the thread.
         */
        $message->getThread()->setIsDeleted(false);
        $this->messageManager->saveMessage($message);

        $this->dispatcher->dispatch(new MessageEvent($message), FOSMessageEvents::POST_SEND);
    }
}
