<?php

namespace App\Libraries;

class Session
{
    public function __construct()
    {
    }

    public function get($index)
    {
        return $_SESSION[$index];
    }

    public function set($index, $value)
    {
        $_SESSION[$index] = $value;
    }
}
