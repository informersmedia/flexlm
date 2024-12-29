<?php
    // this script routing based on the requested...
     $router = new Router();

     $router->add('/',                 'pages/status.php');      // define routes...
     $router->add('/statistics/[id]',  'pages/statistics.php');
     $router->add('/status',           'pages/status.php');
     $router->add('/usage/[id]',       'pages/usage.php');
     $router->add('/admin',            'pages/admin.php');
     $router->add('/add',              'pages/add.php');
     $router->add('/create',           'pages/create.php');
     $router->add('/listing/[id]',     'pages/listing.php');
     $router->add('/users',            'pages/users.php');
     $router->add('/auth',             'pages/auth.php');
     $router->add('/chart/[id]',       'pages/chart.php');
     $router->add('/account',          'pages/account.php');
     $router->add('/edit/[id]',        'pages/edit.php');
     $router->add('/exit',             'pages/exit.php');
     $router->add('/delete/[id]',      'pages/delete.php');
     
     $uri = isset(
        $_SERVER['REQUEST_URI']) ? // server request...
        $_SERVER['REQUEST_URI'] : '/'; 

     // correct uri...
     $page = $router->route($uri);
     if ($page == 'pages/error.php') {
       http_response_code(404);
     }

    // include pages...
     include $page;
?>