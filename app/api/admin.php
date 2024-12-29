<?php

    define("directory", "/var/www/html/"); // set root directory

    include directory . 'core/system/boot.php';
    include directory . 'config/sql.php';

    $server = $connect->getServers(); // fetch data
    $data = [];

    if ($server->num_rows > 0) {
        while ($row = $server->fetch_assoc()) {
            $array = array(
                "uuid" => $row['uuid'],
                "sname" => $row['sname'],
                "slabel" => $row['slabel'],
                "sactive" => $row['sactive'],
                "sstat" => $row['sstat'],
                 "sversion" => $row['sversion'],
                "sup" => $row['sup']
            );

            if (isset($array['sup']) && strtotime($array['sup'])) {
                $array['sup'] = date("Y/m/d H:i:s", strtotime($array['sup']));
            }

            $data[] = $array;
        }

        header('Content-Type: application/json');
        echo json_encode($data); // Encode the entire array
    } else {
        header('Content-Type: application/json');
        echo json_encode([]);
    }

    $server->close(); // close
?>