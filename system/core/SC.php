<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 23.09.2019
 * Time: 13:00
 */

namespace core;


use cfg\Settings,
    helper\Session;
use modules\storage\Storage;

class SC {

    public static function goTo404()
    {
        header("HTTP/1.1 404 Not Found");
        include_once ROOT . '404.php';
        exit;
    }

    public static function langLine($name, $file = false, $global = false)
    {
        # Для начала получим резервный вариант для дефолтного языка
        # Путь до файла с текстом для дефолтного языка
        $namespace_lang_def = defined('ADMIN') && $global == false
            ? "\\admin_panel\\langs\\" . strtolower(Settings::$def_lang) . '\\' . ucfirst($file ?: 'main')
            : "\\project\\langs\\" . strtolower(Settings::$def_lang) . '\\' . ucfirst($file ?: 'main');

        $lang_class_def = $namespace_lang_def::getInstance();
        $result_def     = property_exists($lang_class_def, $name)
            ? $lang_class_def->$name
            : null;

        # Теперь попробуем получить вариант для текущего языка
        # Путь до файла с текстом исходя из выбранного языка
        $namespace_lang = defined('ADMIN') && $global == false
            ? "\\admin_panel\\langs\\" . strtolower(LANG) . '\\' . ucfirst($file ?: 'main')
            : "\\project\\langs\\" . strtolower(LANG) . '\\' . ucfirst($file ?: 'main');

        $lang_class = $namespace_lang::getInstance();
        $result     = property_exists($lang_class, $name)
            ? $lang_class->$name
            : null;

        return $result ?: ($result_def ?: '');
    }

    public static function isUserAuth()
    {
        return (bool)Session::get(Settings::$user_auth_mark);
    }

    public static function logSystemError($e, $type = 'custom')
    {
        if (Settings::$log_errors === true) {

            $log = json_encode([
                'type'  => $type,
                'time'  => date('H:i:s', time()),
                'ip'    => static::getIp(),
                'msg'   => $e->getMessage(),
                'code'  => $e->getCode(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTrace(),
            ]);

            $file = date('Y-m-d', time());
            if (Storage::disk('logs')->exists($file)) {
                Storage::disk('logs')->append($file, PHP_EOL . $log);
            } else {
                Storage::disk('logs')->put($file, $log);
            }
        }
}

    public static function logVisit()
    {
        if (Settings::$log_visits === true) {
            $indexing = new SiteIndexing();

            $log = 'Time: ' . date('H:i:s', time()) . PHP_EOL
                . 'Visitor: ' . $indexing->detectGuest() . PHP_EOL
                . 'Analyzer: ' . $indexing->detectAnalyzer() . PHP_EOL
                . 'SearchBot: ' . $indexing->detectSearchBot() . PHP_EOL
                . 'Device: ' . $indexing->detectDevice() . PHP_EOL
                . 'Browser: ' . $indexing->detectBrowser() . PHP_EOL
                . 'OS: ' . $indexing->detectOS() . PHP_EOL
                . 'Ip: ' . static::getIp() . PHP_EOL
                . 'User: ' . ($_SERVER['HTTP_USER_AGENT'] ?: '-') . PHP_EOL
                . 'Url: ' . Route::fullUrl()
                . PHP_EOL . PHP_EOL;

            $file = date('Y-m-d', time());
            if (Storage::disk('visits')->exists($file)) {
                Storage::disk('visits')->append($file, PHP_EOL . $log);
            } else {
                Storage::disk('visits')->put($file, $log);
            }
        }
    }

    public static function strongPassword($password)
    {
        if (!preg_match('~[a-z]+~', $password)) {
            return false;
        }

        if (!preg_match('~[A-Z]+~', $password)) {
            return false;
        }

        if (!preg_match('~[0-9]+~', $password)) {
            return false;
        }

        return strlen($password) >= 8;
    }

    public static function createUuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public static function getIp($port = false)
    {
        if(isset($HTTP_SERVER_VARS)) {

            if(isset($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])) {
                $realip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
            } else if(isset($HTTP_SERVER_VARS["HTTP_CLIENT_IP"])) {
                $realip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
            } else {
                $realip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
            }
        } else {

            if(getenv('HTTP_X_FORWARDED_FOR')) {
                $realip = getenv('HTTP_X_FORWARDED_FOR' );
            } else if( getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }

        if  ($port == true) {

            if((getenv('REMOTE_PORT'))) {
                $realip.=":".getenv('REMOTE_PORT');
            }
        }

        return $realip;
    }

    public static function separator($data, $separator = false)
    {
        $separator = $separator == false
            ? DIRECTORY_SEPARATOR
            : $separator;

        return str_ireplace(['/', '//', '\\', '\\\\'], $separator, $data);
    }
}