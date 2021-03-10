<?php
// включим отображение всех ошибок
error_reporting (E_ALL); 
// подключаем конфиг
if (is_file('config.php')) {
	require_once('config.php');
}

require_once('library/registry.php');
require_once('library/db.php');
require_once('library/Twig/Autoloader.php');
require_once('library/pagination.php');

// Соединяемся с БД
$registry = new Registry();
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

// подключаем ядро сайта
include (SITE_PATH . DS . 'core' . DS . 'core.php');

session_start();

// Загружаем router
$router = new Router($registry);
// записываем данные в реестр
$registry->set ('router', $router);
// задаем путь до папки контроллеров.
$router->setPath (SITE_PATH . DS . 'controllers');
// запускаем маршрутизатор
$router->start();