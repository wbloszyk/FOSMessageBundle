<?php

namespace FOS\MessageBundle\FormModel;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * Class for handling multiple recipients in thread.
 */
class NewThreadMultipleMessage extends AbstractMessage
{
    /**
     * The user who receives the message.
     */
    protected Collection $recipients;

    /**
     * The thread subject.
     */
    protected string $subject;

    public function __construct()
    {
        $this->recipients = new ArrayCollection();
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getRecipients(): ArrayCollection
    {
        return $this->recipients;
    }

    /**
     * Adds single recipient to collection.
     */
    public function addRecipient(ParticipantInterface $recipient): void
    {
        if (!$this->recipients->contains($recipient)) {
            $this->recipients->add($recipient);
        }
    }

    /**
     * Removes recipient from collection.
     */
    public function removeRecipient(ParticipantInterface $recipient): void
    {
        $this->recipients->removeElement($recipient);
    }
}
