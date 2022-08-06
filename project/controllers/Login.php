<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 22.07.2019
 * Time: 15:33
 */

namespace controllers;

use core\Controller;


class Login extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->loadTemplate();
    }

    public function auth()
    {
        die('POST request detected');
    }
}