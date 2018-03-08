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
            if($i > 3){
                $desc_asso = explode("#", $line[0]);
                $asso = new Asso();
                $asso->setCODETIERS(utf8_encode($desc_asso[ASSO_INDEX['CODE_TIERS_CODE']]));
                $asso->setLIBELLETIERS(utf8_encode($desc_asso[ASSO_INDEX['LIBELLE_TIERS_CODE']]));
                $asso->setSIGLE(utf8_encode($desc_asso[ASSO_INDEX['SIGLE_CODE']]));
                $asso->setDESCRIPTIF(utf8_encode($desc_asso[ASSO_INDEX['DESCRIPTIF_CODE']]));
                $asso->setRUE1(utf8_encode($desc_asso[ASSO_INDEX['RUE1_CODE']]));
                $asso->setRUE2(utf8_encode($desc_asso[ASSO_INDEX['RUE2_CODE']]));
                $asso->setCP($desc_asso[ASSO_INDEX['CP_CODE']]);
                $asso->setVILLE(utf8_encode($desc_asso[ASSO_INDEX['VILLE_CODE']]));
                $asso->setTELEPHONE(utf8_encode($desc_asso[ASSO_INDEX['TELEPHONE_CODE']]));
                $asso->setMAIL(utf8_encode($desc_asso[ASSO_INDEX['MAIL_CODE']]));
                $asso->setSITEINTERNET(utf8_encode($desc_asso[ASSO_INDEX['SITE_INTERNET_CODE']]));
                $asso->setCODECATEGORIE($desc_asso[ASSO_INDEX['CODE_CATEGORIE_CODE']]);
                $asso->setLIBELLECATEGORIE(utf8_encode($desc_asso[ASSO_INDEX['LIBELLE_CATEGORIE_CODE']]));
                $asso->setCODESOUSCATEGORIE($desc_asso[ASSO_INDEX['CODE_SOUS_CATEGORIE_CODE']]);
                $asso->setLIBELLESOUSCATEGORIE(utf8_encode($desc_asso[ASSO_INDEX['LIBELLE_SOUS_CATEGORIE_CODE']]));
                $asso->setSITE(utf8_encode($desc_asso[ASSO_INDEX['SITE_CODE']]));
                $asso->setADRESSESITE(utf8_encode($desc_asso[ASSO_INDEX['ADRESSE_SITE_CODE']]));
                $asso->setOUVERTURE(utf8_encode($desc_asso[ASSO_INDEX['OUVERTURE_CODE']]));
                $asso->setPERMANENCE(utf8_encode($desc_asso[ASSO_INDEX['PERMANENCE_CODE']]));
                $asso->setPUBLICVISE(utf8_encode($desc_asso[ASSO_INDEX['PUBLIC_VISE_CODE']]));
                $this->asso_array[] = $asso;
            }
            $i += 1;
        }
        fclose($this->file);
        return $this->asso_array;
    }
}