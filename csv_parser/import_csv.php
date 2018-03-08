<?php

namespace csv_parser;

use csv_parser\get_data\GetData;

require_once './settings.php';
require_once './Asso.php';
require_once './get_data/GetData.php';
require_once './dao/Database.php';

use csv_parser\dao\Database;

$data_getter = new GetData('../assocs.csv');
$em = Database::instance();
$assos = $data_getter->get_assos();
foreach ($assos as $asso) {
    echo utf8_encode($asso->getLIBELLETIERS());
    $query = $em->prepare("INSERT INTO `annuaire_assos`(CODE_TIERS,
                                                              LIBELLE_TIERS,
                                                              SIGLE,
                                                              DESCRIPTIF,
                                                              RUE1,
                                                              RUE2,
                                                              CP,
                                                              VILLE,
                                                              TELEPHONE,
                                                              MAIL,
                                                              SITE_INTERNET,
                                                              CODE_CATEGORIE,
                                                              LIBELLE_CATEGORIE,
                                                              CODE_SOUS_CATEGORIE,
                                                              LIBELLE_SOUS_CATEGORIE,
                                                              SITE,
                                                              ADRESSE_SITE,
                                                              OUVERTURE,
                                                              PERMANENCE,
                                                              PUBLIC_VISE) 
                                                              VALUES (:CODE_TIERS,
                                                                  :LIBELLE_TIERS,
                                                                  :SIGLE,
                                                                  :DESCRIPTIF,
                                                                  :RUE1,
                                                                  :RUE2,
                                                                  :CP,
                                                                  :VILLE,
                                                                  :TELEPHONE,
                                                                  :MAIL,
                                                                  :SITE_INTERNET,
                                                                  :CODE_CATEGORIE,
                                                                  :LIBELLE_CATEGORIE,
                                                                  :CODE_SOUS_CATEGORIE,
                                                                  :LIBELLE_SOUS_CATEGORIE,
                                                                  :SITE,
                                                                  :ADRESSE_SITE,
                                                                  :OUVERTURE,
                                                                  :PERMANENCE,
                                                                  :PUBLIC_VISE)");
    $query->bindValue(':CODE_TIERS', $asso->getCODETIERS());
    $query->bindValue(':LIBELLE_TIERS', $asso->getLIBELLETIERS());
    $query->bindValue(':SIGLE', $asso->getSIGLE());
    $query->bindValue(':DESCRIPTIF', $asso->getDESCRIPTIF());
    $query->bindValue(':RUE1', $asso->getRUE1());
    $query->bindValue(':RUE2', $asso->getRUE2());
    $query->bindValue(':CP', $asso->getCP());
    $query->bindValue(':VILLE', $asso->getVILLE());
    $query->bindValue(':TELEPHONE', $asso->getTELEPHONE());
    $query->bindValue(':MAIL', $asso->getMAIL());
    $query->bindValue(':SITE_INTERNET', $asso->getSITEINTERNET());
    $query->bindValue(':CODE_CATEGORIE', $asso->getCODECATEGORIE());
    $query->bindValue(':LIBELLE_CATEGORIE', $asso->getLIBELLECATEGORIE());
    $query->bindValue(':CODE_SOUS_CATEGORIE', $asso->getCODESOUSCATEGORIE());
    $query->bindValue(':LIBELLE_SOUS_CATEGORIE', $asso->getLIBELLESOUSCATEGORIE());
    $query->bindValue(':SITE', $asso->getSITE());
    $query->bindValue(':ADRESSE_SITE', $asso->getADRESSESITE());
    $query->bindValue(':OUVERTURE', $asso->getOUVERTURE());
    $query->bindValue(':PERMANENCE', $asso->getPERMANENCE());
    $query->bindValue(':PUBLIC_VISE', $asso->getPUBLICVISE());
    $query->execute();
}
