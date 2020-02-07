<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\Model\CambioClave;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CambioClaveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('claveAntigua', PasswordType::class, [
                'label' => 'Clave actual'
            ])
            ->add('nuevaClave', PasswordType::class, [
                'label' => 'Nueva clave'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CambioClave::class
        ]);
    }

}