<?php
/**
 * Created by PhpStorm.
 * User: sebastienM
 * Date: 05/03/2018
 * Time: 15:21
 */
namespace csv_parser\get_data;
require_once __DIR__.'/../settings.php';

use csv_parser\dao\Database;
use Asso;

class GetData
{
    private $file_path;
    private $file;
    private $asso_array;
    private $em;

    public function __construct($file_path)
    {
        $this->file_path = $file_path;
        $this->em = Database::instance();
    }

    public function get_assos(){
        $this->file = fopen($this->file_path, 'r');
        $i = 0;
        while (($line = fgetcsv($this->file)) !== FALSE) {
            if($i != 0){
                $desc_asso = explode("#", $line[0]);
                $asso = new Asso();
                $asso->setCODETIERS($desc_asso[ASSO_INDEX['CODE_TIERS_CODE']]);
                $asso->setLIBELLETIERS($desc_asso[ASSO_INDEX['LIBELLE_TIERS_CODE']]);
                $asso->setSIGLE($desc_asso[ASSO_INDEX['SIGLE_CODE']]);
                $asso->setDESCRIPTIF($desc_asso[ASSO_INDEX['DESCRIPTIF_CODE']]);
                $asso->setRUE1($desc_asso[ASSO_INDEX['RUE1_CODE']]);
                $asso->setRUE2($desc_asso[ASSO_INDEX['RUE2_CODE']]);
                $asso->setCP($desc_asso[ASSO_INDEX['CP_CODE']]);
                $asso->setVILLE($desc_asso[ASSO_INDEX['VILLE_CODE']]);
                $asso->setTELEPHONE($desc_asso[ASSO_INDEX['TELEPHONE_CODE']]);
                $asso->setMAIL($desc_asso[ASSO_INDEX['MAIL_CODE']]);
                $asso->setSITEINTERNET($desc_asso[ASSO_INDEX['SITE_INTERNET_CODE']]);
                $asso->setCODECATEGORIE($desc_asso[ASSO_INDEX['CODE_CATEGORIE_CODE']]);
                $asso->setLIBELLECATEGORIE($desc_asso[ASSO_INDEX['LIBELLE_CATEGORIE_CODE']]);
                $asso->setCODESOUSCATEGORIE($desc_asso[ASSO_INDEX['CODE_SOUS_CATEGORIE_CODE']]);
                $asso->setLIBELLESOUSCATEGORIE($desc_asso[ASSO_INDEX['LIBELLE_SOUS_CATEGORIE_CODE']]);
                $asso->setSITE($desc_asso[ASSO_INDEX['SITE_CODE']]);
                $asso->setADRESSESITE($desc_asso[ASSO_INDEX['ADRESSE_SITE_CODE']]);
                $asso->setOUVERTURE($desc_asso[ASSO_INDEX['OUVERTURE_CODE']]);
                $asso->setPERMANENCE($desc_asso[ASSO_INDEX['PERMANENCE_CODE']]);
                $asso->setPUBLICVISE($desc_asso[ASSO_INDEX['PUBLIC_VISE_CODE']]);
                $this->asso_array[] = $asso;
            }
            $i += 1;
        }
        fclose($this->file);
        return $this->asso_array;
    }

}