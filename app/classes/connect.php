<?php
    class Connect {  // use sql connection class
      public $conn;
      public $host;
      public $user;
      public $password;
      public $database;
      
    public function __construct($host, $user, $password, $database) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password; 
        $this->database = $database;

        $this->setConnection();
    }
    
    // set sql connection
    public function setConnection() {
        $this->conn = new mysqli(
        $this->host, 
        $this->user, 
        $this->password, 
        $this->database
      );
        $this->conn->set_charset("utf8mb4");

        if ($this->conn->connect_error) {
            die("connection error: ".$this->conn->connect_error);
        }
    }

    // start a transaction
    public function beginTransaction() {
        if (!$this->conn) {
            throw new Exception("no database connection.");
        }

        if (!$this->conn->begin_transaction()) {
              throw new Exception("failed to begin transaction: " . $this->conn->error);
        }
    }

    // commit a transaction
    public function commit() {
      if (!$this->conn) {
          throw new Exception("no database connection.");
      }
        if (!$this->conn->commit()) {
            throw new Exception("failed to commit transaction: " . $this->conn->error);
        }
    }

    // rollback a transaction
    public function rollback() {
      if (!$this->conn) {
          throw new Exception("no database connection.");
      }
        if (!$this->conn->rollback()) {
            $error_message =  "failed to rollback transaction: " . $this->conn->error;
            if($this->debug)
              {
                echo $error_message;
              }
          throw new Exception($error_message);
      }
    }
    
    // get sql connection
    public function getConnection() {
        return $this->conn;
    }

    // disconnect sql server
    public function getDisconnect() {
      $this->conn->close();
    }

    // auth user
    public function getAuth($uemail) {
      $stmt = $this->conn->prepare("SELECT uuid, permission, usr, uemail, upwd, uproject, udomain FROM users  WHERE uemail = ?");
      $stmt->bind_param("s", $uemail);
      $stmt->execute();
      return $stmt->get_result();
    }

    // get servers
    public function getServers() {
      $stmt = $this->conn->prepare("SELECT uuid, sname, slabel, sactive, sstat, sversion, sup FROM servers");
      $stmt->execute();
      return $stmt->get_result();
    }

    // get server
    public function getServer($uuid) {
      $stmt = $this->conn->prepare("SELECT uuid, sname, slabel, svendor, sactive, sstat, sversion, sup FROM servers WHERE uuid = ?");
      $stmt->bind_param("s", $uuid);
      $stmt->execute();
      return $stmt->get_result();
    }

    // get server
    public function getLicenses($uuid) {
      $stmt = $this->conn->prepare("SELECT lname, luid, lvendor, ltotal, linuse, lusers, lreservations, lsum, lstatistics FROM licenses WHERE lserver = ?");
      $stmt->bind_param("s", $uuid);
      $stmt->execute();
      return $stmt->get_result();
    }

    // get server
    public function getLicensesStat($string) {
      $stmt = $this->conn->prepare("SELECT lname, luid, lvendor, ltotal, linuse, lusers, lreservations, lsum, lstatistics FROM licenses WHERE luid = ?");
      $stmt->bind_param("s", $string);
      $stmt->execute();
      return $stmt->get_result();
    }

    // get server
    public function getLicensesName($uuid) {
      $stmt = $this->conn->prepare("SELECT lname, luid, lserver FROM licenses WHERE luid = ?");
      $stmt->bind_param("s", $uuid);
      $stmt->execute();
      return $stmt->get_result();
    }

    // get users
    public function getUsers() {
      $stmt = $this->conn->prepare("SELECT uuid, permission, usr, uemail, upwd, uproject, udomain FROM users");
      $stmt->execute();
      return $stmt->get_result();
    }

    // get user
    public function getUser($uuid) {
      $stmt = $this->conn->prepare("SELECT uuid, permission, usr, uemail, upwd, uproject, udomain FROM users WHERE uuid = ?");
      $stmt->bind_param("s", $uuid);
      $stmt->execute();
      return $stmt->get_result();
    }

    // get del user
    public function getDelUser($uuid) {
      $stmt = $this->conn->prepare("SELECT uuid, usr, uemail, upwd, uproject, udomain FROM users WHERE uuid = ?");
      $stmt->bind_param("s", $uuid);
      $stmt->execute();
      return $stmt->get_result();
    }
  
    // set server
    public function setServer($uuid, $sname, $slabel,  $svendor, $sactive, $sstat, $sversion, $sup) {
      $check = $this->conn->prepare("SELECT sname FROM servers WHERE sname = ?");
      $check->bind_param("s", $sname);
      $check->execute();
      $result = $check->get_result();
      if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error']);
        return false;
      } else {

      $stmt = $this->conn->prepare("INSERT INTO servers (uuid, sname, slabel, svendor, sactive, sstat, sversion, sup) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssssss", 
      $uuid, $sname, $slabel, $svendor, $sactive, $sstat, $sversion, $sup);
      $stmt->execute();
        echo json_encode(['status' => 'success']);
        return true;
      }
    }

    // up server
    public function upServer($uuid, $sname, $slabel, $sactive) {
      $stmt = $this->conn->prepare("UPDATE servers SET uuid = ?, sname = ?, slabel = ?, sactive = ? WHERE uuid = ?");
      $stmt->bind_param("sssss", $uuid, $sname, $slabel, $sactive, $uuid);
      $stmt->execute();
      return $stmt->get_result();
    }

    // cron server
    public function crServer($sname, $sstat, $sversion, $sup) {
      $stmt = $this->conn->prepare("UPDATE servers SET sstat = ?, sversion = ?, sup = ? WHERE sname = ?");
      $stmt->bind_param("ssss", $sstat, $sversion, $sup, $sname);
      $stmt->execute();
      return $stmt->get_result();
    }
    
    // get server uuid
    public function getUuid($sname) {
      $stmt = $this->conn->prepare("SELECT uuid, svendor FROM servers WHERE sname = ?");
      $stmt->bind_param("s", $sname);
      $stmt->execute();
      return  $stmt->get_result();
    }

    // remove server
    public function rmServer($uuid) {
      $stmt = $this->conn->prepare("DELETE FROM servers WHERE uuid = ?");
      $stmt->bind_param("s", $uuid);
      $stmt->execute();
      return $stmt->get_result();
    }

    // delete user
    public function delUser($uuid) {
      $stmt = $this->conn->prepare("DELETE FROM users WHERE uuid = ?");
      $stmt->bind_param("s", $uuid);
      $stmt->execute();
      return $stmt->get_result();
    }

    // create user
    public function createUser($uuid, $permission, $usr, $uemail, $upwd, $uproject, $udomain) {
      $stmt = $this->conn->prepare("INSERT INTO users (uuid, permission, usr, uemail, upwd, uproject, udomain) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sssssss", 
      $uuid, $permission, $usr, $uemail, $upwd, $uproject, $udomain);
      $stmt->execute();
      return $stmt->get_result();
    }

    // variable sanitaized
    public function  sanitized($key, $default = null) {
      if (isset($_POST[$key])) {
        return trim($_POST[$key]);
      } else {
        return $default;
      }
    }
    
    // lmutil command
    public function  lmutil(string $sname): string {
      return '/usr/local/bin/lmutil lmutil lmstat -a -c ' . $sname;
    }

    // insetr licenses
    public function insertFeatures(array $features) {
      $placeholders = [];
      $values = [];
    
      foreach($features as $feature){
        $placeholders[] = "(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $values[] = $feature['name'];
        $values[] = $feature['uid'];
        $values[] = $feature['server'];
        $values[] = $feature['vendor'];
        $values[] = $feature['total'];
        $values[] = $feature['inuse'];
        $values[] = json_encode($feature['users']);
        $values[] = json_encode($feature['reservations']);
        $values[] = $feature['sum'];
        $values[] = json_encode($feature['statistics']);
      }
    
      $placeholders = implode(",", $placeholders);
      $stmt = $this->conn->prepare("INSERT INTO licenses (lname, luid, lserver, lvendor, ltotal, linuse, lusers, lreservations, lsum, lstatistics) VALUES $placeholders");
      
      $stmt->bind_param(str_repeat('s', count($values)), ...$values);
      $stmt->execute();
    }

    // up licenses...
    public function updateFeatures(array $features) {
      $this->conn->begin_transaction();
      try {
          $sql = "UPDATE licenses SET ltotal = ?, linuse = ?, lusers = ?, lreservations = ?, lsum = ?, lstatistics = ? WHERE lname = ? AND lserver = ?";
          $stmt = $this->conn->prepare($sql);
  
          foreach (array_chunk($features, 40) as $chunk) {
              foreach ($chunk as $feature) {
                  $values = [
                      $feature['total'],
                      $feature['inuse'],
                      json_encode($feature['users']),
                      json_encode($feature['reservations']),
                      $feature['sum'],
                      json_encode($feature['statistics']),
                      $feature['name'],
                      $feature['server']
                  ];
                  
                  $types = str_repeat('s', count($values));
                  
                  $stmt->bind_param($types, ...$values);
                  $stmt->execute();
              }
          }

          $this->conn->commit();
      } catch (Exception $e) {
          $this->conn->rollback(); // rollback...
          throw $e; // throw...
      }
    }

    // get by name
    public function geStatistics(string $name, string $server) {
      $stmt = $this->conn->prepare("SELECT lstatistics FROM licenses WHERE lname = ? AND lserver = ?");
      $stmt->bind_param('ss', $name, $server);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        return $result->fetch_assoc();
      } else {
        return null;
      }
    }

    // remove licenses
    public function rmLicenses(string $serverUuid) {
      $sql = "DELETE FROM licenses WHERE lserver = ?";
      $stmt = $this->conn->prepare($sql);
  
      if ($stmt === false) {
          error_log("Ошибка подготовки запроса: " . $this->conn->error);
          return false;
      }
  
      $stmt->bind_param("s", $serverUuid);
  
      if ($stmt->execute() === false) {
          error_log("Ошибка выполнения запроса: " . $stmt->error);
          $stmt->close();
          return false;
      }
  
      $rowsAffected = $stmt->affected_rows;
      $stmt->close();
  
      return $rowsAffected;
    }

    // get string stdout
    public function strings(string $text, string $delimiter = "\n"): array {
        return explode($delimiter, $text);
    }

    // get data lmutil
    public function shell(array $args): array {
      $command = implode(' ', array_map('escapeshellarg', $args));
      $descriptorspec = [
          0 => ['pipe', 'r'],
          1 => ['pipe', 'w'],
          2 => ['pipe', 'w'],
      ];

      $process = proc_open($command, $descriptorspec, $pipes);

      if (is_resource($process)) {
          $stdout = stream_get_contents($pipes[1]);
          $stderr = stream_get_contents($pipes[2]);

          fclose($pipes[0]);
          fclose($pipes[1]);
          fclose($pipes[2]);

          $exit = proc_close($process);

          return [
              'stdout' => $stdout,
              'stderr' => $stderr,
              'exit' => $exit,
              'command' => $command
          ];
      }

      $error = error_get_last();
      $message = 'failed to open process: ' . ($error ? $error['message'] : 'unknown error');
      return [
          'stdout' => '',
          'stderr' => $message,
          'exit' => null,  // use null to indicate failure...
          'command' => $command
      ];
    }

  }
?>