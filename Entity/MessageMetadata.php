<?php

namespace FOS\MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\MessageMetadata as BaseMessageMetadata;

#[ORM\MappedSuperclass]
#[ORM\Table(name: 'fos_message_metadata')]
abstract class MessageMetadata extends BaseMessageMetadata
{
    protected $id;

    #[ORM\Column(name: 'is_read', type: 'boolean')]
    protected $isRead = false;

    protected $message;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return MessageInterface
     */
    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage(MessageInterface $message)
    {
        $this->message = $message;
    }
}
