<?php

//spl_autoload_register(function ($class)
//{
//    $path = "libs/" . str_replace('\\', '/', $class) . '.php';
//    if (file_exists($path)) {
//        require $path;
//    }
//});

function autoload($class)
{
    $path = "libs/" . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require $path;
    }
}