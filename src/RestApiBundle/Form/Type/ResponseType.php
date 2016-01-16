<?php
namespace RestApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'constraints' => array(
                new NotBlank()
            ),
        ));
        $builder->add('url', 'text', array(
            'constraints' => array(
                new NotBlank()
            ),
        ));
        $builder->add('value', 'text', array(
            'constraints' => array(
                new NotBlank()
            ),
        ));
        $builder->add('name', 'text', array(
            'constraints' => array(
                new NotBlank()
            ),
        ));
        $builder->add('method', ChoiceType::class, array(
            'choices' => array(
                'GET' => 'GET',
                'POST' => 'POST',
                'PUT' => 'PUT',
                'DELETE' => 'DELETE'
            ),
            'constraints' => array(
                new NotBlank()
            ),
        ));
        $builder->add('statusCode', 'integer', array(
            'constraints' => array(
                new NotBlank()
            ),
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('csrf_protection', false);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return '';
    }
}
