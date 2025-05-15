<?php

namespace FOS\MessageBundle\Reader;

use FOS\MessageBundle\Event\FOSMessageEvents;
use FOS\MessageBundle\Event\ReadableEvent;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ReadableInterface;
use FOS\MessageBundle\ModelManager\ReadableManagerInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Marks messages and threads as read or unread.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class Reader implements ReaderInterface
{
    protected ParticipantProviderInterface $participantProvider;

    protected ReadableManagerInterface $readableManager;

    protected EventDispatcherInterface $dispatcher;

    public function __construct(ParticipantProviderInterface $participantProvider, ReadableManagerInterface $readableManager, EventDispatcherInterface $dispatcher)
    {
        $this->participantProvider = $participantProvider;
        $this->readableManager = $readableManager;
        $this->dispatcher = $dispatcher;
    }

    public function markAsRead(ReadableInterface $readable): void
    {
        $participant = $this->getAuthenticatedParticipant();
        if ($readable->isReadByParticipant($participant)) {
            return;
        }
        $this->readableManager->markAsReadByParticipant($readable, $participant);

        $this->dispatcher->dispatch(new ReadableEvent($readable), FOSMessageEvents::POST_READ);
    }

    public function markAsUnread(ReadableInterface $readable): void
    {
        $participant = $this->getAuthenticatedParticipant();
        if (!$readable->isReadByParticipant($participant)) {
            return;
        }
        $this->readableManager->markAsUnreadByParticipant($readable, $participant);

        $this->dispatcher->dispatch(new ReadableEvent($readable), FOSMessageEvents::POST_UNREAD);
    }

    /**
     * Gets the current authenticated user.
     *
     * @return ParticipantInterface
     */
    protected function getAuthenticatedParticipant(): ?ParticipantInterface
    {
        return $this->participantProvider->getAuthenticatedParticipant();
    }
}
