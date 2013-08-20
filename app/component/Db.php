<?php

namespace app\component;

/**
 * Class Db
 * Manage database connection etc
 *
 * @package app\component
 */
class Db
{
    /**
     * @var array database config
     */
    protected $config = [];

    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @param array $config database config
     * @throws \LogicException if config is invalid
     */
    public function __construct(array $config)
    {
        foreach(['dsn', 'username', 'password'] as $attr) {
            if(!array_key_exists($attr, $config)) {
                throw new \LogicException('Invalid Db config');
            }
        }
        $this->config = $config;
    }

    /**
     * Get PDO object
     * @return \PDO
     */
    public function getPDO()
    {
        if(!isset($this->pdo)) {
            $dsn = $this->config['dsn'];
            $user = $this->config['username'];
            $pass = $this->config['password'];
            $pdo = new \PDO($dsn, $user, $pass);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }
}
