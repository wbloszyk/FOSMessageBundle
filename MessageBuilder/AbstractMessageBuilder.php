<?php

namespace FOS\MessageBundle\MessageBuilder;

use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ThreadInterface;

/**
 * Fluent interface message builder.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
abstract class AbstractMessageBuilder
{
    /**
     * The message we are building.
     */
    protected MessageInterface $message;

    /**
     * The thread the message goes in.
     */
    protected ThreadInterface $thread;

    public function __construct(MessageInterface $message, ThreadInterface $thread)
    {
        $this->message = $message;
        $this->thread = $thread;

        $this->message->setThread($thread);
        $thread->addMessage($message);
    }

    public function getMessage(): MessageInterface
    {
        return $this->message;
    }

    public function setBody(string $body): self
    {
        $this->message->setBody($body);

        return $this;
    }

    public function setSender(ParticipantInterface $sender): self
    {
        $this->message->setSender($sender);
        $this->thread->addParticipant($sender);

        return $this;
    }
}
