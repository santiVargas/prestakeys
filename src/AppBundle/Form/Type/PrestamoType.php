<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Llave;
use AppBundle\Entity\Usuario;
use AppBundle\Form\Model\Prestamo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestamoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('llave', EntityType::class, [
                'label' => 'Llave a prestar',
                'class' => Llave::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->where('l.usuario IS NULL')
                        ->orderBy('l.codigo');
                },
                'choice_label' => function (Llave $llave) {
                    return $llave->getCodigo() . ' - ' . $llave->getDependencia() . ' - ' . $llave->getDescripcion();
                },
                'required' => true
            ])
            ->add('usuario', EntityType::class, [
                'label' => 'Usuario al que se presta',
                'class' => Usuario::class,
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prestamo::class,
        ]);
    }

}
