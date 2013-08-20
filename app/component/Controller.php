<?php

namespace app\component;

use app\exception\HttpException;

/**
 * Class Controller
 *
 * Todo: allow defaults modification through config
 * @package app\component
 */
abstract class Controller extends Object
{
    /**
     * @var \app\component\View
     */
    private $view;

    /**
     * @var string directory containing view files
     */
    public $viewsDir = 'app/views';

    /**
     * @var string directory containing layout files
     */
    public $layoutDir = 'layouts';

    /**
     * @var string layout
     */
    public $layout = 'main';

    /**
     * @var string default action
     */
    public $defaultAction = 'index';

    /**
     * Run specific action
     *
     * @param $action
     * @throws \app\exception\HttpException
     */
    public function runAction($action)
    {
        if(!strlen($action)) {
            $action = $this->defaultAction;
        }
        $methodName = 'action' . ucwords($action);
        if (method_exists($this, $methodName)) {
            $this->$methodName();
        } else {
            throw new HttpException(404);
        }
    }

    /**
     * Render a file
     *
     * @param $view
     * @param array $params
     * @return string
     */
    public function render($view, array $params = [])
    {
        $file = $this->viewsDir . '/' . $this->getId() . '/' . $view . '.php';
        $content = $this->getView()->renderPhp($file, $params);
        if(isset($this->layout)) {
            $file = $this->getLayoutPath() . '/' . $this->layout . '.php';
            return $this->getView()->renderPhp($file, compact('content'));
        }
        return $content;
    }

    /**
     * Get ID of the controller
     * @return string
     */
    public function getId()
    {
        return strtolower(strstr($this->getShortName(), 'Controller', true));
    }

    /**
     * @return View
     */
    public function getView()
    {
        if(!isset($this->view)) {
            $this->view = new View();
        }
        return $this->view;
    }

    /**
     * @return string
     */
    public function getLayoutPath()
    {
        return $this->viewsDir . '/' . $this->layoutDir;
    }

    /**
     * Send redirect header and exit
     *
     * @param $path
     */
    public function redirect($path)
    {
        header('Location: ' . $path, true, 302);
        exit();
    }
}
