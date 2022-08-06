<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 18.09.2019
 * Time: 15:31
 */

namespace admin_panel\controllers;


use core\Controller,
    core\SC;

class Errorlog extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->isRootAuth()) {
            $this->url::redirect(SITE . 'login');
        }
    }

    public function index()
    {
        $files = $logs = [];
        for ($i = 0; $i < 7; $i++) {
            $files[] = SC::separator(ROOT . 'tmp/' . 'sc_errors/' . date('Y-m-d', time() - (3600 * 24 * $i)) . '.sc');
        }

        foreach ($files as $k) {

            $_fname = explode(DIRECTORY_SEPARATOR, $k);
            $fname  = substr(end($_fname), 0, strpos(end($_fname), '.'));

            $logs[$fname] = $this->getDayLog($k);
        }

        $this->buffer->logs = $logs;

        $this->loadTemplate();
    }

    private function getDayLog($log_file)
    {
        $log = [];
        if (file_exists($log_file)) {

            $file_data = file($log_file);

            foreach ($file_data as $line_data) {
                $log[] = json_decode($line_data, true);
            }
        }

        return $log;
    }
}