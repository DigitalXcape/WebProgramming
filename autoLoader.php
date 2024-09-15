<?php
    function Autoloader($className) {
        $baseDir = __DIR__ . '/model/';
        
        $file = $baseDir . $className . '.php';
        
        if (file_exists($file)) {
            require_once $file;
        } else {
            echo "Class file for $className not found!";
        }
    }
    
    spl_autoload_register('Autoloader');
?>