<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Dependencia;
use AppBundle\Entity\Llave;
use AppBundle\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LlaveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo', TextType::class, [
                'label' => 'Código de barras'
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción'
            ])
            ->add('dependencia', EntityType::class, [
                'class' => Dependencia::class,
                'label' => 'Pertenece a'
            ]);

        if ($options['nuevo'] === false) {
            $builder
                ->add('usuario', EntityType::class, [
                    'class' => Usuario::class,
                    'label' => 'Prestada a',
                    'required' => false,
                    'placeholder' => 'Nadie'
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Llave::class,
            'nuevo' => false
        ]);
    }

}
