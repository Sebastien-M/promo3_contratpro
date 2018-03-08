<?php

namespace csv_parser;

use csv_parser\get_data\GetData;

require_once './settings.php';
require_once './Asso.php';
require_once './get_data/GetData.php';
require_once './dao/Database.php';

use csv_parser\dao\Database;

$data_getter = new GetData('../assocs.csv');
$assos = $data_getter->get_assos();
foreach ($assos as $asso) {
    $query = Database::add_asso($asso,
        $asso->getCODETIERS(),
        $asso->getLIBELLETIERS(),
        $asso->getSIGLE(),
        $asso->getDESCRIPTIF(),
        $asso->getRUE1(),
        $asso->getRUE2(),
        $asso->getCP(),
        $asso->getVILLE(),
        $asso->getTELEPHONE(),
        $asso->getMAIL(),
        $asso->getSITEINTERNET(),
        $asso->getCODECATEGORIE(),
        $asso->getLIBELLECATEGORIE(),
        $asso->getCODESOUSCATEGORIE(),
        $asso->getLIBELLESOUSCATEGORIE(),
        $asso->getSITE(),
        $asso->getADRESSESITE(),
        $asso->getOUVERTURE(),
        $asso->getPERMANENCE(),
        $asso->getPUBLICVISE());
    if($query){
        echo 'ok';
    }
    else{
        echo 'error';
    }

}
