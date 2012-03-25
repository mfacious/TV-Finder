<?php

// Include path
set_include_path(realpath(__DIR__ .'/') . PATH_SEPARATOR . get_include_path());

// Autoloader
function loader($class)
{
    require_once str_replace('\\', '/', $class) . '.php';
}

spl_autoload_register('loader');