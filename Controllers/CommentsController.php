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

    /**
     * @param string $comment
     * @return Form
     */
    public function postForm(string $comment): Form
    {
        $form = new Form();

        $form->startForm('post', '#', ['class' => 'text-white'])
            ->startDiv(['class' => 'form-group mb-3'])
            ->addInput('text', 'comment', [
                'id' => 'comment',
                'class' => 'form-control',
                'value' => $comment
            ])
            ->endDiv()
            ->addInput('submit', 'submit', [
                'id' => 'submit',
                'class' => 'btn btn-outline-success btn-small ms-3',
                'value' => 'Send'
            ])
            ->endForm();

        return $form;
    }

    /**
     * @return void
     */
    public function add()
    {

        // On vérifie si l'utilisateur est connecté
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            // L'utilisateur est connecté
            // On vérifie si le formulaire est complet
            if (Form::validate($_POST, ['comment'])) {

                $postComment = strip_tags($this->global->get_POST('comment'));

                // On instancie notre modèle
                $comment = new CommentsModel();


                // On hydrate
                $comment->setComment($postComment)
                        ->setIsValid(false)
                        ->setAuthorId($this->session->get('user')['id']);

                // On enregistre
                $comment->create();

                // On redirige
                $this->session->set('message', 'Your post has been successfully registered');
                // CHANGE THIS !!!!
                header('Location: ../posts');
            }
            // Le formulaire est incomplet
            $this->session->set('erreur', !empty($_POST) ? "The form is incomplete" : '');
            $postComment = isset($_POST['comment']) ? strip_tags($this->global->get_POST('comment')) : '';


            $form = $this->postForm($postComment);

            $this->render('posts/show', ['form' => $form->create()]);

        }
    }


}
