<?php
    // check cookie
    if (isset($_COOKIE['uuid'])) {
        header("Location: /account"); // redirect to auth...
        exit;
    }
    include 'views/auth.php';
?>