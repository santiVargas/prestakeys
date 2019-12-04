<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Dependencia;
use AppBundle\Entity\Llave;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DependenciaFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $dependencia = new Dependencia();
        $dependencia
            ->setDescripcion('1ºDAM');

        $manager->persist($dependencia);

        $llave = new Llave();
        $llave
            ->setDependencia($dependencia)
            ->setDescripcion('Puerta principal')
            ->setCodigo('12345');

        $manager->persist($llave);
        $manager->flush();
    }
}