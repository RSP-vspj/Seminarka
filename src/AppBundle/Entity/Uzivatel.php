<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Uzivatel
 *
 * @ORM\Table(name="uzivatel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UzivatelRepository")
 */
class Uzivatel implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Clanek", mappedBy="uzivatel")
     */
    private $clanky;

    public function __construct()
    {
        $this->clanky = new ArrayCollection();
    }

    /**
     * @var bool
     *
     * @ORM\Column(name="uzivatel_aktivni", type="boolean")
     */
    private $uzivatelAktivni;

    /**
     * @var string
     *
     * @ORM\Column(name="jmeno", type="string", length=255)
     */
    private $jmeno;

    /**
     * @var string
     *
     * @ORM\Column(name="prijmeni", type="string", length=255)
     */
    private $prijmeni;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=255, nullable=true, unique=true)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="heslo", type="string", length=255, nullable=true)
     */
    private $heslo;

    /**
     * @var string
     *
     * @ORM\Column(name="odbornost", type="string", length=255, nullable=true)
     */
    private $odbornost;

    /**
     * @var int
     *
     * @ORM\Column(name="role", type="integer")
     */
    private $role;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set jmeno
     *
     * @param string $jmeno
     *
     * @return Uzivatel
     */
    public function setJmeno($jmeno)
    {
        $this->jmeno = $jmeno;

        return $this;
    }

    /**
     * Get jmeno
     *
     * @return string
     */
    public function getJmeno()
    {
        return $this->jmeno;
    }

    /**
     * Set prijmeni
     *
     * @param string $prijmeni
     *
     * @return Uzivatel
     */
    public function setPrijmeni($prijmeni)
    {
        $this->prijmeni = $prijmeni;

        return $this;
    }

    /**
     * Get prijmeni
     *
     * @return string
     */
    public function getPrijmeni()
    {
        return $this->prijmeni;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return Uzivatel
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set heslo
     *
     * @param string $heslo
     *
     * @return Uzivatel
     */
    public function setHeslo($heslo)
    {
        $this->heslo = $heslo;

        return $this;
    }

    /**
     * Get heslo
     *
     * @return string
     */
    public function getHeslo()
    {
        return $this->heslo;
    }

    /**
     * Set odbornost
     *
     * @param string $odbornost
     *
     * @return Uzivatel
     */
    public function setOdbornost($odbornost)
    {
        $this->odbornost = $odbornost;

        return $this;
    }

    /**
     * Get odbornost
     *
     * @return string
     */
    public function getOdbornost()
    {
        return $this->odbornost;
    }

    /**
     * Set role
     *
     * @param integer $role
     *
     * @return Uzivatel
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return bool
     */
    public function isUzivatelAktivni()
    {
        return $this->uzivatelAktivni;
    }

    /**
     * @param bool $uzivatelAktivni
     */
    public function setUzivatelAktivni($uzivatelAktivni)
    {
        $this->uzivatelAktivni = $uzivatelAktivni;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        if ($this->role == 0)
            return ['ROLE_ADMIN'];
        if ($this->role == 1)
            return ['ROLE_UZIVATEL'];
        if ($this->role == 2)
            return ['ROLE_REDAKTOR'];
        if ($this->role == 3)
            return ['ROLE_RECENZENT'];
        if ($this->role == 4)
            return ['ROLE_SEFREDAKTOR'];
        if ($this->role == 5)
            return ['ROLE_NEREG_AUTOR'];
        else
            return ['ROLE_ANONYMOUS'];
    }

    public function eraseCredentials()
    {
    }

    public function getUsername()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->heslo;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->login,
            $this->heslo,
            // see section on salt below
            // $this->salt,
        ]);
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->login,
            $this->heslo,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function __toString()
    {
        return $this->login;
    }
}

