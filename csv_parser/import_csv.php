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
$queries_error = 0;
$queries_ok = 0;
$failed_queries = [];
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
        $asso->getPUBLICVISE(),
        $asso->getTAG());
    if ($query) {
        $queries_ok += 1;
    } else {
        $queries_error += 1;
        $failed_queries[] = $asso->getCODETIERS();
    }

}

echo 'csv import finished with ' . $queries_ok . ' queries successfull and ' . $queries_error . ' queries failed';
foreach ($failed_queries as $code_tiers) {
    echo "\nAssociation import failed failed CODE TIERS =  " . $code_tiers;
}