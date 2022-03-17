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
        if ($this->isAdmin()) {
            $postModel = new PostsModel();
            $post = $postModel->find($id);

            $commentModel = new CommentsModel();

            $comments = $commentModel->findBy(
                array(
                    'post_id' => $id,
                    'is_valid' => 0
                )
            );

            $this->render('admin/comments', ['post' => $post, 'comments' => $comments], 'admin');
        }
    }

    /**
     * Vérifie si je suis administrateur
     * @return bool|void
     */
    private function isAdmin()
    {
        // On vérifie si on est connecté et si "ROLE_ADMIN" est dans nos rôles
        if (isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['role'])) {
            // On est admin
            return true;
        } else {
            // On n'est pas admin
            $_SESSION['error'] = "You do not have access to this area";
            header('Location: main');
            exit;
        }
    }

    public function validComment(int $idComment)
    {

        // requête de validation des commentaires
            $commentModel = new CommentsModel();
            $commentArray = $commentModel->find($idComment);

            if ($commentArray) {
                $comment = $commentModel->hydrate($commentArray);

                var_dump($comment);
                die();

                $comment->setIsValid($comment->getIsValid() ? 0 : 1);
                $comment->update();
            }
    }

    /**
     * Supprimer le commentaire
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        if ($this->isAdmin()) {
            $comment = new CommentsModel();
            $comment->delete($id);
        }
    }
}
