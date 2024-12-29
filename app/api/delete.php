<?php
    define("directory", "/var/www/html/"); // set root directory

    include directory . 'core/system/boot.php';
    include directory . 'config/sql.php';

    $uuid = $_POST["uuid"]; 

    if (isset($uuid)) {

        $connect->delUser($uuid);
        $connect->getDisconnect();
    }
?>