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
}