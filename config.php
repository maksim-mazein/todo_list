<?php
// Задаем константы:
define('DS', DIRECTORY_SEPARATOR);
define('SITE_PATH', '/var/www/mazein/data/www/todo.mazein.ru/');
define('DIR_TEMPLATE', '/var/www/mazein/data/www/todo.mazein.ru/views');
define('DIR_CACHE', '/var/www/mazein/data/www/todo.mazein.ru/cache_twig');

define('HTTP_SERVER', 'http://todo.mazein.ru/');
define('TIMEZONE', '5');

// для подключения к бд
define('DB_DRIVER', 'mysqli');
define('DB_USERNAME', 'mazein');
define('DB_PASSWORD', 'ppppppppp');
define('DB_HOSTNAME', 'localhost');
define('DB_DATABASE', 'todo');
define('DB_PORT', '3306');
define('DB_PREFIX', '');