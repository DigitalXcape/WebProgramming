<?php
    function Autoloader($className) {
        $baseDir = __DIR__ . '/model/';
        
        $file = $baseDir . $className . '.php';
        
        if (file_exists($file)) {
            require_once $file;
        } else {
            echo "Class file for $className not found!";
        }

        $baseDir = __DIR__ . '/model/';
    }
    
    spl_autoload_register('Autoloader');
?>