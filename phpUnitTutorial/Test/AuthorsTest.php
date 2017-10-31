<?php

include_once 'phpUnitTutorial/Test/config.php';
include_once '/server/api/shop/config.php';
spl_autoload_register('autoload');
include_once 'server/api/shop/config.php';
include_once '/server/api/shop/libs/TSingeton.php';
require_once 'phpUnitTutorial/Test/Db.php';
include_once '/server/api/shop/libs/Models/DB.php';
include_once '/server/api/shop/libs/Models/Models.php';
include_once '/server/api/shop/libs/Models/Authors.php';

class AuthorsTest extends PHPUnit_Framework_TestCase
{

    protected $pdo;

    protected function setUp()
    {

        //$this->pdo = new Db();
    }
    protected function tearDown()
    {
        //$this->pdo = NULL;
    }

    public function TestFindAllTrue()
    {
        $res = \Models\Authors::findAll();
        $this->assertTrue(count($res) > 0);
    }


    public function TestFindBooktoAuthorTrue()
    {
         $res = \Models\Authors::findBooktoAuthor('dasd');
         $this->assertTrue(count($res) > 0);
    }
    public function testFindBooktoAuthorFalse()
    {


    }
    public function addBookToAuthor()
    {

    }
}