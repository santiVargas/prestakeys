<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     * @var string
     */
    private $apellidos;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $ordenanza;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $secretario;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=5)
     * @var string
     */
    private $nombreUsuario;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $clave;

    /**
     * @ORM\OneToMany(targetEntity="Llave", mappedBy="usuario")
     * @var Llave[]
     */
    private $llavesPrestadas;

    /**
     * Usuario constructor.
     */
    public function __construct()
    {
        $this->llavesPrestadas = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNombre() . ' ' . $this->getApellidos();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     * @return Usuario
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOrdenanza()
    {
        return $this->ordenanza;
    }

    /**
     * @param bool $ordenanza
     * @return Usuario
     */
    public function setOrdenanza($ordenanza)
    {
        $this->ordenanza = $ordenanza;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSecretario()
    {
        return $this->secretario;
    }

    /**
     * @param bool $secretario
     * @return Usuario
     */
    public function setSecretario($secretario)
    {
        $this->secretario = $secretario;
        return $this;
    }

    /**
     * @return Llave[]
     */
    public function getLlavesPrestadas()
    {
        return $this->llavesPrestadas;
    }

    /**
     * @param Llave[] $llavesPrestadas
     * @return Usuario
     */
    public function setLlavesPrestadas($llavesPrestadas)
    {
        $this->llavesPrestadas = $llavesPrestadas;
        return $this;
    }

    /**
     * @return string
     */
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    /**
     * @param string $nombreUsuario
     * @return Usuario
     */
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
        return $this;
    }

    /**
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param string $clave
     * @return Usuario
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        // inicialmente es solo un usuario normal
        $roles = ['ROLE_USER'];

        if ($this->isOrdenanza()) {
            $roles[] = 'ROLE_ORDENANZA';
        } else {
            $roles[] = 'ROLE_DOCENTE';
        }

        if ($this->isSecretario()) {
            $roles[] = 'ROLE_SECRETARIO';
        }

        return $roles;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->getClave();
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->getNombreUsuario();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // no hacer nada
    }
}
