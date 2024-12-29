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
            "description" => $row['slabel'],
            "server" => $row['sname'],
            "status" => $row['sstat'],
            "current" => "Сведения",
            "available" => "Просмотр",
            "version" => $row['sversion'],
            "update" => $row['sup']
        );

        if (isset($array['update']) && strtotime($array['update'])) {
            $array['update'] = date("Y/m/d H:i:s", strtotime($array['update']));
        }

        $data[] = $array;
    }

    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT); // Encode the entire array
} else {
    header('Content-Type: application/json');
    echo json_encode([]);
}

?>