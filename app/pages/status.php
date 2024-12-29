<?php
    // check cookie
    if (empty($_COOKIE['uuid'])) {
        header("Location: /auth"); // redirect to auth...
        exit;
    }
    include 'views/status.php';
?>