<?php

namespace FOS\MessageBundle\FormModel;

use FOS\MessageBundle\Model\ParticipantInterface;

class NewThreadMessage extends AbstractMessage
{
    /**
     * The user who receives the message.
     */
    protected ParticipantInterface $recipient;

    /**
     * The thread subject.
     */
    protected string $subject;

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getRecipient(): ParticipantInterface
    {
        return $this->recipient;
    }

    public function setRecipient(ParticipantInterface $recipient): void
    {
        $this->recipient = $recipient;
    }
}
