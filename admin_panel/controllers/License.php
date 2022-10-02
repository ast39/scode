<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 18.09.2019
 * Time: 15:09
 */

namespace admin_panel\controllers;

use system\core\Controller,
    cfg\Settings;


class License extends Controller {

    public function __construct()
    {
        parent::__construct();

        if (!$this->isAdminAuth() && !$this->isRootAuth()) {
            $this->url::redirect(SITE . 'login');
        }

    }

    public function index()
    {
        $lic_en
            = $lic_ru
            = [];

        $lic    = file(ROOT . 'License.txt');
        $mark   = 'en';

        foreach ($lic as $line) {

            if (strpos($line, '===RU===') !== false) {
                $mark = 'ru';

                continue;
            }

            $lic_name = 'lic_' . $mark;
            array_push($$lic_name, $line);
        }

        $this->buffer->license = Settings::$def_lang == 'ru'
            ? implode('<br />', $lic_ru)
            : implode('<br />', $lic_en);

        $this->loadTemplate();
    }
}