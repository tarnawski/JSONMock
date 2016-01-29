<?php
namespace RestApiBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
        $builder->add('name', 'text');
        $builder->add('url', 'text');
        $builder->add('value', 'text');
        $builder->add('method', ChoiceType::class, array(
            'choices' => array(
                'GET' => 'GET',
                'POST' => 'POST',
                'PUT' => 'PUT',
                'DELETE' => 'DELETE'
            )
        ));
        $builder->add('statusCode', 'integer');
        $builder->add('application', EntityType::class, array(
            'class' => 'JSONMockBundle:Application'
    ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('csrf_protection', false);
        $resolver->setDefault('data_class', 'JSONMockBundle\Entity\Response');
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return '';
    }
}
