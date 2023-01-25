<?php

namespace App\Models;

use App\Core\Validator;
use App\Interfaces\ModelInterface;
use App\Core\Database;

class User implements ModelInterface
{
    protected Database $database;
    protected string $table = 'users';

    public const ACTIVE = 1;
    public const INACTIVE = 0;

    public function __construct()
    {
        $this->database = new Database();
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function create(array $attributes)
    {
        $columns = implode(',', array_keys($attributes));

        return $this->database->insert("INSERT INTO users ({$columns}) VALUES (?,?,?,?,?)", array_values($attributes));
    }

    /**
     * @param array $attribute
     * @return bool|array
     */
    public function fetchForAuthentication(array $attribute)
    {
        $column = array_key_first($attribute);
        $value = $attribute[$column];

        return $this->database->fetchOne("SELECT id,email,password,admin FROM {$this->table} WHERE {$column}=? AND active=?", [$value, User::ACTIVE]);
    }


    /**
     * @param int $id
     * @return bool|array
     */
    public function findById(int $id)
    {
       return $this->database->fetchOne("SELECT id,name,email,admin,active FROM {$this->table} WHERE id=?", [$id]);
    }

    /**
     * @return bool|array
     */
    public function fetchAll()
    {
        return $this->database->query("SELECT id,name,email,admin,active FROM {$this->table} ", []);
    }

    /**
     * @return bool|array
     */
    public function fetchAllInactive()
    {
        return $this->database->query("SELECT id,name,email FROM {$this->table} WHERE active=?", [User::INACTIVE]);
    }

    /**
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function updateStatus(int $id)
    {
        return $this->database->query("UPDATE {$this->table} SET active = ? WHERE id = ?", [User::ACTIVE, $id]);
    }

    /**
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function updateById(int $id, string $name, string $email, string $password)
    {
        return $this->database->query("UPDATE {$this->table} SET name = ?, email = ?, password = ? WHERE id = ?", [$name, $email, $password, $id]);
    }

    /**
     * Validate database inputs.
     * @return false|string[]
     */
    public static function validateInputs()
    {
        if(!Validator::validateEmail(input('email'))) {
            return ['error' => 'Invalid email'];
        }

        if(!Validator::string(input('first_name')) || !Validator::string(input('last_name'))) {
            return ['error' => 'Invalid first or last name'];
        }

        if(!Validator::length(input('password'), 8)) {
            return ['error' => 'The password must be  with 8 characters length.'];
        }

        return false;
    }
}