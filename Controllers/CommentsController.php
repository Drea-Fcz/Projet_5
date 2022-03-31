<?php

namespace App\Controllers;

use App\Core\Form;
use App\Libraries\Session;
use App\Libraries\SuperGlobal;
use App\Models\CommentsModel;

class CommentsController extends Controller
{
    private  $global;
    private  $session;

    /**
     *
     */
    public function __construct()
    {
        $this->global = new SuperGlobal();
        $this->session = new Session();
    }


}
