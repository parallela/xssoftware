<?php

namespace App\Controllers;

use App\Core\Authentication;
use App\Models\Book as BookModel;

class Book
{
    protected BookModel $book;

    public function __construct()
    {
        $this->book = new BookModel();
    }

    public function index()
    {
        json($this->book->fetchAll());
    }

    public function show()
    {
        $user = Authentication::user();
        $bookId = http_param('id');


        // Check if admin
        authorize(function () use ($user, $bookId){
            return intval($user['admin']) && $bookId;
        });

        json($this->book->findById($bookId));
    }

    /**
     * Store the book
     */
    public function store()
    {
        $user = Authentication::user();

        // Check if admin
        authorize(function () use ($user){
            return intval($user['admin']);
        });

        if($validator = BookModel::validateInputs()) {
            json($validator, 422);
        }

        $this->book->create([
            'name' => input('name'),
            'isbn' => input('isbn')
        ]);

        json(['status' => 'success']);
    }

    /**
     * Store the book
     */
    public function update()
    {
        $user = Authentication::user();
        $bookId = http_param('id');


        // Check if admin
        authorize(function () use ($user, $bookId){
            return intval($user['admin']) && $bookId;
        });

        if($validator = BookModel::validateInputs()) {
            json($validator, 422);
        }

        $this->book->updateById($bookId,
            input('name'),
            input('isbn')
        );

        json(['status' => 'success']);
    }

    public function collect()
    {
        $user = Authentication::user();
        $bookId = http_param('id');


        // Check if admin
        authorize(function () use ($bookId){
            return $bookId;
        });

        $this->book->collect($user['id'], $bookId);

        json(['status' => 'success']);
    }

    /**
     * Get all user collection
     */
    public function userCollection()
    {
        $user = Authentication::user();

        json($this->book->fetchUserCollection($user['id']));
    }

    /**
     * Get all user collection
     */
    public function collectDelete()
    {
        $bookId = http_param('id');

        // Check if admin
        authorize(function () use ($bookId){
            return $bookId;
        });

        $user = Authentication::user();

        $this->book->deleteCollection($user['id'], $bookId);

        json(['status' => 'success']);
    }
}