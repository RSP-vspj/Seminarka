<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Autori
 *
 * @ORM\Table(name="autori")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AutoriRepository")
 */
class Autori
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Uzivatel", inversedBy="id")
     */
    private $uzivatelID;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Revize", inversedBy="clanekID")
     */
    private $clanekID;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Revize", inversedBy="cisloRevize")
     */
    private $cisloRevize;

    /**
     * @var string
     *
     * @ORM\Column(name="pripominky_autora_k_revizi", type="string", length=255, nullable=true)
     */
    private $pripominkyAutoraKRevizi;

    /**
     * @var string
     *
     * @ORM\Column(name="vyjadreni_autora_k_vysledku_recenzniho_rizeni", type="string", length=255, nullable=true)
     */
    private $vyjadreniAutoraKVysledkuRecenznihoRizeni;

    /**
     * @var bool
     *
     * @ORM\Column(name="autor_prihlasen_od_pridani_nejnovejsi_recenze", type="boolean")
     */
    private $autorPrihlasenOdPridaniNejnovejsiRecenze;

    /**
     * @var bool
     *
     * @ORM\Column(name="autor_seznamen_s_vysledky_recenzniho_rizeni", type="boolean")
     */
    private $autorSeznamenSVysledkyRecenznihoRizeni;


    /**
     * Set uzivatelID
     *
     * @param integer $uzivatelID
     *
     * @return Autori
     */
    public function setUzivatelID($uzivatelID)
    {
        $this->uzivatelID = $uzivatelID;

        return $this;
    }

    /**
     * Get uzivatelID
     *
     * @return int
     */
    public function getUzivatelID()
    {
        return $this->uzivatelID;
    }

    /**
     * Set clanekID
     *
     * @param integer $clanekID
     *
     * @return Autori
     */
    public function setClanekID($clanekID)
    {
        $this->clanekID = $clanekID;

        return $this;
    }

    /**
     * Get clanekID
     *
     * @return int
     */
    public function getClanekID()
    {
        return $this->clanekID;
    }

    /**
     * Set cisloRevize
     *
     * @param integer $cisloRevize
     *
     * @return Autori
     */
    public function setCisloRevize($cisloRevize)
    {
        $this->cisloRevize = $cisloRevize;

        return $this;
    }

    /**
     * Get cisloRevize
     *
     * @return int
     */
    public function getCisloRevize()
    {
        return $this->cisloRevize;
    }

    /**
     * Set pripominkyAutoraKRevizi
     *
     * @param string $pripominkyAutoraKRevizi
     *
     * @return Autori
     */
    public function setPripominkyAutoraKRevizi($pripominkyAutoraKRevizi)
    {
        $this->pripominkyAutoraKRevizi = $pripominkyAutoraKRevizi;

        return $this;
    }

    /**
     * Get pripominkyAutoraKRevizi
     *
     * @return string
     */
    public function getPripominkyAutoraKRevizi()
    {
        return $this->pripominkyAutoraKRevizi;
    }

    /**
     * Set vyjadreniAutoraKVysledkuRecenznihoRizeni
     *
     * @param string $vyjadreniAutoraKVysledkuRecenznihoRizeni
     *
     * @return Autori
     */
    public function setVyjadreniAutoraKVysledkuRecenznihoRizeni($vyjadreniAutoraKVysledkuRecenznihoRizeni)
    {
        $this->vyjadreniAutoraKVysledkuRecenznihoRizeni = $vyjadreniAutoraKVysledkuRecenznihoRizeni;

        return $this;
    }

    /**
     * Get vyjadreniAutoraKVysledkuRecenznihoRizeni
     *
     * @return string
     */
    public function getVyjadreniAutoraKVysledkuRecenznihoRizeni()
    {
        return $this->vyjadreniAutoraKVysledkuRecenznihoRizeni;
    }

    /**
     * Set autorPrihlasenOdPridaniNejnovejsiRecenze
     *
     * @param boolean $autorPrihlasenOdPridaniNejnovejsiRecenze
     *
     * @return Autori
     */
    public function setAutorPrihlasenOdPridaniNejnovejsiRecenze($autorPrihlasenOdPridaniNejnovejsiRecenze)
    {
        $this->autorPrihlasenOdPridaniNejnovejsiRecenze = $autorPrihlasenOdPridaniNejnovejsiRecenze;

        return $this;
    }

    /**
     * Get autorPrihlasenOdPridaniNejnovejsiRecenze
     *
     * @return bool
     */
    public function getAutorPrihlasenOdPridaniNejnovejsiRecenze()
    {
        return $this->autorPrihlasenOdPridaniNejnovejsiRecenze;
    }

    /**
     * Set autorSeznamenSVysledkyRecenznihoRizeni
     *
     * @param boolean $autorSeznamenSVysledkyRecenznihoRizeni
     *
     * @return Autori
     */
    public function setAutorSeznamenSVysledkyRecenznihoRizeni($autorSeznamenSVysledkyRecenznihoRizeni)
    {
        $this->autorSeznamenSVysledkyRecenznihoRizeni = $autorSeznamenSVysledkyRecenznihoRizeni;

        return $this;
    }

    /**
     * Get autorSeznamenSVysledkyRecenznihoRizeni
     *
     * @return bool
     */
    public function getAutorSeznamenSVysledkyRecenznihoRizeni()
    {
        return $this->autorSeznamenSVysledkyRecenznihoRizeni;
    }

    public function __toInt()
    {
        return $this->uzivatelID;
    }
}