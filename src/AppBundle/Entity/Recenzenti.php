<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recenzenti
 *
 * @ORM\Table(name="recenzenti")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecenzentiRepository")
 */
class Recenzenti
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
     * @var bool
     *
     * @ORM\Column(name="pozadavek_na_recenzi_zobrazen", type="boolean")
     */
    private $pozadavekNaRecenziZobrazen;

    /**
     * @var bool
     *
     * @ORM\Column(name="pozadavek_na_recenzi_prijat", type="boolean")
     */
    private $pozadavekNaRecenziPrijat;

    /**
     * @var bool
     *
     * @ORM\Column(name="pozadavek_na_recenzi_odmitnut", type="boolean")
     */
    private $pozadavekNaRecenziOdmitnut;

    /**
     * @var bool
     *
     * @ORM\Column(name="recenze_je_dokoncena", type="boolean")
     */
    private $recenzeJeDokoncena;

    /**
     * @var string
     *
     * @ORM\Column(name="hodnoceni_clanku_slovni", type="string", length=255, nullable=true)
     */
    private $hodnoceniClankuSlovni;

    /**
     * @var int
     *
     * @ORM\Column(name="hodnoceni_clanku_prinos", type="integer", nullable=true)
     */
    private $hodnoceniClankuPrinos;

    /**
     * @var int
     *
     * @ORM\Column(name="hodnoceni_clanku_originalita", type="integer", nullable=true)
     */
    private $hodnoceniClankuOriginalita;

    /**
     * @var int
     *
     * @ORM\Column(name="hodnoceni_clanku_odbornost", type="integer", nullable=true)
     */
    private $hodnoceniClankuOdbornost;

    /**
     * @var int
     *
     * @ORM\Column(name="hodnoceni_clanku_jazyk", type="integer", nullable=true)
     */
    private $hodnoceniClankuJazyk;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datum_odevzdani_recenze", type="date", nullable=true)
     */
    private $datumOdevzdaniRecenze;


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
     * Set uzivatelID
     *
     * @param integer $uzivatelID
     *
     * @return Recenzenti
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
     * @return Recenzenti
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
     * @return Recenzenti
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
     * Set pozadavekNaRecenziZobrazen
     *
     * @param boolean $pozadavekNaRecenziZobrazen
     *
     * @return Recenzenti
     */
    public function setPozadavekNaRecenziZobrazen($pozadavekNaRecenziZobrazen)
    {
        $this->pozadavekNaRecenziZobrazen = $pozadavekNaRecenziZobrazen;

        return $this;
    }

    /**
     * Get pozadavekNaRecenziZobrazen
     *
     * @return bool
     */
    public function getPozadavekNaRecenziZobrazen()
    {
        return $this->pozadavekNaRecenziZobrazen;
    }

    /**
     * Set pozadavekNaRecenziPrijat
     *
     * @param boolean $pozadavekNaRecenziPrijat
     *
     * @return Recenzenti
     */
    public function setPozadavekNaRecenziPrijat($pozadavekNaRecenziPrijat)
    {
        $this->pozadavekNaRecenziPrijat = $pozadavekNaRecenziPrijat;

        return $this;
    }

    /**
     * Get pozadavekNaRecenziPrijat
     *
     * @return bool
     */
    public function getPozadavekNaRecenziPrijat()
    {
        return $this->pozadavekNaRecenziPrijat;
    }

    /**
     * Set pozadavekNaRecenziOdmitnut
     *
     * @param boolean $pozadavekNaRecenziOdmitnut
     *
     * @return Recenzenti
     */
    public function setPozadavekNaRecenziOdmitnut($pozadavekNaRecenziOdmitnut)
    {
        $this->pozadavekNaRecenziOdmitnut = $pozadavekNaRecenziOdmitnut;

        return $this;
    }

    /**
     * Get pozadavekNaRecenziOdmitnut
     *
     * @return bool
     */
    public function getPozadavekNaRecenziOdmitnut()
    {
        return $this->pozadavekNaRecenziOdmitnut;
    }

    /**
     * Set recenzeJeDokoncena
     *
     * @param boolean $recenzeJeDokoncena
     *
     * @return Recenzenti
     */
    public function setRecenzeJeDokoncena($recenzeJeDokoncena)
    {
        $this->recenzeJeDokoncena = $recenzeJeDokoncena;

        return $this;
    }

    /**
     * Get recenzeJeDokoncena
     *
     * @return bool
     */
    public function getRecenzeJeDokoncena()
    {
        return $this->recenzeJeDokoncena;
    }

    /**
     * Set hodnoceniClankuSlovni
     *
     * @param string $hodnoceniClankuSlovni
     *
     * @return Recenzenti
     */
    public function setHodnoceniClankuSlovni($hodnoceniClankuSlovni)
    {
        $this->hodnoceniClankuSlovni = $hodnoceniClankuSlovni;

        return $this;
    }

    /**
     * Get hodnoceniClankuSlovni
     *
     * @return string
     */
    public function getHodnoceniClankuSlovni()
    {
        return $this->hodnoceniClankuSlovni;
    }

    /**
     * Set hodnoceniClankuPrinos
     *
     * @param integer $hodnoceniClankuPrinos
     *
     * @return Recenzenti
     */
    public function setHodnoceniClankuPrinos($hodnoceniClankuPrinos)
    {
        $this->hodnoceniClankuPrinos = $hodnoceniClankuPrinos;

        return $this;
    }

    /**
     * Get hodnoceniClankuPrinos
     *
     * @return int
     */
    public function getHodnoceniClankuPrinos()
    {
        return $this->hodnoceniClankuPrinos;
    }

    /**
     * Set hodnoceniClankuOriginalita
     *
     * @param integer $hodnoceniClankuOriginalita
     *
     * @return Recenzenti
     */
    public function setHodnoceniClankuOriginalita($hodnoceniClankuOriginalita)
    {
        $this->hodnoceniClankuOriginalita = $hodnoceniClankuOriginalita;

        return $this;
    }

    /**
     * Get hodnoceniClankuOriginalita
     *
     * @return int
     */
    public function getHodnoceniClankuOriginalita()
    {
        return $this->hodnoceniClankuOriginalita;
    }

    /**
     * Set hodnoceniClankuOdbornost
     *
     * @param integer $hodnoceniClankuOdbornost
     *
     * @return Recenzenti
     */
    public function setHodnoceniClankuOdbornost($hodnoceniClankuOdbornost)
    {
        $this->hodnoceniClankuOdbornost = $hodnoceniClankuOdbornost;

        return $this;
    }

    /**
     * Get hodnoceniClankuOdbornost
     *
     * @return int
     */
    public function getHodnoceniClankuOdbornost()
    {
        return $this->hodnoceniClankuOdbornost;
    }

    /**
     * Set hodnoceniClankuJazyk
     *
     * @param integer $hodnoceniClankuJazyk
     *
     * @return Recenzenti
     */
    public function setHodnoceniClankuJazyk($hodnoceniClankuJazyk)
    {
        $this->hodnoceniClankuJazyk = $hodnoceniClankuJazyk;

        return $this;
    }

    /**
     * Get hodnoceniClankuJazyk
     *
     * @return int
     */
    public function getHodnoceniClankuJazyk()
    {
        return $this->hodnoceniClankuJazyk;
    }

    /**
     * Set datumOdevzdaniRecenze
     *
     * @param \DateTime $datumOdevzdaniRecenze
     *
     * @return Recenzenti
     */
    public function setDatumOdevzdaniRecenze($datumOdevzdaniRecenze)
    {
        $this->datumOdevzdaniRecenze = $datumOdevzdaniRecenze;

        return $this;
    }

    /**
     * Get datumOdevzdaniRecenze
     *
     * @return \DateTime
     */
    public function getDatumOdevzdaniRecenze()
    {
        return $this->datumOdevzdaniRecenze;
    }

    public function __toInt()
    {
        return $this->uzivatelID;
    }
}

