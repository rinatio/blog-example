<?php

namespace app\component;

/**
 * Class Object
 * A class with helper methods
 *
 * @package app\component
 */
class Object
{
    public static function getShortName()
    {
        $function = new \ReflectionClass(get_called_class());
        return $function->getShortName();
    }
}
