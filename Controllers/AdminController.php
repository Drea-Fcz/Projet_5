<?php

namespace App\Controllers;

use App\Models\CommentsModel;
use App\Models\PostsModel;

class AdminController extends Controller
{
    public function index()
    {

        if ($this->isAdmin()) {

            $postModel = new PostsModel();
            $posts = $postModel->getALlPostWIthCountComment();

            $this->render('admin/index', ['posts' => $posts], 'admin');
        }
    }

    /**
     * Affiche la liste des annonces sous forme de tableau
     **/
    public function comments($id)
    {
        if($this->isAdmin()){
            $commentModel = new CommentsModel();

            $comments = $commentModel->findBy(
                array (
                    'post_id' => $id,
                    'is_valid' => 0
                )
            );

            $this->render('admin/comments', ['comments' => $comments ], 'admin');
        }
    }

    /**
     * Vérifie si je suis administrateur
     * @return bool|void
     */
    private function isAdmin()
    {
        // On vérifie si on est connecté et si "ROLE_ADMIN" est dans nos rôles
        if(isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['role'])){
            // On est admin
            return true;
        }else{
            // On n'est pas admin
            $_SESSION['error'] = "You do not have access to this area";
            header('Location: main');
            exit;
        }
    }
}
