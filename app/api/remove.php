<?php
    define("directory", "/var/www/html/"); // set root directory

    include directory . 'core/system/boot.php';
    include directory . 'config/sql.php';

    $uuid = $connect->sanitized("uuid"); // get server uuid

    if (isset($uuid)) {
        $connect->rmServer($uuid); // remove server
        $connect->rmLicenses($uuid); // remove licenses

        $connect->getDisconnect(); // sql disconnected...
    }
?>