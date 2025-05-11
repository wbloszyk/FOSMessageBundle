<?php

namespace FOS\MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use FOS\MessageBundle\Model\Message as BaseMessage;
use FOS\MessageBundle\Model\MessageMetadata as ModelMessageMetadata;

#[ORM\MappedSuperclass]
#[ORM\Table(name: 'fos_message_message')]
abstract class Message extends BaseMessage
{

    #[ORM\Column(name: 'body', type: 'text')]
    protected $body;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    protected $createdAt;

    /**
     * Get the collection of MessageMetadata.
     *
     * @return Collection
     */
    public function getAllMetadata()
    {
        return $this->metadata;
    }

    /**
     * {@inheritdoc}
     */
    public function addMetadata(ModelMessageMetadata $meta)
    {
        $meta->setMessage($this);
        parent::addMetadata($meta);
    }
}
