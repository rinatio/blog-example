<?php

namespace app\component;

/**
 * Class ActiveRecord
 *
 * @package app\component
 */
abstract class ActiveRecord extends Object
{
    /**
     * @var \PDO
     */
    protected static $pdo;

    /**
     * Validation errors
     *
     * @var array
     */
    protected $errors = [];

    /**
     * @return \PDO
     */
    public static function pdo()
    {
        if(!isset(static::$pdo)) {
            static::$pdo = Front::instance()->getPDO();
        }
        return static::$pdo;
    }

    /**
     * Get table name. Default to class short name.
     * Override it in child class if needed
     *
     * @return string
     */
    public static function getTable()
    {
        return strtolower(static::getShortName());
    }

    /**
     * Create a model from raw attributes returned by DB request
     *
     * @param array $attributes
     * @return static
     */
    protected static function doCreateObject(array $attributes)
    {
        $obj = new static();
        foreach($attributes as $attr => $val) {
            $obj->$attr = $val;
        }
        return $obj;
    }

    /**
     * Set model safe attributes
     *
     * @param array $data
     * @param array $safe default to {@link getSafeAttributes()}
     * @see getSafeAttributes()
     */
    public function setAttributes(array $data, array $safe = null)
    {
        if(!isset($safe)) {
            $safe = $this->getSafeAttributes();
        }
        foreach($safe as $attr) {
            if(array_key_exists($attr, $data)) {
                $this->$attr = $data[$attr];
            }
        }
    }

    /**
     * Get model safe attributes. Default to empty array. Override it in child class
     * if needed.
     *
     * @return array
     */
    public function getSafeAttributes()
    {
        return [];
    }

    /**
     * Get validation errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Add validation error
     *
     * @param $msg
     */
    public function addError($msg)
    {
        $this->errors[] = $msg;
    }

    /**
     * Validate model attributes. Override it in child class if needed
     *
     * @return bool
     */
    public function validate()
    {
        return false;
    }

    /**
     * Save record into database
     *
     * @return bool true on success, false on failure
     */
    public function save()
    {
        if($this->getId()) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

    /**
     * Find all model records
     *
     * @return static[]
     */
    public static function findAll()
    {
        $table = static::getTable();
        $stmt = static::pdo()->prepare("select * from {$table}");
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $set = [];
        if(false !== $rows && !empty($rows)) {
            foreach($rows as $row) {
                $set[] = static::doCreateObject($row);
            }
        }
        return $set;
    }

    /**
     * Find all model records by specific attributes
     *
     * @param array $attributes
     * @return static[]
     */
    public static function findAllByAttributes(array $attributes)
    {
        list($where, $params) = static::attributesToWhere($attributes);
        $table = static::getTable();
        $stmt = static::pdo()->prepare("select * from {$table} where {$where}");
        $stmt->execute($params);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $set = [];
        if(false !== $rows && !empty($rows)) {
            foreach($rows as $row) {
                $set[] = static::doCreateObject($row);
            }
        }
        return $set;
    }

    /**
     * Find a particular model by specific attributes
     *
     * @param array $attributes
     * @return static|bool
     */
    public static function findByAttributes(array $attributes)
    {
        list($where, $params) = static::attributesToWhere($attributes);
        $table = static::getTable();
        $stmt = static::pdo()->prepare("select * from {$table} where {$where}");
        $stmt->execute($params);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(false !== $row) {
            return static::doCreateObject($row);
        }
        return false;
    }

    /**
     * Convert array of attributes to sql where
     *
     * @param array $attributes
     * @return array
     */
    protected static function attributesToWhere(array $attributes)
    {
        $data = [];
        foreach($attributes as $key => $val) {
            $data[$key] = [
                'name' => $key,
                'token' => ':' . $key,
                'value' => $val
            ];
        }
        $where = implode(' and ', array_map(function($attr) {
            return $attr['name']. ' = ' . $attr['token'];
        }, $data));
        $params = array_reduce($data, function(&$result , $attr) {
            $result[$attr['token']] = $attr['value'];
            return $result;
        }, []);
        return [$where, $params];
    }

    /**
     * Get Model ID
     *
     * @return mixed
     */
    public abstract function getId();

    /**
     * Implement sql insert here
     *
     * @return mixed
     */
    protected abstract function insert();

    /**
     * Implement sql update here
     *
     * @return mixed
     */
    protected abstract function update();
}
