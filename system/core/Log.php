<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 22.07.2019
 * Time: 19:28
 */

namespace core;


use cfg\Settings;

class Log
{
    private $log_buffer = [];

    private static $instance = null;

    private function __construct () {}

    public static function getInstance()
    {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function cleanLog($name)
    {
        if (isset($this->log_buffer[$name])) {
            $this->log_buffer[$name] = '';
        }
    }

    public function appendLog($name, $data)
    {
        isset ($this->log_buffer[$name])
            ? $this->log_buffer[$name] .= $data
            : $this->log_buffer[$name]  = $data;
    }

    public function showLog($name)
    {
        return $this->log_buffer[$name] ?? null;
    }

    public function saveLog($name, $file, $clean_file = false)
    {
        if (isset($this->log_buffer[$name])) {
            
            $log_dir = Settings::$log_dir;
            $way_to_log = str_ireplace(['/', '//', '\\', '\\\\'], DIRECTORY_SEPARATOR, $log_dir . DIRECTORY_SEPARATOR . $file);
            
            $clean_file == true
                ? file_put_contents($way_to_log, $this->log_buffer[$name])
                : file_put_contents($way_to_log, $this->log_buffer[$name], FILE_APPEND);
        }
    }

    protected function __clone() {}
}