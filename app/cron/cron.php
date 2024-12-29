<?php
    ini_set('log_errors', 1);
    ini_set('error_log', '/var/www/html/cron/php_errors.log');

    include '/var/www/html/core/system/boot.php';
    include '/var/www/html/config/sql.php';

    $output = []; // lmutil text data...
    $features = []; // add licenses...

    $list = [];
    $server = $connect->getServers(); // get server list...

    while ($row = $server->fetch_assoc()) { // get server name...
        $list[] = array('uuid' => $row['uuid'], 'sname' => $row['sname']);

    }
    
    foreach ($list as $item) {
        $result = $connect->shell(['/usr/local/bin/lmutil', 'lmstat', '-a', '-c', $item['sname']]);
        $output[] = array('stdout' => $result['stdout'], 'uuid' => $item['uuid']);
    }
    
    foreach ($output as $item) { // update servers...
        include '/var/www/html/util/worker.php';

        $connect->crServer(
            $sserver,
            $sstat,
            $sversion,
            $sup
        );
    }

    foreach ($output as $item) { // update licenses...
        $features = []; // add licenses...

        $current = null; // current...
        $section = null; // section...

        foreach ($connect->strings($item['stdout']) as $line) {
           
            $line = trim($line);
            if (empty($line)) continue;
    
            if (strpos($line, 'Users of') === 0) {
                $parts = explode(':', $line);
                $current = trim(str_replace('Users of', '', $parts[0]));
    
                $features[$current] = [
                    'name' => $current,
                    'server' => $item['uuid'],
                    'total' => 0,
                    'inuse' => 0,
                    'users' => [],
                    'reservations' => [],
                    'sum' => 0,
                    'statistics' => []
                ];
    
                $section = 'feature_summary';
                $summaryParts = explode(';', $parts[1]);
                $features[$current]['total'] = (int)str_replace(['(Total of ', ' licenses issued;'], '', $summaryParts[0]);
                $inUse = (int)str_replace(['Total of ', ' licenses in use)'], '', $summaryParts[1]);
                $features[$current]['inuse'] = $inUse;
    
            } elseif (isset($current) && strpos($line, '"') === 0) {
                $line = str_replace(['"', ','], ['', ' '], $line);
                $parts = explode(' ', $line);
                $section = 'feature_details';
    
            } elseif (isset($current) && is_numeric(substr($line, 0, 1))) { 
                $parts = explode(' ', $line);
                $reservation = [
                    'count' => (int)$parts[0],
                    'project' => $parts[4],
                    'server' => $parts[5]
                ];
                $features[$current]['reservations'][] = $reservation;
                $features[$current]['sum'] += $reservation['count'];
                $section = 'reservations';
    
            } elseif (isset($current) && $section != 'reservations' && ctype_alpha(substr($line, 0, 1))) { 
                if (strpos($line, 'vendor_string:') === false && strpos($line, 'floating license') === false) {
                    $parts = explode(' ', $line);
                    $features[$current]['users'][] = [
                        'user' => $parts[0],
                        'host' => $parts[1],
                        'start' => $parts[9] . ' ' . $parts[10]
                    ];
                }
                $section = 'users';
            }
        }
    
        if (is_array($features)) {
            foreach ($features as $key => $feature) {
                $features[$key]['inuse'] -= $features[$key]['sum'];
                $currentTime = date('Y-m-d H:i:s');
                
                $statisticData = $connect->geStatistics($features[$key]['name'], $features[$key]['server']);
                
                if ($statisticData) {
                    $statistics = json_decode($statisticData['lstatistics'], true);
                    foreach ($statistics as $stat) {
                        $features[$key]['statistics'][] = $stat;
                    }
                }
                
                $features[$key]['statistics'][] = ['v' => $currentTime, 'c' => $features[$key]['inuse']];
            }
        } else {
            echo "features is not an array";
        }
        
        $totalInUse = null;
        $currentTime = date('Y-m-d H:i:s');

        foreach ($features as $feature) {
            $totalInUse += $feature['inuse'];
        }
    
        $connect->updateFeatures($features); // update licenses...
    }
?>