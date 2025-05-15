<?php

namespace FOS\MessageBundle\Twig\Extension;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ReadableInterface;
use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\Provider\ProviderInterface;
use FOS\MessageBundle\Security\AuthorizerInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MessageExtension extends AbstractExtension
{
    protected ParticipantProviderInterface $participantProvider;

    protected ProviderInterface $provider;

    protected AuthorizerInterface $authorizer;

    protected ?int $nbUnreadMessagesCache = null;

    public function __construct(ParticipantProviderInterface $participantProvider, ProviderInterface $provider, AuthorizerInterface $authorizer)
    {
        $this->participantProvider = $participantProvider;
        $this->provider = $provider;
        $this->authorizer = $authorizer;
    }

    public function getFunctions(): array
    {
        return array(
            new TwigFunction('fos_message_is_read', array($this, 'isRead')),
            new TwigFunction('fos_message_nb_unread', array($this, 'getNbUnread')),
            new TwigFunction('fos_message_can_delete_thread', array($this, 'canDeleteThread')),
            new TwigFunction('fos_message_deleted_by_participant', array($this, 'isThreadDeletedByParticipant')),
        );
    }

    /**
     * Tells if this readable (thread or message) is read by the current user.
     *
     * @return bool
     */
    public function isRead(ReadableInterface $readable): bool
    {
        return $readable->isReadByParticipant($this->getAuthenticatedParticipant());
    }

    /**
     * Checks if the participant can mark a thread as deleted.
     *
     * @param ThreadInterface $thread
     *
     * @return bool true if participant can mark a thread as deleted, false otherwise
     */
    public function canDeleteThread(ThreadInterface $thread): bool
    {
        return $this->authorizer->canDeleteThread($thread);
    }

    /**
     * Checks if the participant has marked the thread as deleted.
     *
     * @param ThreadInterface $thread
     *
     * @return bool true if participant has marked the thread as deleted, false otherwise
     */
    public function isThreadDeletedByParticipant(ThreadInterface $thread): bool
    {
        return $thread->isDeletedByParticipant($this->getAuthenticatedParticipant());
    }

    /**
     * Gets the number of unread messages for the current user.
     *
     * @return int
     */
    public function getNbUnread(): int
    {
        if (null === $this->nbUnreadMessagesCache) {
            $this->nbUnreadMessagesCache = $this->provider->getNbUnreadMessages();
        }

        return $this->nbUnreadMessagesCache;
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

    public function getName(): string
    {
        return 'fos_message';
    }
}
