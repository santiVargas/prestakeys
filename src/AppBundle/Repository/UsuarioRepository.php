<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    public function findAllOrdenadosPorApellidos()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.apellidos')
            ->addOrderBy('u.nombre')
            ->getQuery()
            ->getResult();
    }

}
