<?php
define("directory", "/var/www/html/");

include directory . 'core/system/boot.php';
include directory . 'config/sql.php';

$string = $connect->sanitized("string");
$licenses = $connect->sanitized("licenses");
$period = $connect->sanitized("age"); // get default period

$selected = $connect->getLicensesStat($string); // get all data

$result = ['cols' => [], 'rows' => []];

if ($selected->num_rows > 0) {
    $result['cols'] = [
        ['label' => 'Time', 'type' => 'string'],
        ['label' => $licenses, 'type' => 'number']
    ];

    $filtered_rows = [];
    $now = new DateTime(); // get current date

    while ($row = $selected->fetch_assoc()) {
        if (isset($row['lstatistics'])) {
            $lstatistics = json_decode($row['lstatistics'], true);
            if (is_array($lstatistics)) {
                foreach ($lstatistics as $item) {
                    if (isset($item['v'])) {
                        $item_time = new DateTime($item['v']);

                        $add_item = false;

                        switch ($period) {
                            case 'day':
                                if ($item_time->format('Ymd') == $now->format('Ymd')) {
                                    $add_item = true;
                                }
                                break;
                            case 'week':
                                $week_start = clone $now;
                                $week_start->modify('last sunday');
                                if ($item_time >= $week_start) {
                                    $add_item = true;
                                }
                                break;
                            case 'month':
                                if ($item_time->format('Ym') == $now->format('Ym')) {
                                    $add_item = true;
                                }
                                break;
                            case 'year':
                                if ($item_time->format('Y') == $now->format('Y')) {
                                    $add_item = true;
                                }
                                break;
                            default:
                                $add_item = true;
                                break;
                        }

                        if ($add_item) {
                            $filtered_rows[] = $item_time->format('Y-m-d H:i:s') . "," . $item['c'];
                        }
                    }
                }
            }
        }
    }

    $result['rows'] = $filtered_rows;
}

header('Content-Type: application/json');
echo json_encode($result);
?>