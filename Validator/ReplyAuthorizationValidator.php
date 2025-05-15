<?php

namespace FOS\MessageBundle\Validator;

use FOS\MessageBundle\Security\AuthorizerInterface;
use FOS\MessageBundle\Security\ParticipantProviderInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ReplyAuthorizationValidator extends ConstraintValidator
{
    protected AuthorizerInterface $authorizer;

    protected ParticipantProviderInterface $participantProvider;

    public function __construct(AuthorizerInterface $authorizer, ParticipantProviderInterface $participantProvider)
    {
        $this->authorizer = $authorizer;
        $this->participantProvider = $participantProvider;
    }

    /**
     * Indicates whether the constraint is valid.
     *
     * @param object     $value
     * @param Constraint $constraint
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        $sender = $this->participantProvider->getAuthenticatedParticipant();
        $recipients = $value->getThread()->getOtherParticipants($sender);

        foreach ($recipients as $recipient) {
            if (!$this->authorizer->canMessageParticipant($recipient)) {
                $this->context->addViolation($constraint->message);

                return;
            }
        }
    }
}
