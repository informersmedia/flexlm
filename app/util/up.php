<?php
        $features = [];
        $currentFeature = null;
        $section = null;

    $sdata = $connect->getUuid($sserver); // get server uuid...
    $row = $sdata->fetch_assoc();

    $eresult = $connect->shell([
        '/usr/local/bin/lmutil', 'lmstat', '-a', '-c', $sserver
    ]);

    if ($eresult['exit'] === 0) {
        if (strlen($eresult['stderr']) === 0) {
            $lines = explode("\n", $item);

            $current_feature_index = -1; // Индекс текущей обрабатываемой фичи
            
            foreach ($lines as $line) {
                $luid = bin2hex(random_bytes(16));
                $line = trim($line);
        
                if (empty($line)) continue;
        
                if (strpos($line, 'Users of') === 0) {
                    $parts = explode(':', $line);
                    $currentFeature = trim(str_replace('Users of', '', $parts[0]));
                    $features[$currentFeature] = [
                        'name' => $currentFeature,
                        'uid' => $luid,
                        'server' => $row['uuid'],
                        'vendor' => $row['svendor'],
                        'total' => 0,
                        'inuse' => 0,
                        'users' => [],
                        'reservations' => [],
                        'sum' => 0,
                        'statistics' => []
                    ];
                    $section = 'feature_summary';
                    $summaryParts = explode(';', $parts[1]);
                    $features[$currentFeature]['total'] = (int)str_replace(['(Total of ', ' licenses issued;'], '', $summaryParts[0]);
                    $inUse = (int)str_replace(['Total of ', ' licenses in use)'], '', $summaryParts[1]);
                    $features[$currentFeature]['inuse'] = $inUse;
                } elseif (isset($currentFeature) && strpos($line, '"') === 0) { // Добавлено isset()
                    $line = str_replace(['"', ','], ['', ' '], $line);
                    $parts = explode(' ', $line);
                    $section = 'feature_details';
        
                } elseif (isset($currentFeature) && is_numeric(substr($line, 0, 1))) { // Добавлено isset()
                    $parts = explode(' ', $line);
                    $reservation = [
                        'count' => (int)$parts[0],
                        'project' => $parts[4],
                        'server' => $parts[5]
                    ];
                    $features[$currentFeature]['reservations'][] = $reservation;
                    $features[$currentFeature]['sum'] += $reservation['count'];
                    $section = 'reservations';
                } elseif (isset($currentFeature) && $section != 'reservations' && ctype_alpha(substr($line, 0, 1))) { // Добавлено isset()
                    if (strpos($line, 'vendor_string:') === false && strpos($line, 'floating license') === false) {
                        $parts = explode(' ', $line);
                        $features[$currentFeature]['users'][] = [
                            'user' => $parts[0],
                            'host' => $parts[1],
                            'start' => $parts[9] . ' ' . $parts[10]
                        ];
                    }
                    $section = 'users';
                }
            }
            
                // Вычитаем sum из inuse после завершения обработки всех строк
                foreach ($features as &$feature) {
                    $feature['inuse'] -= $feature['sum'];
                    $currentTime = date('Y-m-d H:i:s');
                    $feature['statistics'][] = ['time' => $currentTime, 'count' => $feature['inuse']]; // добавляем текущее время и inuse в статистику фичи
                }
                
                // Добавляем текущее время и count в общую статистику
                $currentTime = date('Y-m-d H:i:s');
                $totalInUse = 0;
                foreach ($features as $feature) {
                    $totalInUse += $feature['inuse'];
                }
    
        } else {
             echo "error"; 
        }
         
    } else {
        echo "error";
    } 

?>