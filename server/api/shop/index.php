<?php

require_once 'autoloader.php';
require_once 'config.php';
spl_autoload_register('autoload');
try
{
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
    header("Access-Control-Allow-Headers: Authorization, Content-Type");
    $res = new RestServer();
    $res->run();
}
catch(Exception $e)
{
    return \Response::serverError( 500, $e->getMessage());
}







   



