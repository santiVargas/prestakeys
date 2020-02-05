<?php

namespace AppBundle\Form\Model;

use AppBundle\Entity\Llave;
use AppBundle\Entity\Usuario;

class Prestamo
{
    /** @var Llave */
    private $llave;

    /** @var Usuario */
    private $usuario;

    /**
     * @return Llave
     */
    public function getLlave()
    {
        return $this->llave;
    }

    /**
     * @param Llave $llave
     * @return Prestamo
     */
    public function setLlave($llave)
    {
        $this->llave = $llave;
        return $this;
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario
     * @return Prestamo
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }
}