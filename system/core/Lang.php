<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 22.07.2019
 * Time: 18:22
 */

namespace core;


abstract class Lang
{
    private static $instances = [];

    private function __construct () {}

    public static function getInstance()
    {
        if (!isset(self::$instances[static::class])) {
            self::$instances[static::class] = new static();
        }

        return self::$instances[static::class];
    }

    public function __get($name)
    {
        return property_exists($this, $name)
            ? $this->$name
            : null;
    }
}