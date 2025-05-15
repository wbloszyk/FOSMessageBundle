<?php

namespace FOS\MessageBundle\Tests\Functional\EntityManager;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ReadableInterface;
use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\ModelManager\ThreadManager as BaseThreadManager;
use FOS\MessageBundle\Tests\Functional\Entity\Thread;

class ThreadManager extends BaseThreadManager
{
    public function findThreadById($id): ?ThreadInterface
    {
        return new Thread();
    }

    public function getParticipantInboxThreadsQueryBuilder(ParticipantInterface $participant)
    {
    }

    public function findParticipantInboxThreads(ParticipantInterface $participant): array
    {
        return array(new Thread());
    }

    public function getParticipantSentThreadsQueryBuilder(ParticipantInterface $participant)
    {
    }

    public function findParticipantSentThreads(ParticipantInterface $participant): array
    {
        return array();
    }

    public function getParticipantDeletedThreadsQueryBuilder(ParticipantInterface $participant)
    {
    }

    public function findParticipantDeletedThreads(ParticipantInterface $participant): array
    {
        return array();
    }

    public function getParticipantThreadsBySearchQueryBuilder(ParticipantInterface $participant, $search)
    {
    }

    public function findParticipantThreadsBySearch(ParticipantInterface $participant, $search): array
    {
        return array();
    }

    public function findThreadsCreatedBy(ParticipantInterface $participant): array
    {
        return array();
    }

    public function markAsReadByParticipant(ReadableInterface $readable, ParticipantInterface $participant): void
    {
    }

    public function markAsUnreadByParticipant(ReadableInterface $readable, ParticipantInterface $participant): void
    {
    }

    public function saveThread(ThreadInterface $thread, $andFlush = true): void
    {
    }

    public function deleteThread(ThreadInterface $thread): void
    {
    }

    public function getClass(): string
    {
        return Thread::class;
    }
}
