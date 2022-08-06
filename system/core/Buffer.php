<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 22.07.2019
 * Time: 17:38
 */

namespace core;


class Buffer {

    private $buffer = [];
    
    private static $instance = null;

    private function __construct () {}

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    public function __set($name, $value)
    {
        $this->buffer[$name] = $value;
    }

    public function __get($name) 
    {
        return $this->buffer[$name] ?? null;
    }

    protected function __clone() {}
}
