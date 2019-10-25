<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="llave")
 */
class Llave
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $codigo;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaPrestamo;
}