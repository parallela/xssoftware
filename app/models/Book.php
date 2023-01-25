<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Validator;
use App\Interfaces\ModelInterface;

class Book implements ModelInterface
{
    protected Database $database;
    protected string $table = 'books';

    public function __construct()
    {
        $this->database = new Database();
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
        return $this->database->query("SELECT * FROM {$this->table}", []);
    }

    /**
     * @param $userId
     * @param $bookId
     * @return array|false
     */
    public function deleteCollection($userId, $bookId)
    {
        return $this->database->query('DELETE FROM books_users WHERE user_id = ? AND book_id = ?', [$userId, $bookId]);
    }

    /**
     * @param $userId
     * @return array|false
     */
    public function fetchUserCollection($userId)
    {
        return $this->database->query("SELECT books.* FROM books JOIN books_users ON books.id = books_users.book_id WHERE books_users.user_id = ?", [$userId]);
    }

    /**
     * Validate database inputs.
     * @return false|string[]
     */
    public static function validateInputs()
    {
        if(!Validator::string(input('name')) || !Validator::string(input('isbn'))) {
            return ['error' => 'Invalid data'];
        }

        if(!Validator::length(input('name'), 3)) {
            return ['error' => 'The name must be  with 3 characters length.'];
        }

        return false;
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $isbn
     * @return bool
     */
    public function updateById(int $id, string $name, string $isbn)
    {
        return $this->database->query("UPDATE {$this->table} SET name = ?, isbn = ? WHERE id = ?", [$name, $isbn, $id]);
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function create(array $attributes)
    {
        $columns = implode(',', array_keys($attributes));

        return $this->database->insert("INSERT INTO books ({$columns}) VALUES (?,?)", array_values($attributes));
    }


    /**
     * @param int $userId
     * @param int $bookId
     * @return bool
     */
    public function collect(int $userId, int $bookId)
    {
        return $this->database->insert("INSERT INTO books_users (book_id,user_id) VALUES (?,?)", [$bookId, $userId]);
    }
}