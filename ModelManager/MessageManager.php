<?php

namespace FOS\MessageBundle\ModelManager;

use FOS\MessageBundle\Model\MessageInterface;

/**
 * Abstract Message Manager implementation which can be used as base by
 * your concrete manager.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
abstract class MessageManager implements MessageManagerInterface
{
    /**
     * Creates an empty message instance.
     */
    public function createMessage(): MessageInterface
    {
        $class = $this->getClass();

        return new $class();
    }
}
