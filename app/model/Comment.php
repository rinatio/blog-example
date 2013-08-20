<?php

namespace app\model;

use app\component\ActiveRecord;

/**
 * Class Comment
 * @package app\model
 */
class Comment extends ActiveRecord
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var int
     */
    protected $post_id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get default model safe attributes
     *
     * @return array
     */
    public function getSafeAttributes()
    {
        return ['name', 'text', 'post_id'];
    }

    /**
     * Validate model attributes
     *
     * @return bool
     */
    public function validate()
    {
        foreach(['text'] as $attr) {
            if(empty($this->$attr)) {
                $this->addError(ucwords($attr) . ' is required');
            }
        }
        return empty($this->errors);
    }

    /**
     * Insert new record
     *
     * @return bool true on success, false on failure
     */
    protected function insert()
    {
        $stmt = static::pdo()->prepare('insert into comment (name, text, post_id) value (:name, :text, :pId)');
        $success = $stmt->execute([
            ':name' => $this->name,
            ':text' => $this->text,
            ':pId' => $this->post_id
        ]);
        if($success) {
            $id = static::pdo()->lastInsertId();
            $this->id = $id;
            return true;
        }
        return false;
    }

    /**
     * Update a record
     *
     * @return mixed|void
     * @throws \Exception
     */
    protected function update()
    {
        throw new \Exception('WIP');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
