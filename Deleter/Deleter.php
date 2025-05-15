<?php

namespace FOS\MessageBundle\Deleter;

use FOS\MessageBundle\Event\FOSMessageEvents;
use FOS\MessageBundle\Event\ThreadEvent;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\Security\AuthorizerInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Marks threads as deleted.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class Deleter implements DeleterInterface
{
    protected AuthorizerInterface $authorizer;

    protected ParticipantProviderInterface $participantProvider;

    protected EventDispatcherInterface $dispatcher;

    public function __construct(AuthorizerInterface $authorizer, ParticipantProviderInterface $participantProvider, EventDispatcherInterface $dispatcher)
    {
        $this->authorizer = $authorizer;
        $this->participantProvider = $participantProvider;
        $this->dispatcher = $dispatcher;
    }

    public function markAsDeleted(ThreadInterface $thread): void
    {
        if (!$this->authorizer->canDeleteThread($thread)) {
            throw new AccessDeniedException('You are not allowed to delete this thread');
        }
        $thread->setIsDeletedByParticipant($this->getAuthenticatedParticipant(), true);

        $this->dispatcher->dispatch(new ThreadEvent($thread), FOSMessageEvents::POST_DELETE);
    }

    public function markAsUndeleted(ThreadInterface $thread): void
    {
        if (!$this->authorizer->canDeleteThread($thread)) {
            throw new AccessDeniedException('You are not allowed to delete this thread');
        }
        $thread->setIsDeletedByParticipant($this->getAuthenticatedParticipant(), false);

        $this->dispatcher->dispatch(new ThreadEvent($thread), FOSMessageEvents::POST_UNDELETE);
    }

    /**
     * Gets the current authenticated user.
     *
     * @return ParticipantInterface
     */
    protected function getAuthenticatedParticipant()
    {
        return $this->participantProvider->getAuthenticatedParticipant();
    }
}
