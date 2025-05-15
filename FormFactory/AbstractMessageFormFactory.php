<?php

namespace FOS\MessageBundle\FormFactory;

use FOS\MessageBundle\FormModel\AbstractMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Instanciates message forms.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
abstract class AbstractMessageFormFactory
{
    /**
     * The Symfony form factory.
     */
    protected FormFactoryInterface $formFactory;

    /**
     * The message form type.
     *
     * @var AbstractType|string
     */
    protected $formType;

    /**
     * The name of the form.
     */
    protected string $formName;

    /**
     * The FQCN of the message model.
     */
    protected string $messageClass;

    public function __construct(FormFactoryInterface $formFactory, $formType, string $formName, string $messageClass)
    {
        if (!is_string($formType) && !$formType instanceof AbstractType) {
            throw new \InvalidArgumentException(sprintf(
                'Form type provided is not valid (class name or instance of %s expected, %s given)',
                'Symfony\Component\Form\AbstractType',
                is_object($formType) ? get_class($formType) : gettype($formType)
            ));
        }

        $this->formFactory = $formFactory;
        $this->formType = $formType;
        $this->formName = $formName;
        $this->messageClass = $messageClass;
    }

    /**
     * Creates a new instance of the form model.
     */
    protected function createModelInstance(): AbstractMessage
    {
        $class = $this->messageClass;

        return new $class();
    }
}
