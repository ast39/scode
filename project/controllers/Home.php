<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 22.07.2019
 * Time: 15:33
 */


namespace controllers;

use modules\storage\Storage;
use system\core\Controller;
use system\core\Log;


class Home extends Controller {

    public function __construct()
    {
        //$this->auth = true;

        parent::__construct();
    }

    public function index()
    {
        $this->loadTemplate();
    }
}