<?php

namespace FOS\MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\Model\ThreadMetadata as BaseThreadMetadata;

#[ORM\MappedSuperclass]
#[ORM\Table(name: 'fos_message_thread_metadata')]
abstract class ThreadMetadata extends BaseThreadMetadata
{
    protected $id;

    #[ORM\Column(name: 'is_deleted', type: 'boolean')]
    protected $isDeleted = false;

    #[ORM\Column(name: 'last_participant_message_date', type: 'datetime', nullable: true)]
    protected $lastParticipantMessageDate;

    #[ORM\Column(name: 'last_message_date', type: 'datetime', nullable: true)]
    protected $lastMessageDate;

    protected $thread;

    /**
     * Gets the thread map id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ThreadInterface
     */
    public function getThread()
    {
        return $this->thread;
    }

    public function setThread(ThreadInterface $thread)
    {
        $this->thread = $thread;
    }
}
