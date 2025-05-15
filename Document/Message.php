<?php

namespace FOS\MessageBundle\Document;

use FOS\MessageBundle\Model\Message as BaseMessage;

abstract class Message extends BaseMessage
{
    /**
     * Tells if the message is spam or flood
     * This denormalizes Thread.isSpam.
     */
    protected bool $isSpam = false;

    /**
     * The unreadForParticipants array will contain a participant's ID if the
     * message is not read by the participant and the message is not spam.
     *
     * @var array of participant ID's
     */
    protected array $unreadForParticipants = [];

    public function setIsSpam(bool $isSpam): void
    {
        $this->isSpam = $isSpam;
    }

    /*
     * DENORMALIZATION
     *
     * All following methods are relative to denormalization
     */

    /**
     * Performs denormalization tricks.
     */
    public function denormalize(): void
    {
        $this->doSenderIsRead();
        $this->doEnsureUnreadForParticipantsArray();
    }

    /**
     * Ensures that the sender is considered to have read this message.
     */
    protected function doSenderIsRead(): void
    {
        $this->setIsReadByParticipant($this->getSender(), true);
    }

    /**
     * Ensures that the unreadForParticipants array is updated.
     */
    protected function doEnsureUnreadForParticipantsArray(): void
    {
        $this->unreadForParticipants = array();

        if ($this->isSpam) {
            return;
        }

        foreach ($this->metadata as $metadata) {
            if (!$metadata->getIsRead()) {
                $this->unreadForParticipants[] = $metadata->getParticipant()->getId();
            }
        }
    }
}
