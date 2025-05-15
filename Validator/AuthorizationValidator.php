<?php

namespace FOS\MessageBundle\Validator;

use FOS\MessageBundle\Security\AuthorizerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AuthorizationValidator extends ConstraintValidator
{
    protected AuthorizerInterface$authorizer;

    public function __construct(AuthorizerInterface $authorizer)
    {
        $this->authorizer = $authorizer;
    }

    /**
     * Indicates whether the constraint is valid.
     *
     * @param object     $recipient
     * @param Constraint $constraint
     */
    public function validate(mixed $recipient, Constraint $constraint): void
    {
        if ($recipient && !$this->authorizer->canMessageParticipant($recipient)) {
            $this->context->addViolation($constraint->message);
        }
    }
}
