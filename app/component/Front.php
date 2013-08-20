<?php

namespace app\component;

use \app\exception\HttpException;

/**
 * Class Front
 * Front Controller and Registry
 *
 * Todo: handle HttpException
 * @package app\component
 */
class Front
{
    /**
     * An instance of class itself.
     * @var Front
     */
    protected static $instance;

    /**
     * Namespace of the controller classes
     *
     * @var string
     */
    public $controllerNamespace = '\\app\\controller';

    /**
     * @var array
     */
    public $components = [];

    /**
     * Application config to be used for application components
     * @var array
     */
    protected $config = [];

    /**
     * Forbid new object creation
     */
    private function __construct() {}

    /**
     * @return Front
     */
    public static function instance()
    {
        if(!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * Run application
     *
     * @param array $config application config
     */
    public function run(array $config = [])
    {
        $this->config = $config;
        $this->handleRequest();
    }

    /**
     * Resolve controller and action to be run
     *
     * @throws \app\exception\HttpException
     */
    public function handleRequest()
    {
        $resolver = $this->getUrlResolver();
        $id = $resolver->getController();
        $class = $this->getControllerNamespace() . '\\' . $id . 'Controller';
        if(class_exists($class)) {
            $rfl = new \ReflectionClass($class);
            if($rfl->isSubclassOf('app\component\Controller')) {
                $controller = $rfl->newInstance();
                $controller->runAction($resolver->getAction());
                return;
            }
        }
        throw new HttpException();
    }

    public function getControllerNamespace()
    {
        if(array_key_exists('controllerNamespace', $this->config)) {
            return $this->config['controllerNamespace'];
        }
        throw new \LogicException('Please provide controller namespace in config');
    }

    /**
     * Get url resolver component
     *
     * @return UrlResolver
     */
    public function getUrlResolver()
    {
        if(!isset($this->components['cmdResolver'])) {
            $this->components['cmdResolver'] = new UrlResolver($this->getRequest());
        }
        return $this->components['cmdResolver'];
    }

    /**
     * Get request component
     *
     * @return Request
     */
    public function getRequest()
    {
        if(!isset($this->components['request'])) {
            $this->components['request'] = new Request();
        }
        return $this->components['request'];
    }

    /**
     * Get session component
     *
     * @return Session
     */
    public function getSession()
    {
        if(!isset($this->components['session'])) {
            $this->components['session'] = new Session();
        }
        return $this->components['session'];
    }

    /**
     * Get PDO
     *
     * @return \PDO
     */
    public function getPDO()
    {
        return $this->getDb()->getPDO();
    }

    /**
     * Get database object
     *
     * @return Db
     * @throws \LogicException
     */
    public function getDb()
    {
        if(!isset($this->components['db'])) {
            if(!isset($this->config['db'])) {
                throw new \LogicException('Please provide DB config');
            }
            $this->components['db'] = new Db($this->config['db']);
        }
        return $this->components['db'];
    }
}
