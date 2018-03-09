<?php

class Asso
{
    private $CODE_TIERS;
    private $LIBELLE_TIERS;
    private $SIGLE;
    private $DESCRIPTIF;
    private $RUE1;
    private $RUE2;
    private $CP;
    private $VILLE;
    private $TELEPHONE;
    private $MAIL;
    private $SITE_INTERNET;
    private $CODE_CATEGORIE;
    private $LIBELLE_CATEGORIE;
    private $CODE_SOUS_CATEGORIE;
    private $LIBELLE_SOUS_CATEGORIE;
    private $SITE;
    private $ADRESSE_SITE;
    private $OUVERTURE;
    private $PERMANENCE;
    private $PUBLIC_VISE;
    private $tag;


    public function setTAG($libelle_tiers){
        $this->tag = str_replace(' ', '', $libelle_tiers);
    }

    public function getTAG(){
        return $this->tag;
    }

    public function getCODETIERS()
    {
        return $this->CODE_TIERS;
    }

    public function getLIBELLETIERS()
    {
        return $this->LIBELLE_TIERS;
    }

    public function getSIGLE()
    {
        return $this->SIGLE;
    }

    public function getDESCRIPTIF()
    {
        return $this->DESCRIPTIF;
    }

    public function getRUE1()
    {
        return $this->RUE1;
    }

    public function getRUE2()
    {
        return $this->RUE2;
    }

    public function getCP()
    {
        return $this->CP;
    }

    public function getVILLE()
    {
        return $this->VILLE;
    }

    public function getTELEPHONE()
    {
        return $this->TELEPHONE;
    }

    public function getMAIL()
    {
        return $this->MAIL;
    }

    public function getSITEINTERNET()
    {
        return $this->SITE_INTERNET;
    }

    public function getCODECATEGORIE()
    {
        return $this->CODE_CATEGORIE;
    }

    public function getLIBELLECATEGORIE()
    {
        return $this->LIBELLE_CATEGORIE;
    }

    public function getCODESOUSCATEGORIE()
    {
        return $this->CODE_SOUS_CATEGORIE;
    }

    public function getLIBELLESOUSCATEGORIE()
    {
        return $this->LIBELLE_SOUS_CATEGORIE;
    }

    public function getSITE()
    {
        return $this->SITE;
    }

    public function getADRESSESITE()
    {
        return $this->ADRESSE_SITE;
    }

    public function getOUVERTURE()
    {
        return $this->OUVERTURE;
    }

    public function getPERMANENCE()
    {
        return $this->PERMANENCE;
    }

    public function getPUBLICVISE()
    {
        return $this->PUBLIC_VISE;
    }


    public function setCODETIERS($CODE_TIERS)
    {
        $this->CODE_TIERS = $CODE_TIERS;
    }


    public function setLIBELLETIERS($LIBELLE_TIERS)
    {
        $this->LIBELLE_TIERS = $LIBELLE_TIERS;
    }

    public function setSIGLE($SIGLE)
    {
        $this->SIGLE = $SIGLE;
    }


    public function setDESCRIPTIF($DESCRIPTIF)
    {
        $this->DESCRIPTIF = $DESCRIPTIF;
    }


    public function setRUE1($RUE1)
    {
        $this->RUE1 = $RUE1;
    }


    public function setRUE2($RUE2)
    {
        $this->RUE2 = $RUE2;
    }


    public function setCP($CP)
    {
        $this->CP = $CP;
    }


    public function setVILLE($VILLE)
    {
        $this->VILLE = $VILLE;
    }


    public function setTELEPHONE($TELEPHONE)
    {
        $this->TELEPHONE = $TELEPHONE;
    }


    public function setMAIL($MAIL)
    {
        $this->MAIL = $MAIL;
    }


    public function setSITEINTERNET($SITE_INTERNET)
    {
        $this->SITE_INTERNET = $SITE_INTERNET;
    }


    public function setCODECATEGORIE($CODE_CATEGORIE)
    {
        $this->CODE_CATEGORIE = $CODE_CATEGORIE;
    }


    public function setLIBELLECATEGORIE($LIBELLE_CATEGORIE)
    {
        $this->LIBELLE_CATEGORIE = $LIBELLE_CATEGORIE;
    }


    public function setCODESOUSCATEGORIE($CODE_SOUS_CATEGORIE)
    {
        $this->CODE_SOUS_CATEGORIE = $CODE_SOUS_CATEGORIE;
    }


    public function setLIBELLESOUSCATEGORIE($LIBELLE_SOUS_CATEGORIE)
    {
        $this->LIBELLE_SOUS_CATEGORIE = $LIBELLE_SOUS_CATEGORIE;
    }

    public function setSITE($SITE)
    {
        $this->SITE = $SITE;
    }

    public function setADRESSESITE($ADRESSE_SITE)
    {
        $this->ADRESSE_SITE = $ADRESSE_SITE;
    }

    public function setOUVERTURE($OUVERTURE)
    {
        $this->OUVERTURE = $OUVERTURE;
    }

    public function setPERMANENCE($PERMANENCE)
    {
        $this->PERMANENCE = $PERMANENCE;
    }

    public function setPUBLICVISE($PUBLIC_VISE)
    {
        $this->PUBLIC_VISE = $PUBLIC_VISE;
    }


}