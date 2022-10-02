<?php

/*
+----------------------------------------------------------------------------------------------------
| Access control
+----------------------------------------------------------------------------------------------------
*/
if ( ! defined('VERSION')) exit('Not access');

/*
+----------------------------------------------------------------------------------------------------
| Used libraries
+----------------------------------------------------------------------------------------------------
*/
use system\core\{SC, Route, Benchmark};
use system\helper\Session;
use cfg\Settings;

/*
+----------------------------------------------------------------------------------------------------
| Start time mark
+----------------------------------------------------------------------------------------------------
*/
Benchmark::getInstance()->addMark('_work_start_');

/*
+----------------------------------------------------------------------------------------------------
| Session start
+----------------------------------------------------------------------------------------------------
*/
if (!session_id()) {
    ini_set('session.save_path', $_SERVER['DOCUMENT_ROOT'] . '/' . Settings::$site_dir .'storage/framework/session');

    session_set_cookie_params(Settings::$session_set_cookie_params);
    ini_set('session.cookie_lifetime', Settings::$session_set_cookie_params);
    ini_set('session.gc_maxlifetime', Settings::$session_set_cookie_params);

    session_start();
}

/*
+----------------------------------------------------------------------------------------------------
| Framework inside sSession
+----------------------------------------------------------------------------------------------------
*/
if (!isset($_SESSION[Settings::$session_array])) {
    $_SESSION[Settings::$session_array] = [];
}

/*
+----------------------------------------------------------------------------------------------------
| Session life time control
+----------------------------------------------------------------------------------------------------
*/
if (Session::get('lastActivity', true)) {
    $delay = time() - Session::get('lastActivity', true);

    if ($delay >= Settings::$session_set_cookie_params) {

        session_destroy();
        Route::redirect(Route::siteRoot(), 301);
    }
}

/*
+----------------------------------------------------------------------------------------------------
| Database config
+----------------------------------------------------------------------------------------------------
*/
if (file_exists(__DIR__ . '/../vendor/illuminate/database/Capsule/Manager.php')) {
    require_once ROOT . 'cfg/db.php';
}

/*
+----------------------------------------------------------------------------------------------------
| Error display settings
+----------------------------------------------------------------------------------------------------
*/
if (PROD) {

    error_reporting(0);
    ini_set('display_errors', false);
} else {

    error_reporting(E_ALL);
    ini_set('display_errors', true);
}

/*
+----------------------------------------------------------------------------------------------------
| Locale settings
+----------------------------------------------------------------------------------------------------
*/
setlocale(LC_ALL, "en_US.UTF-8", "English");
date_default_timezone_set("Europe/Helsinki");

/*
+----------------------------------------------------------------------------------------------------
| Charset settings
+----------------------------------------------------------------------------------------------------
*/
header('Content-type: text/html; charset=' . Settings::$charset);

/*
+----------------------------------------------------------------------------------------------------
| Check for admin path
+----------------------------------------------------------------------------------------------------
*/
if (Route::adminFolder()) {
    define('ADMIN', true);
}

/*
+----------------------------------------------------------------------------------------------------
| General route parts
+----------------------------------------------------------------------------------------------------
*/
$prefix          = '';
$page_class      = Route::pageController();
$page_method     = Route::pageMethod();
$page_parameters = Route::pageParameters();
define('LANG', strtolower(Route::pageLang()));

/*
+----------------------------------------------------------------------------------------------------
| General route constants
+----------------------------------------------------------------------------------------------------
*/
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

/*
+----------------------------------------------------------------------------------------------------
| Msg type constants
+----------------------------------------------------------------------------------------------------
*/
const MSG_DEFAULT = 0;
const MSG_SUCCESS = 1;
const MSG_WARNING = 2;
const MSG_ERROR   = 3;

/*
+----------------------------------------------------------------------------------------------------
| Site stop checking
+----------------------------------------------------------------------------------------------------
*/
if (Settings::$site_stop && !defined('ADMIN')) {
    include_once (ROOT . 'site_stop' . EXT);

    die;
}

/*
+----------------------------------------------------------------------------------------------------
| Visit log
+----------------------------------------------------------------------------------------------------
*/
if (!defined('ADMIN') && $page_class != 'i') {
    SC::logVisit();
}

/*
+----------------------------------------------------------------------------------------------------
| Route rules
+----------------------------------------------------------------------------------------------------
*/
$route_cfg = include_once __DIR__ . '/../cfg/routing.php';
if (($route = Route::findRouteRule($route_cfg)) !== NULL && !defined('ADMIN')) {

    $page_class      = $route['class'];
    $page_method     = $route['method'];
    $page_parameters = $route['parameters'];
}


/*
+----------------------------------------------------------------------------------------------------
| Find target class controller
+----------------------------------------------------------------------------------------------------
*/
$namespace_class = defined('ADMIN')
    ? "\\admin_panel\\controllers\\" . ucfirst($page_class)
    : "\\controllers\\" . ucfirst($page_class);

Benchmark::getInstance()->addMark('_class_checker_');

/*
+----------------------------------------------------------------------------------------------------
| If controller not found, then 404
+----------------------------------------------------------------------------------------------------
*/
if (!class_exists($namespace_class)) {
    noController($page_class);
}

define('PAGE', strtolower($page_class));

/*
+----------------------------------------------------------------------------------------------------
| If controller isset, call it
+----------------------------------------------------------------------------------------------------
*/
$page = new $namespace_class();

/*
+----------------------------------------------------------------------------------------------------
| If method not found, then 404
+----------------------------------------------------------------------------------------------------
*/
if (!method_exists($page, $page_method)) {
    noMethod($page_method);
}

define('PAGE_METHOD', strtolower($page_method));
define('PAGE_QUERY', $page_parameters);
define('SITE_QUERY', Route::fullUrl());

Benchmark::getInstance()->addMark('_init_route_page_class_');

/*
+----------------------------------------------------------------------------------------------------
| If method isset, call it
+----------------------------------------------------------------------------------------------------
*/
ob_start();
if ($page_parameters == null) {
    $page->$page_method();
} else {
    call_user_func_array([$page, $page_method], $page_parameters);
}

echo ob_get_clean();

/*
+----------------------------------------------------------------------------------------------------
| Loading time mark
+----------------------------------------------------------------------------------------------------
*/
Benchmark::getInstance()->addMark('_work_end_');

/*
+----------------------------------------------------------------------------------------------------
| Debug info
+----------------------------------------------------------------------------------------------------
*/
if (Settings::$debug === true) {

    echo '<hr /><b>Site was loaded by</b> ' . Benchmark::getInstance()->elapsedTime()
        . ' seconds<hr /><b>Memory used</b> ' . Benchmark::getInstance()->memoryUse() . ' MB<hr />';

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
