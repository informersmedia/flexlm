<?php
    $lines = $connect->strings($item['stdout']);
    $shost = null;
    $sstat = null;
    $sversion = null;
    $sup = null;
    $sserver = null;

    foreach ($lines as $line) {
        $line = trim($line);

        if (empty($line)) continue;
        if (strpos($line, 'License server status:') === 0) {
            $string = explode(':', $line);

            if (isset($string[1])) {
                $sserver = trim($string[1]);
                $expl = explode('@', $sserver);

                if (isset($expl[1])) {
                   $shost = trim($expl[1]);
                }
                break;
            }
        }
    }

    foreach ($lines as $line) {
        $line = trim($line);
          if (strpos($line, $shost . ':') === 0) {

                $string = explode(' ', $line);
                $sstat = $string[3];
                $sversion = $string[5];

                if ($sstat == "UP") {
                    $sstat = "Доступен";
                }
            }

          if (strpos($line, 'Error getting status:') === 0) {
              $sstat = "Недоступен";
              $sversion = "Нет данных";
            }

        if (strpos($line, 'Flexible License Manager status on') === 0) {
                $string = explode(' ', $line);
                $sup = $string[6] . ' ' . $string[7];
                if (strpos($line, 'License server machine is down') === 0) {
                  $sstat = "Недоступен";
                    $sversion = "Нет данных";
                }
            }
        if (strpos($line, 'lmgrd is not running:') === 0) {
          $sstat = "Недоступен";
          $sversion = "Нет данных";
          }
    }

?>