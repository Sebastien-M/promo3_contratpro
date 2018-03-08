<?php
/**
 * Created by PhpStorm.
 * User: sebastienM
 * Date: 07/03/2018
 * Time: 15:30
 */

namespace csv_parser\dao;
require_once __DIR__ . '/../settings.php';

use PDO;
use Asso;

class Database
{
    private static $instance;
    private $em;

    private function __construct()
    {
        $this->em = new PDO('mysql:host=127.0.0.1;dbname=' . DATABASE['db_name'],
            DATABASE['username'],
            DATABASE['password']);
        $this->em->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->em;
    }

    public static function add_asso(\Asso $asso,
                             $code_tiers,
                             $libelle_tiers,
                             $sigle,
                             $descriptif,
                             $rue1,
                             $rue2,
                             $cp,
                             $ville,
                             $telephone,
                             $mail,
                             $site_internet,
                             $code_categorie,
                             $libelle_categorie,
                             $code_sous_categorie,
                             $libelle_sous_categorie,
                             $site,
                             $adresse_site,
                             $ouverture,
                             $permanence,
                             $public_vise)
    {
        $em = self::instance();
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
                                                              PUBLIC_VISE,
                                                              tag) 
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
                                                                  :PUBLIC_VISE,
                                                                  :tag)");
        $query->bindValue(':CODE_TIERS',$code_tiers);
        $query->bindValue(':LIBELLE_TIERS',$libelle_tiers);
        $query->bindValue(':SIGLE',$sigle);
        $query->bindValue(':DESCRIPTIF',$descriptif);
        $query->bindValue(':RUE1',$rue1);
        $query->bindValue(':RUE2',$rue2);
        $query->bindValue(':CP',$cp);
        $query->bindValue(':VILLE',$ville);
        $query->bindValue(':TELEPHONE',$telephone);
        $query->bindValue(':MAIL',$mail);
        $query->bindValue(':SITE_INTERNET',$site_internet);
        $query->bindValue(':CODE_CATEGORIE',$code_categorie);
        $query->bindValue(':LIBELLE_CATEGORIE',$libelle_categorie);
        $query->bindValue(':CODE_SOUS_CATEGORIE',$code_sous_categorie);
        $query->bindValue(':LIBELLE_SOUS_CATEGORIE',$libelle_sous_categorie);
        $query->bindValue(':SITE',$site);
        $query->bindValue(':ADRESSE_SITE',$adresse_site);
        $query->bindValue(':OUVERTURE',$ouverture);
        $query->bindValue(':PERMANENCE',$permanence);
        $query->bindValue(':PUBLIC_VISE',$public_vise);
        $query->bindValue(':tag',$asso->getLIBELLETIERS());
        try{
            $query->execute();
            return true;
        }
        catch (\Exception $e){
//            echo $e;
            return false;
        }
    }
}