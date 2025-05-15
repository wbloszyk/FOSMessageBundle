<?php

namespace FOS\MessageBundle\Composer;

use FOS\MessageBundle\MessageBuilder\AbstractMessageBuilder;
use FOS\MessageBundle\Model\ThreadInterface;

/**
 * Factory for message builders.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
interface ComposerInterface
{
    /**
     * Starts composing a message, starting a new thread.
     */
    public function newThread(): AbstractMessageBuilder;

    /**
     * Starts composing a message in a reply to a thread.
     */
    public function reply(ThreadInterface $thread): AbstractMessageBuilder;
}
