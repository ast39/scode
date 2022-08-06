<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 23.09.2019
 * Time: 12:40
 */

namespace admin_panel\controllers;


use core\Controller,
    core\SC;

class Visitlog extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->isAdminAuth() && !$this->isRootAuth()) {
            $this->url::redirect(SITE . 'login');
        }
    }

    public function index()
    {
        $files = $logs = [];
        for ($i = 0; $i < 7; $i++) {
            $files[] = SC::separator(ROOT . 'tmp/' . 'visits/' . date('Y-m-d', time() - (3600 * 24 * $i)) . '.sc');
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

            $i = 0;
            $pre_log = [];
            foreach ($file_data as $line_num => $line_data) {

                $firstDoublePontPos = strpos($line_data, ':');
                if ($firstDoublePontPos == false) {

                    $log[$i] = $pre_log;
                    $pre_log = [];
                    $i++;
                    continue;
                }

                $pre_log[substr($line_data, 0, $firstDoublePontPos)] = trim(substr($line_data, $firstDoublePontPos + 1));
            }
        }

        return $log;
    }
}