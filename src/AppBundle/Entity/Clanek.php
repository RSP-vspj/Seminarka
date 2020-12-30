<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Clanek
 *
 * @ORM\Table(name="clanek")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClanekRepository")
 */
class Clanek
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
     * @ORM\ManyToOne(targetEntity="Uzivatel", inversedBy="clanky")
     * @ORM\JoinColumn(name="uzivatel_id", referencedColumnName="id")
     */
    private $uzivatel;

    /**
     * @return mixed
     */
    public function getUzivatel()
    {
        return $this->uzivatel;
    }

    /**
     * @param mixed $uzivatel
     */
    public function setUzivatel($uzivatel)
    {
        $this->uzivatel = $uzivatel;
    }

    /**
     * @var bool
     *
     * @ORM\Column(name="aktivni_clanek", type="boolean")
     */
    private $aktivniClanek;

    /**
     * @var bool
     *
     * @ORM\Column(name="clanek_zobrazen_redakci", type="boolean")
     */
    private $clanekZobrazenRedakci;

    /**
     * @var bool
     *
     * @ORM\Column(name="ceka_na_stanoveni_recenzentu", type="boolean")
     */
    private $cekaNaStanoveniRecenzentu;

    /**
     * @var bool
     *
     * @ORM\Column(name="jsou_stanoveni_recenzenti", type="boolean")
     */
    private $jsouStanoveniRecenzenti;

    /**
     * @var bool
     *
     * @ORM\Column(name="probiha_recenzni_rizeni", type="boolean")
     */
    private $probihaRecenzniRizeni;

    /**
     * @var bool
     *
     * @ORM\Column(name="recenzni_rizeni_bylo_dokonceno", type="boolean")
     */
    private $recenzniRizeniByloDokonceno;

    /**
     * @var bool
     *
     * @ORM\Column(name="recenzni_rizeni_bylo_zruseno", type="boolean")
     */
    private $recenzniRizeniByloZruseno;

    /**
     * @var bool
     *
     * @ORM\Column(name="nove_podana_revize", type="boolean")
     */
    private $novePodanaRevize;

    /**
     * @var bool
     *
     * @ORM\Column(name="clanek_prijat", type="boolean")
     */
    private $clanekPrijat;

    /**
     * @var bool
     *
     * @ORM\Column(name="clanek_prijat_s_vyhradami", type="boolean")
     */
    private $clanekPrijatSVyhradami;

    /**
     * @var bool
     *
     * @ORM\Column(name="clanek_prijat_vyzaduje_formalni_doplneni", type="boolean")
     */
    private $clanekPrijatVyzadujeFormalniDoplneni;

    /**
     * @var bool
     *
     * @ORM\Column(name="clanek_zamitnut_neobstal_v_recenznim_rizeni", type="boolean")
     */
    private $clanekZamitnutNeobstalVRecenznimRizeni;

    /**
     * @var bool
     *
     * @ORM\Column(name="clanek_zamitnut_nesplnuje_sablonu", type="boolean")
     */
    private $clanekZamitnutNesplnujeSablonu;

    /**
     * @var bool
     *
     * @ORM\Column(name="clanek_zamitnut_tematicky_nevhodny", type="boolean")
     */
    private $clanekZamitnutTematickyNevhodny;

    /**
     * @var bool
     *
     * @ORM\Column(name="ceka_se_na_autorovu_revizi", type="boolean")
     */
    private $cekaSeNaAutorovuRevizi;

    /**
     * @var bool
     *
     * @ORM\Column(name="nutnost_predat_novou_revizi_zpet_recenzentum", type="boolean")
     */
    private $nutnostPredatNovouReviziZpetRecenzentum;

    /**
     * @var bool
     *
     * @ORM\Column(name="pozadavek_na_nahrazeni_revize_autorem", type="boolean")
     */
    private $pozadavekNaNahrazeniRevizeAutorem;

    /**
     * @var bool
     *
     * @ORM\Column(name="lze_podat_novou_revizi", type="boolean")
     */
    private $lzePodatNovouRevizi;

    /**
     * @var bool
     *
     * @ORM\Column(name="nejednoznacnost_recenzniho_rizeni", type="boolean")
     */
    private $nejednoznacnostRecenznihoRizeni;

    /**
     * @var bool
     *
     * @ORM\Column(name="clanek_vydan", type="boolean")
     */
    private $clanekVydan;

    /**
     * @var string
     *
     * @ORM\Column(name="cislo_casopisu", type="string", length=255, nullable=true)
     */
    private $cisloCasopisu;

    /**
     * @var string
     *
     * @ORM\Column(name="neregistrovani_spoluautori", type="string", length=255, nullable=true)
     */
    private $neregistrovaniSpoluautori;

    /**
     * @var string
     *
     * @ORM\Column(name="tematicke_zamereni_slovne", type="string", length=255, nullable=true)
     */
    private $tematickeZamereniSlovne;

    /**
     * @var string
     *
     * @ORM\Column(name="jmeno_clanku", type="string", length=255, nullable=false)
     */
    private $jmenoClanku;

    /**
     * @var string
     *
     * @ORM\Column(name="cesta_k_souboru", type="string", length=255, nullable=false)
     */
    private $cestaKsouboru;

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

    /**
     * @var int
     *
     * @ORM\Column(name="tematicke_zamereni", type="integer")
     */
    private $tematickeZamereni;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="nabidnout_znovu_odmitnuty_clanek", type="date", nullable=true)
     */
    private $nabidnoutZnovuOdmitnutyClanek;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="uzaverka_cisla_casopisu", type="date")
     */
    private $uzaverkaCislaCasopisu;


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
     * Set aktivniClanek
     *
     * @param boolean $aktivniClanek
     *
     * @return Clanek
     */
    public function setAktivniClanek($aktivniClanek)
    {
        $this->aktivniClanek = $aktivniClanek;

        return $this;
    }

    /**
     * Get aktivniClanek
     *
     * @return bool
     */
    public function getAktivniClanek()
    {
        return $this->aktivniClanek;
    }

    /**
     * Set clanekZobrazenRedakci
     *
     * @param boolean $clanekZobrazenRedakci
     *
     * @return Clanek
     */
    public function setClanekZobrazenRedakci($clanekZobrazenRedakci)
    {
        $this->clanekZobrazenRedakci = $clanekZobrazenRedakci;

        return $this;
    }

    /**
     * Get clanekZobrazenRedakci
     *
     * @return bool
     */
    public function getClanekZobrazenRedakci()
    {
        return $this->clanekZobrazenRedakci;
    }

    /**
     * Set cekaNaStanoveniRecenzentu
     *
     * @param boolean $cekaNaStanoveniRecenzentu
     *
     * @return Clanek
     */
    public function setCekaNaStanoveniRecenzentu($cekaNaStanoveniRecenzentu)
    {
        $this->cekaNaStanoveniRecenzentu = $cekaNaStanoveniRecenzentu;

        return $this;
    }

    /**
     * Get cekaNaStanoveniRecenzentu
     *
     * @return bool
     */
    public function getCekaNaStanoveniRecenzentu()
    {
        return $this->cekaNaStanoveniRecenzentu;
    }

    /**
     * Set jsouStanoveniRecenzenti
     *
     * @param boolean $jsouStanoveniRecenzenti
     *
     * @return Clanek
     */
    public function setJsouStanoveniRecenzenti($jsouStanoveniRecenzenti)
    {
        $this->jsouStanoveniRecenzenti = $jsouStanoveniRecenzenti;

        return $this;
    }

    /**
     * Get jsouStanoveniRecenzenti
     *
     * @return bool
     */
    public function getJsouStanoveniRecenzenti()
    {
        return $this->jsouStanoveniRecenzenti;
    }

    /**
     * Set probihaRecenzniRizeni
     *
     * @param boolean $probihaRecenzniRizeni
     *
     * @return Clanek
     */
    public function setProbihaRecenzniRizeni($probihaRecenzniRizeni)
    {
        $this->probihaRecenzniRizeni = $probihaRecenzniRizeni;

        return $this;
    }

    /**
     * Get probihaRecenzniRizeni
     *
     * @return bool
     */
    public function getProbihaRecenzniRizeni()
    {
        return $this->probihaRecenzniRizeni;
    }

    /**
     * Set recenzniRizeniByloDokonceno
     *
     * @param boolean $recenzniRizeniByloDokonceno
     *
     * @return Clanek
     */
    public function setRecenzniRizeniByloDokonceno($recenzniRizeniByloDokonceno)
    {
        $this->recenzniRizeniByloDokonceno = $recenzniRizeniByloDokonceno;

        return $this;
    }

    /**
     * Get recenzniRizeniByloDokonceno
     *
     * @return bool
     */
    public function getRecenzniRizeniByloDokonceno()
    {
        return $this->recenzniRizeniByloDokonceno;
    }

    /**
     * Set recenzniRizeniByloZruseno
     *
     * @param boolean $recenzniRizeniByloZruseno
     *
     * @return Clanek
     */
    public function setRecenzniRizeniByloZruseno($recenzniRizeniByloZruseno)
    {
        $this->recenzniRizeniByloZruseno = $recenzniRizeniByloZruseno;

        return $this;
    }

    /**
     * Get recenzniRizeniByloZruseno
     *
     * @return bool
     */
    public function getRecenzniRizeniByloZruseno()
    {
        return $this->recenzniRizeniByloZruseno;
    }

    /**
     * Set novePodanaRevize
     *
     * @param boolean $novePodanaRevize
     *
     * @return Clanek
     */
    public function setNovePodanaRevize($novePodanaRevize)
    {
        $this->novePodanaRevize = $novePodanaRevize;

        return $this;
    }

    /**
     * Get novePodanaRevize
     *
     * @return bool
     */
    public function getNovePodanaRevize()
    {
        return $this->novePodanaRevize;
    }

    /**
     * Set clanekPrijat
     *
     * @param boolean $clanekPrijat
     *
     * @return Clanek
     */
    public function setClanekPrijat($clanekPrijat)
    {
        $this->clanekPrijat = $clanekPrijat;

        return $this;
    }

    /**
     * Get clanekPrijat
     *
     * @return bool
     */
    public function getClanekPrijat()
    {
        return $this->clanekPrijat;
    }

    /**
     * Set clanekPrijatSVyhradami
     *
     * @param boolean $clanekPrijatSVyhradami
     *
     * @return Clanek
     */
    public function setClanekPrijatSVyhradami($clanekPrijatSVyhradami)
    {
        $this->clanekPrijatSVyhradami = $clanekPrijatSVyhradami;

        return $this;
    }

    /**
     * Get clanekPrijatSVyhradami
     *
     * @return bool
     */
    public function getClanekPrijatSVyhradami()
    {
        return $this->clanekPrijatSVyhradami;
    }

    /**
     * Set clanekPrijatVyzadujeFormalniDoplneni
     *
     * @param boolean $clanekPrijatVyzadujeFormalniDoplneni
     *
     * @return Clanek
     */
    public function setClanekPrijatVyzadujeFormalniDoplneni($clanekPrijatVyzadujeFormalniDoplneni)
    {
        $this->clanekPrijatVyzadujeFormalniDoplneni = $clanekPrijatVyzadujeFormalniDoplneni;

        return $this;
    }

    /**
     * Get clanekPrijatVyzadujeFormalniDoplneni
     *
     * @return bool
     */
    public function getClanekPrijatVyzadujeFormalniDoplneni()
    {
        return $this->clanekPrijatVyzadujeFormalniDoplneni;
    }

    /**
     * Set clanekZamitnutNeobstalVRecenznimRizeni
     *
     * @param boolean $clanekZamitnutNeobstalVRecenznimRizeni
     *
     * @return Clanek
     */
    public function setClanekZamitnutNeobstalVRecenznimRizeni($clanekZamitnutNeobstalVRecenznimRizeni)
    {
        $this->clanekZamitnutNeobstalVRecenznimRizeni = $clanekZamitnutNeobstalVRecenznimRizeni;

        return $this;
    }

    /**
     * Get clanekZamitnutNeobstalVRecenznimRizeni
     *
     * @return bool
     */
    public function getClanekZamitnutNeobstalVRecenznimRizeni()
    {
        return $this->clanekZamitnutNeobstalVRecenznimRizeni;
    }

    /**
     * Set clanekZamitnutNesplnujeSablonu
     *
     * @param boolean $clanekZamitnutNesplnujeSablonu
     *
     * @return Clanek
     */
    public function setClanekZamitnutNesplnujeSablonu($clanekZamitnutNesplnujeSablonu)
    {
        $this->clanekZamitnutNesplnujeSablonu = $clanekZamitnutNesplnujeSablonu;

        return $this;
    }

    /**
     * Get clanekZamitnutNesplnujeSablonu
     *
     * @return bool
     */
    public function getClanekZamitnutNesplnujeSablonu()
    {
        return $this->clanekZamitnutNesplnujeSablonu;
    }

    /**
     * Set clanekZamitnutTematickyNevhodny
     *
     * @param boolean $clanekZamitnutTematickyNevhodny
     *
     * @return Clanek
     */
    public function setClanekZamitnutTematickyNevhodny($clanekZamitnutTematickyNevhodny)
    {
        $this->clanekZamitnutTematickyNevhodny = $clanekZamitnutTematickyNevhodny;

        return $this;
    }

    /**
     * Get clanekZamitnutTematickyNevhodny
     *
     * @return bool
     */
    public function getClanekZamitnutTematickyNevhodny()
    {
        return $this->clanekZamitnutTematickyNevhodny;
    }

    /**
     * Set cekaSeNaAutorovuRevizi
     *
     * @param boolean $cekaSeNaAutorovuRevizi
     *
     * @return Clanek
     */
    public function setCekaSeNaAutorovuRevizi($cekaSeNaAutorovuRevizi)
    {
        $this->cekaSeNaAutorovuRevizi = $cekaSeNaAutorovuRevizi;

        return $this;
    }

    /**
     * Get cekaSeNaAutorovuRevizi
     *
     * @return bool
     */
    public function getCekaSeNaAutorovuRevizi()
    {
        return $this->cekaSeNaAutorovuRevizi;
    }

    /**
     * Set nutnostPredatNovouReviziZpetRecenzentum
     *
     * @param boolean $nutnostPredatNovouReviziZpetRecenzentum
     *
     * @return Clanek
     */
    public function setNutnostPredatNovouReviziZpetRecenzentum($nutnostPredatNovouReviziZpetRecenzentum)
    {
        $this->nutnostPredatNovouReviziZpetRecenzentum = $nutnostPredatNovouReviziZpetRecenzentum;

        return $this;
    }

    /**
     * Get nutnostPredatNovouReviziZpetRecenzentum
     *
     * @return bool
     */
    public function getNutnostPredatNovouReviziZpetRecenzentum()
    {
        return $this->nutnostPredatNovouReviziZpetRecenzentum;
    }

    /**
     * Set pozadavekNaNahrazeniRevizeAutorem
     *
     * @param boolean $pozadavekNaNahrazeniRevizeAutorem
     *
     * @return Clanek
     */
    public function setPozadavekNaNahrazeniRevizeAutorem($pozadavekNaNahrazeniRevizeAutorem)
    {
        $this->pozadavekNaNahrazeniRevizeAutorem = $pozadavekNaNahrazeniRevizeAutorem;

        return $this;
    }

    /**
     * Get pozadavekNaNahrazeniRevizeAutorem
     *
     * @return bool
     */
    public function getPozadavekNaNahrazeniRevizeAutorem()
    {
        return $this->pozadavekNaNahrazeniRevizeAutorem;
    }

    /**
     * Set lzePodatNovouRevizi
     *
     * @param boolean $lzePodatNovouRevizi
     *
     * @return Clanek
     */
    public function setLzePodatNovouRevizi($lzePodatNovouRevizi)
    {
        $this->lzePodatNovouRevizi = $lzePodatNovouRevizi;

        return $this;
    }

    /**
     * Get lzePodatNovouRevizi
     *
     * @return bool
     */
    public function getLzePodatNovouRevizi()
    {
        return $this->lzePodatNovouRevizi;
    }

    /**
     * Set nejednoznacnostRecenznihoRizeni
     *
     * @param boolean $nejednoznacnostRecenznihoRizeni
     *
     * @return Clanek
     */
    public function setNejednoznacnostRecenznihoRizeni($nejednoznacnostRecenznihoRizeni)
    {
        $this->nejednoznacnostRecenznihoRizeni = $nejednoznacnostRecenznihoRizeni;

        return $this;
    }

    /**
     * Get nejednoznacnostRecenznihoRizeni
     *
     * @return bool
     */
    public function getNejednoznacnostRecenznihoRizeni()
    {
        return $this->nejednoznacnostRecenznihoRizeni;
    }

    /**
     * Set clanekVydan
     *
     * @param boolean $clanekVydan
     *
     * @return Clanek
     */
    public function setClanekVydan($clanekVydan)
    {
        $this->clanekVydan = $clanekVydan;

        return $this;
    }

    /**
     * Get clanekVydan
     *
     * @return bool
     */
    public function getClanekVydan()
    {
        return $this->clanekVydan;
    }

    /**
     * Set cisloCasopisu
     *
     * @param string $cisloCasopisu
     *
     * @return Clanek
     */
    public function setCisloCasopisu($cisloCasopisu)
    {
        $this->cisloCasopisu = $cisloCasopisu;

        return $this;
    }

    /**
     * Get cisloCasopisu
     *
     * @return string
     */
    public function getCisloCasopisu()
    {
        return $this->cisloCasopisu;
    }

    /**
     * Set neregistrovaniSpoluautori
     *
     * @param string $neregistrovaniSpoluautori
     *
     * @return Clanek
     */
    public function setNeregistrovaniSpoluautori($neregistrovaniSpoluautori)
    {
        $this->neregistrovaniSpoluautori = $neregistrovaniSpoluautori;

        return $this;
    }

    /**
     * Get neregistrovaniSpoluautori
     *
     * @return string
     */
    public function getNeregistrovaniSpoluautori()
    {
        return $this->neregistrovaniSpoluautori;
    }

    /**
     * Set tematickeZamereniSlovne
     *
     * @param string $tematickeZamereniSlovne
     *
     * @return Clanek
     */
    public function setTematickeZamereniSlovne($tematickeZamereniSlovne)
    {
        $this->tematickeZamereniSlovne = $tematickeZamereniSlovne;

        return $this;
    }

    /**
     * Get tematickeZamereniSlovne
     *
     * @return string
     */
    public function getTematickeZamereniSlovne()
    {
        return $this->tematickeZamereniSlovne;
    }

    /**
     * Set tematickeZamereni
     *
     * @param integer $tematickeZamereni
     *
     * @return Clanek
     */
    public function setTematickeZamereni($tematickeZamereni)
    {
        $this->tematickeZamereni = $tematickeZamereni;

        return $this;
    }

    /**
     * Get tematickeZamereni
     *
     * @return int
     */
    public function getTematickeZamereni()
    {
        return $this->tematickeZamereni;
    }

    /**
     * Set nabidnoutZnovuOdmitnutyClanek
     *
     * @param \DateTime $nabidnoutZnovuOdmitnutyClanek
     *
     * @return Clanek
     */
    public function setNabidnoutZnovuOdmitnutyClanek($nabidnoutZnovuOdmitnutyClanek)
    {
        $this->nabidnoutZnovuOdmitnutyClanek = $nabidnoutZnovuOdmitnutyClanek;

        return $this;
    }

    /**
     * Get nabidnoutZnovuOdmitnutyClanek
     *
     * @return \DateTime
     */
    public function getNabidnoutZnovuOdmitnutyClanek()
    {
        return $this->nabidnoutZnovuOdmitnutyClanek;
    }

    /**
     * Set uzaverkaCislaCasopisu
     *
     * @param \DateTime $uzaverkaCislaCasopisu
     *
     * @return Clanek
     */
    public function setUzaverkaCislaCasopisu($uzaverkaCislaCasopisu)
    {
        $this->uzaverkaCislaCasopisu = $uzaverkaCislaCasopisu;

        return $this;
    }

    /**
     * Get uzaverkaCislaCasopisu
     *
     * @return \DateTime
     */
    public function getUzaverkaCislaCasopisu()
    {
        return $this->uzaverkaCislaCasopisu;
    }

    public function __toString()
    {
        return (string)$this->id;
    }

    /**
     * @return string
     */
    public function getCestaKsouboru()
    {
        return $this->cestaKsouboru;
    }

    /**
     * @param string $cestaKsouboru
     */
    public function setCestaKsouboru($cestaKsouboru)
    {
        $this->cestaKsouboru = $cestaKsouboru;
    }
}