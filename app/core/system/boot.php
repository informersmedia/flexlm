<?php // use boot classes
    class Boot { 
      public static function loader ($class) {
          $class = '/var/www/html/classes/' . strtolower($class) . '.php'; 
          include $class;
      }
    }
    spl_autoload_register(
      [
        'Boot', 
        'loader'
      ]
    );
?>