<?php

namespace App\App\Helper;

class ApplicationHelper
{
    public static function randomString(int $length = 20): string
    {
        return substr(str_shuffle(
            '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'
        ),1,$length);
    }
}