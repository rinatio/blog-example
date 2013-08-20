<?php

namespace app\component;

/**
 * Class Request
 * Handle http request
 *
 * @package app\component
 */
class Request
{
    public $properties = [];

    public function __construct()
    {
        $this->properties = $_REQUEST;
    }

    public function getProperty($key)
    {
        if(array_key_exists($key, $this->properties)) {
            return $this->properties[$key];
        }
    }

    public function getPost($key)
    {
        if(array_key_exists($key, $_POST)) {
            return $_POST[$key];
        }
    }

    public function isPost()
    {
        return isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'],'POST');
    }
}
