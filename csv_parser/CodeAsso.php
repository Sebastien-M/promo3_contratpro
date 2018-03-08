<?php
/**
 * Created by PhpStorm.
 * User: sebastienM
 * Date: 05/03/2018
 * Time: 16:54
 */


class CodeAsso
{
    private $CODE_TIERS_CODE = 0;
    private $LIBELLE_TIERS_CODE = 1;
    private $SIGLE_CODE = 2;
    private $DESCRIPTIF_CODE = 3;
    private $RUE1_CODE = 4;
    private $RUE2_CODE = 5;
    private $CP_CODE = 6;
    private $VILLE_CODE = 7;
    private $TELEPHONE_CODE = 8;
    private $MAIL_CODE = 9;
    private $SITE_INTERNET_CODE = 10;
    private $CODE_CATEGORIE_CODE = 11;
    private $LIBELLE_CATEGORIE_CODE = 12;
    private $CODE_SOUS_CATEGORIE_CODE = 13;
    private $LIBELLE_SOUS_CATEGORIE_CODE = 14;
    private $SITE_CODE = 15;
    private $ADRESSE_SITE_CODE = 16;
    private $OUVERTURE_CODE = 17;
    private $PERMANENCE_CODE = 18;
    private $PUBLIC_VISE_CODE = 19;

    public function getCODETIERSCODE()
    {
        return $this->CODE_TIERS_CODE;
    }

    public function getLIBELLETIERSCODE()
    {
        return $this->LIBELLE_TIERS_CODE;
    }

    public function getSIGLECODE()
    {
        return $this->SIGLE_CODE;
    }

    public function getDESCRIPTIFCODE()
    {
        return $this->DESCRIPTIF_CODE;
    }

    public function getRUE1CODE()
    {
        return $this->RUE1_CODE;
    }

    public function getRUE2CODE()
    {
        return $this->RUE2_CODE;
    }

    public function getCPCODE()
    {
        return $this->CP_CODE;
    }

    public function getVILLECODE()
    {
        return $this->VILLE_CODE;
    }

    public function getTELEPHONECODE()
    {
        return $this->TELEPHONE_CODE;
    }

    public function getMAILCODE()
    {
        return $this->MAIL_CODE;
    }

    public function getSITEINTERNETCODE()
    {
        return $this->SITE_INTERNET_CODE;
    }

    public function getCODECATEGORIECODE()
    {
        return $this->CODE_CATEGORIE_CODE;
    }

    public function getLIBELLECATEGORIECODE()
    {
        return $this->LIBELLE_CATEGORIE_CODE;
    }

    public function getCODESOUSCATEGORIECODE()
    {
        return $this->CODE_SOUS_CATEGORIE_CODE;
    }

    public function getLIBELLESOUSCATEGORIECODE()
    {
        return $this->LIBELLE_SOUS_CATEGORIE_CODE;
    }

    public function getSITECODE()
    {
        return $this->SITE_CODE;
    }

    public function getADRESSESITECODE()
    {
        return $this->ADRESSE_SITE_CODE;
    }

    public function getOUVERTURECODE()
    {
        return $this->OUVERTURE_CODE;
    }

    public function getPERMANENCECODE()
    {
        return $this->PERMANENCE_CODE;
    }

    public function getPUBLICVISECODE()
    {
        return $this->PUBLIC_VISE_CODE;
    }

}