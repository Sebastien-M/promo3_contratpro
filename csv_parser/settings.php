<?php
/**
 * Created by PhpStorm.
 * User: sebastienM
 * Date: 06/03/2018
 * Time: 15:32
 */

include_once __DIR__ . '/../wakka.config.php';
define('ASSO_INDEX', [
        'CODE_TIERS_CODE' => 0,
        'LIBELLE_TIERS_CODE' => 1,
        'SIGLE_CODE' => 2,
        'DESCRIPTIF_CODE' => 3,
        'RUE1_CODE' => 4,
        'RUE2_CODE' => 5,
        'CP_CODE' => 6,
        'VILLE_CODE' => 7,
        'TELEPHONE_CODE' => 8,
        'MAIL_CODE' => 9,
        'SITE_INTERNET_CODE' => 10,
        'CODE_CATEGORIE_CODE' => 11,
        'LIBELLE_CATEGORIE_CODE' => 12,
        'CODE_SOUS_CATEGORIE_CODE' => 13,
        'LIBELLE_SOUS_CATEGORIE_CODE' => 14,
        'SITE_CODE' => 15,
        'ADRESSE_SITE_CODE' => 16,
        'OUVERTURE_CODE' => 17,
        'PERMANENCE_CODE' => 18,
        'PUBLIC_VISE_CODE' => 19]
);

define('DATABASE', [
    'db_name' => $wakkaConfig['mysql_database'],
    'username' => $wakkaConfig['mysql_user'],
    'password' => $wakkaConfig['mysql_password']
]);
