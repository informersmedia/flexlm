<?php
    define("directory", "/var/www/html/"); // set root directory

    include directory . 'core/system/boot.php';
    include directory . 'config/sql.php';

    $bytes = random_bytes(16); // 23b420e05006a589777439d1933f4004

    $usr = $connect->sanitized("usr"); 
    $permission = $connect->sanitized("permission"); 
    $uemail = $connect->sanitized("uemail"); 

    $upwd = $connect->sanitized("upwd"); 
    $uproject = $connect->sanitized("uproject"); 
    $udomain = $connect->sanitized("udomain");

    if (isset($usr)) {
        
        $uuid = bin2hex($bytes); // uuid
        $upwd = md5($upwd); 

        $connect->createUser( // create new user
            $uuid, 
            $permission, 
            $usr, $uemail, 
            $upwd, 
            $uproject, 
            $udomain
        );
        $connect->getDisconnect();
    }
?>