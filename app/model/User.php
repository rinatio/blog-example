<?php

namespace app\model;

use app\component\ActiveRecord;

/**
 * Class User
 * @package app\model
 */
class User extends ActiveRecord
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
    protected $email;

    /**
     * @var string
     */
    protected $password;

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
        return ['name', 'email', 'password'];
    }

    /**
     * Validate user input
     *
     * @return bool
     */
    public function validate()
    {
        foreach(['name', 'email', 'password'] as $attr) {
            if(empty($this->$attr)) {
                $this->addError(ucwords($attr) . ' is required');
            }
        }
        if(empty($errors) && !empty($this->email)) {
            if(static::findByAttributes(['email' => $this->email])) {
                $this->addError('Email already taken');
            }
        }
        return empty($this->errors);
    }

    /**
     * Crypt password before save
     *
     * @return mixed
     */
    public function save()
    {
        if(!$this->getId()) {
            $this->password = crypt($this->password, $this->generateSalt());
        }
        return parent::save();
    }

    /**
     * Generate Blowfish salt
     *
     * Todo: use mcrypt_create_iv()
     * @return string
     */
    protected function generateSalt()
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        $max = strlen($chars) - 1;
        $length = 22;
        while($length--) {
            $str .= $chars[mt_rand(0, $max)];
        }
        return '$2a$08' . $str;
    }

    /**
     * Insert record
     * @return bool true on success false, on failure
     */
    protected function insert()
    {
        $stmt = static::pdo()->prepare('insert into user (name, email, password) value (:name, :email, :password)');
        $success = $stmt->execute([
            ':name' => $this->name,
            ':email' => $this->email,
            ':password' => $this->password
        ]);
        if($success) {
            $id = static::pdo()->lastInsertId();
            $this->id = $id;
            return true;
        }
        return false;
    }

    /**
     * Todo: implement this
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
     * Check if password is valid
     * @param $password
     * @return bool
     */
    public function checkPassword($password)
    {
        return $this->password == crypt($password, $this->password);
    }
}
