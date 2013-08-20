<?php

namespace app\model;

use app\component\ActiveRecord;

/**
 * Class Post
 *
 * Todo: add lazy loading for comments and user
 * @package app\model
 */
class Post extends ActiveRecord
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var int
     */
    protected $user_id;

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
        return ['title', 'text'];
    }

    /**
     * Validate model attributes
     *
     * @return bool
     */
    public function validate()
    {
        foreach(['title', 'text'] as $attr) {
            if(empty($this->$attr)) {
                $this->addError(ucwords($attr) . ' is required');
            }
        }
        return empty($this->errors);
    }

    /**
     * Insert new record
     *
     * @return bool
     */
    protected function insert()
    {
        $stmt = static::pdo()->prepare('insert into post (title, text, user_id) value (:title, :text, :uId)');
        $success = $stmt->execute([
            ':title' => $this->title,
            ':text' => $this->text,
            ':uId' => $this->user_id
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
     * @param $id
     */
    public function setUserId($id)
    {
        $this->user_id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
