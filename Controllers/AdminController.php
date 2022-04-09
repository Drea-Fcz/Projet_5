<?php

namespace App\Controllers;

use App\Libraries\Session;
use App\Models\CommentsModel;
use App\Models\PostsModel;

class AdminController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

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
    public function comments($idComment)
    {
        if ($this->isAdmin()) {
            $postModel = new PostsModel();
            $post = $postModel->find($idComment);

            $commentModel = new CommentsModel();

            $comments = $commentModel->findBy(
                array(
                    'post_id' => $idComment,
                    'is_valid' => 0
                )
            );

            if (count($comments) == 0) {
                header('Location: ../../admin');
            }

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
        }

        // On n'est pas admin
        $this->session->set('error', 'You do not have access to this area');
        header('Location: main');
    }

    public function validComment(int $idComment)
    {
        // requête de validation des commentaires
        if ($this->isAdmin()) {
            $commentModel = new CommentsModel();
            $commentArray = $commentModel->find($idComment);

            if ($commentArray) {
                $comment = $commentModel->hydrate($commentArray);

                $comment->setIsValid($comment->getIsValid() ? 0 : 1);
                $comment->update();

                header('Location: ../../admin/comments/' . $comment->getPostId());
            }
        }
    }

    /**
     * Supprimer le commentaire
     * @param int $idComment
     * @return void
     */
    public function delete(int $idComment)
    {
        if ($this->isAdmin()) {
            $comment = new CommentsModel();
            $comment->delete($idComment);
            header('Location: ../../admin');
        }
    }
}
