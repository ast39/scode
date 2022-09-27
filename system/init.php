<?php

# запрет прямого обращения к файлу
if ( ! defined('VERSION')) exit('Not access');

# используемые библиотеки
use system\core\{SC, Route, Benchmark};
use system\helper\Session;
use cfg\Settings;

# ставим метку начала работы движка
Benchmark::getInstance()->addMark('_work_start_');

# настраиваем сессию
if (!session_id()) {
    ini_set('session.save_path', $_SERVER['DOCUMENT_ROOT'] .'/storage/framework/session');

    session_set_cookie_params(Settings::$session_set_cookie_params);
    ini_set('session.cookie_lifetime', Settings::$session_set_cookie_params);
    ini_set('session.gc_maxlifetime', Settings::$session_set_cookie_params);

    session_start();
}

# создаем скрытую сессию внутри движка
if (!isset($_SESSION[Settings::$session_array])) {
    $_SESSION[Settings::$session_array] = [];
}

# контроль сессионной куки
if (Session::get('lastActivity', true)) {
    $delay = time() - Session::get('lastActivity', true);

    if ($delay >= Settings::$session_set_cookie_params) {
        session_destroy();
        Route::redirect(Route::siteRoot(), 301);
    }
}

# подключение конфига БД
if (file_exists(__DIR__ . '/../vendor/illuminate/database/Capsule/Manager.php')) {
    require_once ROOT . 'cfg/db.php';
}

# настройка показа ошибок
if (PROD) {
    error_reporting(0);
    ini_set('display_errors', false);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', true);
}

# установка локали
setlocale(LC_ALL, "en_US.UTF-8", "English");
date_default_timezone_set("Europe/Helsinki");

# обьявляем кодировку
header('Content-type: text/html; charset=' . Settings::$charset);

# если это админка
if (Route::adminFolder()) {
    define('ADMIN', true);
}

# определяем основные элементы адреса страницы
$prefix          = '';
$page_class      = Route::pageController();
$page_method     = Route::pageMethod();
$page_parameters = Route::pageParameters();
define('LANG', strtolower(Route::pageLang()));

# определяем пути для дальнейшей работы
define('PROJECT_URL', Route::siteRoot());
define('SITE',
    defined('ADMIN')
        ? Route::siteRoot() . Settings::$admin_partition
        : Route::siteRoot());
define('SITE_FOR_STATIC', Route::siteRootForStatic());
define('SITE_IMG', str_replace(Settings::$admin_partition, '', SITE_FOR_STATIC) . 'i/img/');
define('SITE_CSS', str_replace(Settings::$admin_partition, '', SITE_FOR_STATIC) . 'i/css/');
define('SITE_JS',  str_replace(Settings::$admin_partition, '', SITE_FOR_STATIC) . 'i/js/');
define('AUTH_PROJECT', SC::isUserAuth());

# константы для сообщений
const MSG_DEFAULT = 0;
const MSG_SUCCESS = 1;
const MSG_WARNING = 2;
const MSG_ERROR   = 3;

# если есть флаг модерации сайта, то останавливаем движок и информируем пользователей ( файл sitestop.php )
if (Settings::$site_stop == true && !defined('ADMIN')) {
    include_once (ROOT . 'site_stop' . EXT);
    die;
}

# логирование посещения
if (!defined('ADMIN') && $page_class != 'i') {
    SC::logVisit();
}

$route_cfg = include_once __DIR__ . '/../cfg/routing.php';

if (($route = Route::findRouteRule($route_cfg)) !== NULL && !defined('ADMIN')) {

    $page_class      = $route['class'];
    $page_method     = $route['method'];
    $page_parameters = $route['parameters'];
}


# определение пути к файлу, который надо вызвать для данного URL
$namespace_class = defined('ADMIN')
    ? "\\admin_panel\\controllers\\" . ucfirst($page_class)
    : "\\controllers\\" . ucfirst($page_class);

Benchmark::getInstance()->addMark('_class_checker_');

# если нет такого файла, то 404 ошибка
if (!class_exists($namespace_class)) {
    noController($page_class);
}

define('PAGE', strtolower($page_class));

# если файл есть, то обьявляем класс страницы
$page = new $namespace_class();

# если искомого метода нет в классе, то 404 ошибка
if (!method_exists($page, $page_method)) {
    noMethod($page_method);
}

define('PAGE_METHOD', strtolower($page_method));
define('PAGE_QUERY', $page_parameters);
define('SITE_QUERY', Route::fullUrl());

Benchmark::getInstance()->addMark('_init_route_page_class_');

# если искомый метод есть, то вызываем его (с параметрами, если таковые переданы)
ob_start();
if ($page_parameters == null) {
    $page->$page_method();
} else {
    call_user_func_array([$page, $page_method], $page_parameters);
}

echo ob_get_clean();

# ставим метку окончания работы движка
Benchmark::getInstance()->addMark('_work_end_');

function noController($page_class)
{
    if  (!in_array($page_class,  ['i']) && stripos($page_class, 'apple-touch-icon') === false) {
        SC::logSystemError('Controller not found: ' . $page_class);
    }

    SC::goTo404();
}

function noMethod($page_method)
{
    SC::logSystemError('Method not found: ' . $page_method);
    SC::goTo404();
}

if (isset($_GET['debug'])) {
    echo '<hr />';
    echo '<b>Site was loaded by</b> ' . Benchmark::getInstance()->elapsedTime() . ' seconds';
    echo '<hr />';
    echo '<b>Memory used</b> ' . Benchmark::getInstance()->memoryUse() . ' MB';
    echo '<hr />';
    if (isset($_GET['marks'])) {
        $marks = Benchmark::getInstance()->calcAndGet();
        ob_start();?>
        <table width="100%" border="1" cellpadding="6" cellspacing="2">
            <tr>
                <th>Mark</th>
                <th>Load time</th>
                <th>Total load</th>
                <th>Total memory</th>
            </tr>
            <?php foreach ($marks as $k => $v): ?>
                <tr>
                    <td><?= $k ?></td>
                    <td><?= number_format($v['load_mark'], 3) ?> sec.</td>
                    <td><?= number_format($v['load_total'], 3) ?> sec.</td>
                    <td><?= number_format($v['memory'], 2) ?> MB</td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?= ob_get_clean();
        echo '<hr />';
    }
}
