<?php

spl_autoload_register(function ($class) {
    if(strpos($class, 'LIT\\') !== false){
        $path = str_replace('\\', DIRECTORY_SEPARATOR , $class);
        $path = str_replace('LIT', '', $path);
        require_once(
            dirname(__DIR__)
            . DIRECTORY_SEPARATOR
            .'litci/src'
            . $path
            . '.php');
    }
});
