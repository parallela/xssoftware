<?php

namespace App\Models;

use App\Core\Validator;
use App\Interfaces\ModelInterface;
use App\Core\Database;

class Token implements ModelInterface
{
    protected Database $database;
    protected string $table = 'tokens';

    public function __construct()
    {
        $this->database = new Database();
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function destroy(array $attributes)
    {
        $columns = implode(',', array_keys($attributes));

        return $this->database->insert("DELETE FROM tokens WHERE user_id = ?", array_values($attributes));
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function create(array $attributes)
    {
        $columns = implode(',', array_keys($attributes));

        return $this->database->insert("INSERT INTO tokens ({$columns}) VALUES (?,?)", array_values($attributes));
    }

    /**
     * @param array $attribute
     * @return bool|array
     */
    public function fetchForAuthentication(array $attribute)
    {
        $column = array_key_first($attribute);
        $value = $attribute[$column];


        return $this->database->fetchOne("SELECT id,user_id,token FROM {$this->table} WHERE {$column}=?", [$value]);
    }


    /**
     * @param int $id
     * @return bool|array
     */
    public function findById(int $id)
    {
        return $this->database->fetchOne("SELECT * FROM {$this->table} WHERE id=?", [$id]);
    }

    /**
     * @return bool|array
     */
    public function fetchAll()
    {
        return $this->database->query("SELECT * FROM {$this->table} ", []);
    }
}
