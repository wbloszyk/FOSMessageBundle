<?php

namespace FOS\MessageBundle\Validator;

use FOS\MessageBundle\Security\ParticipantProviderInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class SelfRecipientValidator extends ConstraintValidator
{
    protected ParticipantProviderInterface $participantProvider;

    public function __construct(ParticipantProviderInterface $participantProvider)
    {
        $this->participantProvider = $participantProvider;
    }

    /**
     * Indicates whether the constraint is valid.
     *
     * @param object     $value
     * @param SelfRecipient $constraint
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if ($value === $this->participantProvider->getAuthenticatedParticipant()) {
            $this->context->addViolation($constraint->message);
        }
    }
}
