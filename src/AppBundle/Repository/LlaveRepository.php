<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Dependencia;
use AppBundle\Entity\Llave;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class LlaveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Llave::class);
    }

    public function findAllOrdenadasPorCodigo()
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.codigo')
            ->getQuery()
            ->getResult();
    }

    public function findPrestadasOrdenadasPorCodigo()
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.codigo')
            ->where('l.usuario IS NOT NULL')
            ->getQuery()
            ->getResult();
    }

    public function findNoPrestadasOrdenadasPorCodigo()
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.codigo')
            ->where('l.usuario IS NULL')
            ->getQuery()
            ->getResult();
    }

    public function findByDependencia(Dependencia $dependencia)
    {
        return $this->createQueryBuilder('l')
            ->select('l')
            ->where('l.dependencia = :dependencia')
            ->setParameter('dependencia', $dependencia)
            ->orderBy('l.descripcion')
            ->getQuery()
            ->getResult();
    }
}
