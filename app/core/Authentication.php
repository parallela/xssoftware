<?php

namespace App\Core;

use App\Models\Token;
use App\Models\User;
use DateTimeImmutable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Authentication
{

    /**
     * @param array $user
     * @return array
     */
    public static function proceed(array $user): array
    {
        $date = new DateTimeImmutable();

        $authConfig = (require BASE_PATH.'/app/config.php')['auth'];

        $payload = [
            'iss' => $_SERVER['REMOTE_ADDR'], // Remote addr
            'iat' => $date->getTimestamp(), // Issued at timestamp
            'nbf' => $date->getTimestamp(), // Not before timestamp (set now for instant login)
            'exp' => $date->modify('+8 hours')->getTimestamp(), // jwt exp date
            'context' => [
                'user' => [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'admin' => $user['admin']
                ]
            ]
        ];

        $jwtToken = JWT::encode($payload, $authConfig['secret_key'], 'HS512');

        (new Token)->create([
            'token' => $jwtToken,
            'user_id' => intval($user['id'])
        ]);

        return [
            'access_token' => $jwtToken,
            'context' => $payload['context']
        ];
    }

    /**
     * @return mixed
     */
    public static function getToken()
    {
        preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $bearerToken);

        return $bearerToken[1];
    }

    /**
     * @return \stdClass
     */
    public static function validate(): \stdClass
    {
        $authConfig = (require BASE_PATH.'/app/config.php')['auth'];

        if(!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            json(['error' => 'Unauthorized'], 401);
        }

        preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $bearerToken);

        $tokenFromDb = (new Token)->fetchForAuthentication([
            'token' => $bearerToken[1]
        ]);

        if(!$tokenFromDb) {
            json(['error' => 'Unauthorized'], 401);
        }

        $token = JWT::decode($tokenFromDb['token'], new Key($authConfig['secret_key'], 'HS512'));
        $now = new DateTimeImmutable();

        if ($token->iss !== $_SERVER['REMOTE_ADDR'] ||
            $token->nbf > $now->getTimestamp() ||
            $token->exp < $now->getTimestamp())
        {
            json(['error' => 'Unauthorized'], 401);
        }


        return $token;
    }

    /**
     * @return array|bool
     */
    public static function user()
    {
        if(!$token = Authentication::validate()) {
            json(['error' => 'Unauthorized'], 401);
        }

        $authUserContext = $token->context->user ?? null;

        if(!$authUserContext) {
            json(['error' => 'Unauthorized'], 401);
        }

        // Get the user by jwt
        return (new User())->findById($token->context->user->id);
    }
}