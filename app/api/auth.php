<?php
    define("directory", "/var/www/html/"); // set root directory

    include directory . 'core/system/boot.php';
    include directory . 'config/sql.php';

    $uemail = $_POST["uemail"];
    $upwd = $_POST["upwd"];

    if (isset($uemail)) {
        $hashpwd = md5($upwd);

        $check = mysqli_fetch_array($connect->getAuth($uemail));
        if (isset($check["uemail"])) {
            if ($check["uemail"] == $uemail) {
                if ($check["upwd"] == $hashpwd) {
                    // authentication successful
                    setcookie("uuid", $check["uuid"], time() + (86400 * 30), "/", "", true, true);
                    setcookie("permission", $check["permission"], time() + (86400 * 30), "/", "", true, true);

                    $response = array("success" => true);
                    header('Content-type: application/json');
                    echo json_encode($response);
                    exit;
                } else {
                    // incorrect password
                    $response = array("success" => false, "message" => "Incorrect password");
                    header('Content-type: application/json');
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response = array("success" => false, "message" => "Email mismatch");
                header('Content-type: application/json');
                echo json_encode($response);
                exit;
            }
        } else {
            // user not found
            $response = array("success" => false, "message" => "User not found");
            header('Content-type: application/json');
            echo json_encode($response);
            exit;
        }
    } else {
        // missing email
        $response = array("success" => false, "message" => "Email not provided");
        header('Content-type: application/json');
        echo json_encode($response);
        exit;
    }
?>