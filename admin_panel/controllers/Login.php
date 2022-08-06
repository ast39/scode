<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 18.09.2019
 * Time: 13:58
 */

namespace admin_panel\controllers;


use core\Controller,
    core\SC,
    cfg\Settings,
    helper\Request;

class Login extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->isRootAuth() || $this->isAdminAuth()) {
            $this->url::redirect(SITE);
        }
    }

    public function index()
    {
        if (!LOCAL && (in_array(Settings::$admin_login, ['admin', 'root']) || !SC::strongPassword(Settings::$admin_password))) {
            $this->buffer->attention = $this->langLine('login_default_data');
        }

        if (!LOCAL && (in_array(Settings::$root_login, ['admin', 'root']) || !SC::strongPassword(Settings::$root_password))) {
            $this->buffer->attention = $this->langLine('login_default_data');
        }

        if (Request::issetAnyWhere('try_auth') != false) {

            $this->csrfCheck();

            $admin_login = Request::post('admin_login');
            $admin_pass  = Request::post('admin_pass');

            if (Settings::$admin_login == $admin_login && Settings::$admin_password == $admin_pass) {

                $this->authAdmin();
                $this->url::redirect(SITE);
            } elseif (Settings::$root_login == $admin_login && Settings::$root_password == $admin_pass) {
                
                $this->authRoot();
                $this->url::redirect(SITE);
            } else {

                $this->buffer->error = $this->langLine('login_wrong_data');
                SC::logSystemError('Failed admin auth [' . $admin_login . ']:[' . $admin_pass . ']');
            }
        }

        $this->loadTemplate();
    }
}