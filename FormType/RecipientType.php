<?php

namespace FOS\MessageBundle\FormType;

use FOS\MessageBundle\DataTransformer\RecipientDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of RecipientsType.
 *
 * @author Łukasz Pospiech <zocimek@gmail.com>
 */
class RecipientType extends AbstractType
{
    private RecipientDataTransformer $recipientsTransformer;

    public function __construct(RecipientDataTransformer $transformer)
    {
        $this->recipientsTransformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer($this->recipientsTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'invalid_message' => 'The selected recipient does not exist',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'recipient_selector';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): ?string
    {
        return TextType::class;
    }
}
