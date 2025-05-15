<?php

namespace FOS\MessageBundle\Validator;

use Symfony\Component\Validator\Constraint;

class Spam extends Constraint
{
    public string $message = 'fos_user.body.spam';

    public function validatedBy(): string
    {
        return 'fos_message.validator.spam';
    }

    /**
     * {@inheritdoc}
     */
    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}
