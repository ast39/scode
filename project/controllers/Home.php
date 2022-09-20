<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 22.07.2019
 * Time: 15:33
 */

namespace controllers;

use core\Controller;


class Home extends Controller {

    public function __construct()
    {
        //$this->auth = true;

        parent::__construct();
    }

    public function index()
    {
        if (Storage::disk('public')->exists('test')) {
            Storage::disk('public')->delete('test');
        }

        Storage::disk('public')->put('test', json_encode(['name' => 'Alex S', 'age'=> 37]));
        Storage::disk('public')->append('test', json_encode(['name' => 'Alex M', 'age'=> 38]));

        $data = Storage::disk('public')->get('test')->fromJson();

        xmp($data);

        $this->loadTemplate('home');
    }
}