<?php

namespace FOS\MessageBundle\Search;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\ModelManager\ThreadManagerInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;

/**
 * Finds threads of a participant, matching a given query.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class Finder implements FinderInterface
{
    protected ParticipantProviderInterface $participantProvider;

    protected ThreadManagerInterface $threadManager;

    public function __construct(ParticipantProviderInterface $participantProvider, ThreadManagerInterface $threadManager)
    {
        $this->participantProvider = $participantProvider;
        $this->threadManager = $threadManager;
    }

    public function find(Query $query): array
    {
        return $this->threadManager->findParticipantThreadsBySearch($this->getAuthenticatedParticipant(), $query->getEscaped());
    }

    public function getQueryBuilder(Query $query)
    {
        return $this->threadManager->getParticipantThreadsBySearchQueryBuilder($this->getAuthenticatedParticipant(), $query->getEscaped());
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
