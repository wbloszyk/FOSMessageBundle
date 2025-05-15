<?php

namespace FOS\MessageBundle\FormHandler;

use FOS\MessageBundle\Composer\ComposerInterface;
use FOS\MessageBundle\FormModel\AbstractMessage;
use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;
use FOS\MessageBundle\Sender\SenderInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Handles messages forms, from binding request to sending the message.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
abstract class AbstractMessageFormHandler
{
    protected RequestStack $request;
    protected ComposerInterface $composer;
    protected SenderInterface $sender;
    protected ParticipantProviderInterface $participantProvider;

    public function __construct(RequestStack $request, ComposerInterface $composer, SenderInterface $sender, ParticipantProviderInterface $participantProvider)
    {
        $this->request = $request;
        $this->composer = $composer;
        $this->sender = $sender;
        $this->participantProvider = $participantProvider;
    }

    /**
     * Processes the form with the request.
     *
     * @param Form $form
     *
     * @return MessageInterface|false the sent message if the form is bound and valid, false otherwise
     */
    public function process(Form $form)
    {
        $request = $this->getCurrentRequest();

        if ('POST' !== $request->getMethod()) {
            return false;
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            return $this->processValidForm($form);
        }

        return false;
    }

    /**
     * Processes the valid form, sends the message.
     *
     * @param Form $form
     *
     * @return MessageInterface the sent message
     */
    public function processValidForm(Form $form): MessageInterface
    {
        $message = $this->composeMessage($form->getData());
        $this->sender->send($message);

        return $message;
    }

    /**
     * Composes a message from the form data.
     *
     * @param AbstractMessage $message
     *
     * @return MessageInterface the composed message ready to be sent
     */
    abstract protected function composeMessage(AbstractMessage $message): MessageInterface;

    /**
     * Gets the current authenticated user.
     *
     * @return ParticipantInterface
     */
    protected function getAuthenticatedParticipant()
    {
        return $this->participantProvider->getAuthenticatedParticipant();
    }

    /**
     * BC layer to retrieve the current request directly or from a stack.
     */
    private function getCurrentRequest(): Request
    {
        if (!$this->request->getCurrentRequest()) {
            throw new \RuntimeException('Request stack provided to the form handler did not contains a current request.');
        }

        return $this->request->getCurrentRequest();
    }
}
