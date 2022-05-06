<?php

namespace App\Controllers;

use App\Core\Form;
use App\Libraries\Helper;
use App\Libraries\Session;
use App\Libraries\SuperGlobal;
use App\Models\CommentsModel;
use App\Models\PostsModel;

class PostsController extends Controller
{
    private $global;
    private $session;
    private $helper;

    public function __construct()
    {
        $this->global = new SuperGlobal();
        $this->session = new Session();
        $this->helper = new Helper();
    }

    /**
     * @return void
     */
    public function index()
    {

        // On instancie le modèle correspondant à la table 'posts'
        $postsModel = new PostsModel();

        // On va chercher tous les posts
        $posts = $postsModel->FindAllByDESC();

        $this->render('posts/index', ['posts' => $posts]);

    }

    /**
     * Afficher un post
     * @param int $idPost
     * @return void
     */
    public function show(int $idPost)
    {

        // On instancie le modèle
        $postsModel = new PostsModel();

        // On va chercher 1 post
        $post = $postsModel->find($idPost);
        $idRedirect = intval($post->id);

        // On récupère les commentaires valides du post
        $commentsModel = new CommentsModel();

        $comments = $commentsModel->findByPostId($idPost);

        // formulaire de commentaire
        // On vérifie si l'utilisateur est connecté
        if ($this->session->get('user') !== null && $this->session->get('user')['id'] !== null) {
            // L'utilisateur est connecté
            // On vérifie si le formulaire est complet
            if (Form::validate($this->global->get_POST(), ['comment'])) {
                $safePost = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $postComment = strip_tags($safePost['comment']);

                // On instancie notre modèle
                $comment = new CommentsModel();


                // On hydrate
                $comment->setComment($postComment)
                    ->setIsValid(0)
                    ->setPostId($idPost)
                    ->setAuthorId($this->session->get('user')['id']);

                // On enregistre
                $comment->create();

                $this->session->set('message', 'Your comment has been successfully registered');
            }
            // Le formulaire est incomplet
            $this->session->set('erreur', !empty($_POST) ? "The form is incomplete" : '');
            $postComment = $this->global->get_POST('comment') !== null ? strip_tags($this->global->get_POST('comment')) : '';


            $form = $this->commentForm($postComment);

            // On envoie à la vue
            $this->render('posts/show', ['post' => $post, 'comments' => $comments, 'idPost' => $idRedirect, 'form' => $form->create()]);
        } else {
            // L'utilisateur n'est pas connecté
            // On envoie à la vue
            $this->render('posts/show', ['post' => $post, 'comments' => $comments, 'idPost' => $idRedirect]);
        }
    }

    /**
     * @param string $comment
     * @return Form
     */
    public function commentForm(string $comment): Form
    {
        $form = new Form();

        $form->startForm('post', '#')
            ->startDiv(['class' => 'd-flex justify-content-between'])
            ->addInput('text', 'comment', [
                'id' => 'comment',
                'class' => 'form-control bg-input-comment text-white',
                'value' => $comment,
                'placeholder' => 'Leave a comment',
            ])
            ->addInput('submit', 'submit', [
                'id' => 'submit',
                'class' => 'btn btn-outline-success btn-small ms-3',
                'value' => 'Send'
            ])
            ->endDiv()
            ->endForm();

        return $form;
    }

    /**
     * @return void
     */
    public function add()
    {

        // On vérifie si l'utilisateur est connecté
        if ($this->session->get('user') !== null && $this->session->get('user')['id'] !== null) {
            // L'utilisateur est connecté
            // On vérifie si le formulaire est complet
            if (Form::validate($this->global->get_POST(), ['title', 'chapo', 'body'])) {
                $safePost = filter_input_array(INPUT_POST, [
                    "title" => FILTER_SANITIZE_STRING,
                    "chapo" => FILTER_SANITIZE_STRING,
                    "body" => FILTER_SANITIZE_STRING
                ]);

                // Le formulaire est complet
                // On se protège contre les failles XSS
                // strip_tags, htmlentities, htmlspecialchars
                $title = strip_tags($safePost['title']);
                $chapo = strip_tags($safePost['chapo']);
                $body = strip_tags($safePost['body']);
                $img = strip_tags($this->global->get_FILE('img')['name']);

                // On instancie notre modèle
                $post = new PostsModel();


                // On hydrate
                $post->setChapo($chapo)
                    ->setTitle($title)
                    ->setBody($body)
                    ->setImg($img)
                    ->setUserId($this->session->get('user')['id']);

                // On enregistre
                $post->create();
                //save picture
                $this->saveImg($this->global->get_FILE());

                // On redirige
                $this->session->set('message', 'Your post has been successfully registered');
                $this->helper->redirect('../posts');

            }
            // Le formulaire est incomplet
            $this->session->set('erreur', !empty($_POST) ? "The form is incomplete" : '');
            $title = $this->global->get_POST('title') !== null ? strip_tags($this->global->get_POST('title')) : '';
            $chapo = $this->global->get_POST('chapo') !== null ? strip_tags($this->global->get_POST('chapo')) : '';
            $body = $this->global->get_POST('body') !== null ? strip_tags($this->global->get_POST('body')) : '';
            $img = $this->global->get_FILE('img') !== null ? strip_tags($this->global->get_FILE('img')['name']) : '';


            $form = $this->postForm($chapo, $title, $body, $img);

            $this->render('posts/add', ['form' => $form->create()]);

        }
    }

    public function saveImg($file)
    {
        // enregistrer l'image
        if (isset($file['img']) && $file['img']['error'] == 0) {
            if ($file['img']['size'] <= 2000000) {
                $fileInfo = pathinfo($file['img']['name']);
                $extension = $fileInfo['extension'];
                $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
                if (in_array($extension, $allowedExtensions)) {
                    move_uploaded_file($file['img']['tmp_name'], '' . $this->global->get_SERVER('DOCUMENT_ROOT') . '/poo/public/assets/upload/' . basename($_FILES['img']['name']));
                }
            }
        }
    }

    public function postForm($chapo, $title, $body, $img): Form
    {
        $form = new Form;

        $form->startForm('post', '#', ['class' => 'text-white', 'enctype' => "multipart/form-data"])
            ->startDiv(['class' => 'form-group mb-3'])
            ->addLabelFor('chapo', 'Chapo :')
            ->addInput('text', 'chapo', [
                'id' => 'chapo',
                'class' => 'form-control',
                'value' => $chapo
            ])
            ->endDiv()
            ->startDiv(['class' => 'form-group mb-3'])
            ->addLabelFor('title', 'Title :')
            ->addInput('text', 'title', [
                'id' => 'titre',
                'class' => 'form-control',
                'value' => $title
            ])
            ->endDiv()
            ->startDiv(['class' => 'form-group mb-3'])
            ->addLabelFor('body', 'Body')
            ->addTextarea('body', $body, ['id' => 'body', 'class' => 'form-control'])
            ->endDiv()
            ->startDiv(['class' => 'form-group mb-3'])
            ->addLabelFor('img', 'Image :')
            ->addInput('file', 'img', [
                'id' => 'img',
                'class' => 'form-control',
                'accept' => 'image/png, image/jpeg, image/jpg',
                'value' => $img
            ])
            ->endDiv()
            ->startDiv(['class' => 'd-flex justify-content-end'])
            ->addAnchorTag('../show', 'Cancel', ['class' => 'btn btn-outline-cancel me-3'])
            ->addBouton('Submit', ['value' => 'Submit', 'class' => 'btn btn-outline-success'])
            ->endDiv()
            ->endForm();

        return $form;
    }

    /**
     * @param int $idPost
     * @return void
     */
    public function edit(int $idPost)
    {
        // On vérifie si l'utilisateur est connecté
        if ($this->session->get('user') !== null && $this->session->get('user')['id'] !== null) {
            // On va vérifier si l'post existe dans la base
            // On instancie notre modèle
            // On instancie le modèle
            $postsModel = new PostsModel();

            // On va chercher 1 post
            $post = $postsModel->find($idPost);

            // Si l'post n'existe pas, on retourne à la liste des posts
            if (!$post) {
                http_response_code(404);
                $this->session->set('erreur', 'The post you are looking for does not exist');
                $this->helper->redirect('/posts');
            }

            // On traite le formulaire
            if (Form::validate($this->global->get_POST(), ['chapo', 'title', 'body'])) {
                $safePost = filter_input_array(INPUT_POST, [
                    "title" => FILTER_SANITIZE_STRING,
                    "chapo" => FILTER_SANITIZE_STRING,
                    "body" => FILTER_SANITIZE_STRING
                ]);

                // On se protège contre les failles XSS
                $title = strip_tags($safePost['title']);
                $chapo = strip_tags($safePost['chapo']);
                $body = strip_tags($safePost['body']);
                $img = strip_tags($this->global->get_FILE('img')['name'] == '' ? $post->img : strip_tags($this->global->get_FILE('img')['name']));


                // On stocke l'post
                $postUpdate = new PostsModel();

                // On hydrate
                $postUpdate->setId($post->id)
                    ->setChapo($chapo)
                    ->setTitle($title)
                    ->setBody($body)
                    ->setImg($img);

                // On met à jour l'post
                $postUpdate->update();

                //save picture
                $this->saveImg($this->global->get_FILE());

                // On redirige
                $this->session->set('message', 'Your post has been successfully edited');
                $this->helper->redirect('../show/' . $post->id);
            }


            $form = $this->postForm($post->chapo, $post->title, $post->body, $post->img);

            // On envoie à la vue
            $this->render('posts/edit', ['form' => $form->create()]);

        } else {
            // L'utilisateur n'est pas connecté
            $this->session->set('error', 'You must be logged in to access this page');
            $this->helper->redirect('users/login');
        }
    }

    /**
     * Supprimer le commentaire
     * @param int $idPost
     * @return void
     */
    public function delete(int $idPost)
    {
        $post = new PostsModel();
        $post->delete($idPost);
        $this->helper->redirect('../../posts');
    }
}
