<?php

namespace App\Libraries;

class Helper
{
    /**
     * simple page redirect
     * @param $page
     */
    public function redirect($page)
    {
        header('location: ' . $page);
    }
}
