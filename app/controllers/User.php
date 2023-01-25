<?php

namespace App\Controllers;

use App\Core\Authentication;
use App\Models\User as UserModel;

class User
{
    protected UserModel $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function index()
    {
        $user = Authentication::user();


        // Check if admin
        authorize(function () use ($user) {
            return intval($user['admin']);
        });

        json($this->user->fetchAllInactive());
    }

    /**
     * Store the book
     */
    public function update()
    {
        $user = Authentication::user();
        $userId = http_param('id');

        // Check if admin
        authorize(function () use ($user, $userId) {
            return intval($user['admin']) && $userId;
        });

        $this->user->updateStatus($userId);

        json(['status' => 'success']);
    }
}