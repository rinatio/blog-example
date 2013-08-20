<?php

namespace app\component;

/**
 * Class Session
 * Wrapper for php sessions
 *
 * @package app\component
 */
class Session
{
    public function __construct()
    {
        session_start();
    }

    public function __get($value)
    {
        return isset($_SESSION[$value]) ? $_SESSION[$value] : null;
    }

    public function __set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function destroy()
    {
        session_unset();
        session_destroy();
    }
}
