<?php

namespace FOS\MessageBundle\ModelManager;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\ThreadInterface;

/**
 * Interface to be implemented by comment thread managers. This adds an additional level
 * of abstraction between your application, and the actual repository.
 *
 * All changes to comment threads should happen through this interface.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
interface ThreadManagerInterface extends ReadableManagerInterface
{
    /**
     * Finds a thread by its ID.
     */
    public function findThreadById($id): ?ThreadInterface;

    /**
     * Finds not deleted threads for a participant,
     * containing at least one message not written by this participant,
     * ordered by last message not written by this participant in reverse order.
     * In one word: an inbox.
     *
     * @param ParticipantInterface $participant
     *
     * @return Builder a query builder suitable for pagination
     */
    public function getParticipantInboxThreadsQueryBuilder(ParticipantInterface $participant);

    /**
     * Finds not deleted threads for a participant,
     * containing at least one message not written by this participant,
     * ordered by last message not written by this participant in reverse order.
     * In one word: an inbox.
     *
     * @return ThreadInterface[]
     */
    public function findParticipantInboxThreads(ParticipantInterface $participant): array;

    /**
     * Finds not deleted threads from a participant,
     * containing at least one message written by this participant,
     * ordered by last message written by this participant in reverse order.
     * In one word: an sentbox.
     *
     * @param ParticipantInterface $participant
     *
     * @return Builder a query builder suitable for pagination
     */
    public function getParticipantSentThreadsQueryBuilder(ParticipantInterface $participant);

    /**
     * Finds not deleted threads from a participant,
     * containing at least one message written by this participant,
     * ordered by last message written by this participant in reverse order.
     * In one word: an sentbox.
     *
     * @return ThreadInterface[]
     */
    public function findParticipantSentThreads(ParticipantInterface $participant): array;

    /**
     * Finds deleted threads from a participant,
     * ordered by last message date.
     *
     * @return Builder a query builder suitable for pagination
     */
    public function getParticipantDeletedThreadsQueryBuilder(ParticipantInterface $participant);

    /**
     * Finds deleted threads from a participant,
     * ordered by last message date.
     *
     * @param ParticipantInterface $participant
     *
     * @return ThreadInterface[]
     */
    public function findParticipantDeletedThreads(ParticipantInterface $participant): array;

    /**
     * Finds not deleted threads for a participant,
     * matching the given search term
     * ordered by last message not written by this participant in reverse order.
     *
     * @param ParticipantInterface $participant
     * @param string               $search
     *
     * @return Builder a query builder suitable for pagination
     */
    public function getParticipantThreadsBySearchQueryBuilder(ParticipantInterface $participant, string $search);

    /**
     * Finds not deleted threads for a participant,
     * matching the given search term
     * ordered by last message not written by this participant in reverse order.
     *
     * @return ThreadInterface[]
     */
    public function findParticipantThreadsBySearch(ParticipantInterface $participant, string $search): array;

    /**
     * Gets threads created by a participant.
     *
     * @return ThreadInterface[]
     */
    public function findThreadsCreatedBy(ParticipantInterface $participant): array;

    /**
     * Creates an empty comment thread instance.
     *
     * @return ThreadInterface
     */
    public function createThread(): ThreadInterface;

    /**
     * Saves a thread.
     *
     * @param ThreadInterface $thread
     * @param bool            $andFlush Whether to flush the changes (default true)
     */
    public function saveThread(ThreadInterface $thread, bool $andFlush = true): void;

    /**
     * Deletes a thread
     * This is not participant deletion but real deletion.
     *
     * @param ThreadInterface $thread the thread to delete
     */
    public function deleteThread(ThreadInterface $thread): void;
}
