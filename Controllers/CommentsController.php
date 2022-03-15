<?php

namespace App\Controllers;

use App\Models\CommentsModel;

class CommentsController extends Controller
{
    public function index() {

        $commentsModel = new CommentsModel();

        $comments = $commentsModel->findBy(
            [
                "is_valid" => 0
            ]
        );
    }

}
