<?php

define('HOST1','localhost');
define('USER1','root');
//define('USER', 'user12');
define('PASSWORD1','');
//define('PASSWORD', 'tuser12');
define('DB1','aaaas');
//define('DB','user12');


function autoload($class)
{
    $path = __DIR__."/server/api/shop/libs/" . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require $path;
    }
}

//spl_autoload_register('autoloadTest');