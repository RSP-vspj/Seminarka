<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Revize
 *
 * @ORM\Table(name="revize")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RevizeRepository")
 */
class Revize
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="clanek_id", type="integer")
     */
    private $clanekID;

    /**
     * @var string
     *
     * @ORM\Column(name="jmeno_clanku", type="string", length=255)
     */
    private $jmenoClanku;

    /**
     * @var string
     *
     * @ORM\Column(name="cesta_k_souboru", type="string", length=255)
     */
    private $cestaKSouboru;

    /**
     * @var string
     *
     * @ORM\Column(name="komentar_autoru", type="string", length=255, nullable=true)
     */
    private $komentarAutoru;

    /**
     * @var string
     *
     * @ORM\Column(name="komentar_redaktora", type="string", length=255, nullable=true)
     */
    private $komentarRedaktora;

    /**
     * @var string
     *
     * @ORM\Column(name="sdeleni_admin", type="string", length=255, nullable=true)
     */
    private $sdeleniAdmin;

    /**
     * @var string
     *
     * @ORM\Column(name="ostatni_sdeleni", type="string", length=255, nullable=true)
     */
    private $ostatniSdeleni;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datum_pridani_clanku", type="date")
     */
    private $datumPridaniClanku;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="uzaverka_recenzniho_rizeni", type="date", nullable=true)
     */
    private $uzaverkaRecenznihoRizeni;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $clanekID
     */
    public function setClanekID($clanekID)
    {
        $this->clanekID = $clanekID;
    }


    public function getClanekID()
    {
        return $this->clanekID;
    }

    /**
     * Set cestaKSouboru
     *
     * @param string $cestaKSouboru
     *
     * @return Revize
     */
    public function setCestaKSouboru($cestaKSouboru)
    {
        $this->cestaKSouboru = $cestaKSouboru;

        return $this;
    }

    /**
     * Get cestaKSouboru
     *
     * @return string
     */
    public function getCestaKSouboru()
    {
        return $this->cestaKSouboru;
    }

    /**
     * Set komentarAutoru
     *
     * @param string $komentarAutoru
     *
     * @return Revize
     */
    public function setKomentarAutoru($komentarAutoru)
    {
        $this->komentarAutoru = $komentarAutoru;

        return $this;
    }

    /**
     * Get komentarAutoru
     *
     * @return string
     */
    public function getKomentarAutoru()
    {
        return $this->komentarAutoru;
    }

    /**
     * Set komentarRedaktora
     *
     * @param string $komentarRedaktora
     *
     * @return Revize
     */
    public function setKomentarRedaktora($komentarRedaktora)
    {
        $this->komentarRedaktora = $komentarRedaktora;

        return $this;
    }

    /**
     * Get komentarRedaktora
     *
     * @return string
     */
    public function getKomentarRedaktora()
    {
        return $this->komentarRedaktora;
    }

    /**
     * Set sdeleniAdmin
     *
     * @param string $sdeleniAdmin
     *
     * @return Revize
     */
    public function setSdeleniAdmin($sdeleniAdmin)
    {
        $this->sdeleniAdmin = $sdeleniAdmin;

        return $this;
    }

    /**
     * Get sdeleniAdmin
     *
     * @return string
     */
    public function getSdeleniAdmin()
    {
        return $this->sdeleniAdmin;
    }

    /**
     * Set ostatniSdeleni
     *
     * @param string $ostatniSdeleni
     *
     * @return Revize
     */
    public function setOstatniSdeleni($ostatniSdeleni)
    {
        $this->ostatniSdeleni = $ostatniSdeleni;

        return $this;
    }

    /**
     * Get ostatniSdeleni
     *
     * @return string
     */
    public function getOstatniSdeleni()
    {
        return $this->ostatniSdeleni;
    }

    /**
     * Set datumPridaniClanku
     *
     * @param \DateTime $datumPridaniClanku
     *
     * @return Revize
     */
    public function setDatumPridaniClanku($datumPridaniClanku)
    {
        $this->datumPridaniClanku = $datumPridaniClanku;

        return $this;
    }

    /**
     * Get datumPridaniClanku
     *
     * @return \DateTime
     */
    public function getDatumPridaniClanku()
    {
        return $this->datumPridaniClanku;
    }

    /**
     * Set uzaverkaRecenznihoRizeni
     *
     * @param \DateTime $uzaverkaRecenznihoRizeni
     *
     * @return Revize
     */
    public function setUzaverkaRecenznihoRizeni($uzaverkaRecenznihoRizeni)
    {
        $this->uzaverkaRecenznihoRizeni = $uzaverkaRecenznihoRizeni;

        return $this;
    }

    /**
     * Get uzaverkaRecenznihoRizeni
     *
     * @return \DateTime
     */
    public function getUzaverkaRecenznihoRizeni()
    {
        return $this->uzaverkaRecenznihoRizeni;
    }

    public function __toString()
    {
        return (string)$this->id;
    }

    /**
     * @return string
     */
    public function getJmenoClanku()
    {
        return $this->jmenoClanku;
    }

    /**
     * @param string $jmenoClanku
     */
    public function setJmenoClanku($jmenoClanku)
    {
        $this->jmenoClanku = $jmenoClanku;
    }
}