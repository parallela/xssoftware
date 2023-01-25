<?php

namespace App\Core;

class Validator
{
    /**
     * @param string $email
     * @return mixed
     */
    public static function validateEmail(string $email)
    {
       return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param $content
     * @return bool
     */
    public static function string($content): bool
    {
        return strlen($content) > 0 && is_string($content);
    }

    /**
     * @param $content
     * @param int $length
     * @return bool
     */
    public static function length($content, int $length): bool
    {
        return strlen($content) >= $length;
    }
}