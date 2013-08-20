<?php

namespace app\component;

/**
 * Class View
 * @package app\component
 */
class View
{
    /**
     * Render php file
     * @param string $__file file to be rendered
     * @param array $__params an array of variables available in view
     * @return string output result
     */
    public function renderPhp($__file, array $__params = [])
    {
        ob_start();
        ob_implicit_flush(false);
        extract($__params);
        require($__file);
        return ob_get_clean();
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return Front::instance()->getSession();
    }
}
