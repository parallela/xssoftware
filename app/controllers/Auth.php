<?php

namespace App\Controllers;

use App\Core\Authentication;
use App\Models\Token;
use App\Models\User;

class Auth
{
    /**
     * @var User
     */
    protected User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function processRegister()
    {
        if ($validator = User::validateInputs()) {
            json($validator, 422);
        }

        $user = $this->user->create([
            'name' => sprintf("%s %s", input('first_name'), input('last_name')),
            'email' => input('email'),
            'password' => password_hash(input('password'), PASSWORD_BCRYPT),
            'active' => User::INACTIVE,
            'admin' => User::INACTIVE
        ]);

        if (!$user) {
            json(['error' => 'User is not created!'], 422);
        }

        json(['message' => 'User created successfully!']);
    }

    /**
     * Process login
     */
    public function processLogin()
    {
        $user = $this->user->fetchForAuthentication(['email' => input('email')]);

        if (!$user) {
            json(['error' => 'User not found!'], 401);
        }

        if (!password_verify(input('password'), $user['password'])) {
            json(['error' => 'Invalid password'], 401);
        }

        $authenticatedPayload = Authentication::proceed($user);

        json([
            'access_token' => $authenticatedPayload['access_token'],
            'user' => $authenticatedPayload['context']
        ]);
    }

    public function logout()
    {
        $authUser = Authentication::user();

        (new Token())->destroy([
            'user_id' => $authUser['id']
        ]);

        json(['status' => 'Logged out!']);
    }

    /**
     * Return the authenticated user
     */
    public function update()
    {
        $authUser = Authentication::user();

        $this->user->updateById($authUser['id'],
            sprintf("%s %s", input('first_name'), input('last_name')), input('email'), password_hash(input('password'),PASSWORD_BCRYPT)
        );

        json($this->user->findById($authUser['id']));
    }

    /**
     * Return the authenticated user
     */
    public function user()
    {
        $authUser = Authentication::user();

        if (!$authUser) {
            json(['error' => 'User not found!'], 404);
        }

        json($authUser);
    }
}

