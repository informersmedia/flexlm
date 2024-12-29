<?php

    define("directory", "/var/www/html/"); // set root directory...

    include directory . 'core/system/boot.php';
    include directory . 'config/sql.php';
    
    header('Content-Type: application/json');

    $slabel = $connect->sanitized("slabel"); 
    $svendor = $connect->sanitized("svendor"); 
    $sname = $connect->sanitized("sname"); 
    $sactive = $connect->sanitized("sactive"); 

    if (isset($sname)) {
        $result = $connect->shell([
            '/usr/local/bin/lmutil', 'lmstat', '-a', '-c', $sname
        ]);
        
        if ($result['exit'] === 0) {  // check for success...
            if (strlen($result['stderr']) === 0) {

                include directory . 'util/process.php';

                $uuid = bin2hex(random_bytes(16));
                $connect->setServer( // set server...
                    $uuid, 
                    $sserver, 
                    $slabel, 
                    $svendor,
                    $sactive, 
                    $sstat, 
                    $sversion, 
                    $sup
                );
                $euuid = $connect->getUuid($sname);

                if ($euuid) {
                    include directory . 'util/matches.php';
                    $connect->insertFeatures($features);
                } else {
                  echo "error";
                }
                $connect->getDisconnect();
            } else {
                echo "error";
            }
       } else { 
           echo "error";
        }
    } else {
        echo "error";
    }
    
?>