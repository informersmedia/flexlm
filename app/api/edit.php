<?php
    define("directory", "/var/www/html/"); // set root directory

    include directory . 'core/system/boot.php';
    include directory . 'config/sql.php';

    $slabel = $connect->sanitized("slabel"); 
    $uuid = $connect->sanitized("uuid"); 
    $sname = $connect->sanitized("sname"); 
    $sactive = $connect->sanitized("sactive"); 

    if (isset($uuid)) {

        $connect->upServer( // up server...
            $uuid, 
            $sname, 
            $slabel, 
            $sactive
        );
        $connect->getDisconnect();
    }
?>