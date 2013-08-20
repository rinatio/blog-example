<?php

namespace app\component;

/**
 * Class UrlResolver
 *
 * Todo: allow defaults modification through config
 * Todo: allow path url format like "/post/view?id=1"
 * @package app\component
 */
class UrlResolver
{
    /**
     * Default query variable for route
     * @var string
     */
    public $routeVar = 'r';

    /**
     * A route controller name
     * @var string
     */
    public $controller = 'default';

    /**
     * A route action name
     * @var
     */
    public $action;

    /**
     * Parse request
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $cmd = $request->getProperty($this->routeVar);
        if($cmd) {
            $parts = explode('/', $cmd);
            $this->controller = $parts[0];
            if (isset($parts[1])) {
                $this->action = $parts[1];
            }
        }
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }
}
