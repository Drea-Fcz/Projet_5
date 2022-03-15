<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\CommentsModel;
use App\Models\PostsModel;

class PostsController extends Controller
{
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
     * @param int $id
     * @return void
     */
    public function show(int $id)
    {

        // On instancie le modèle
        $postsModel = new PostsModel();

        // On va chercher 1 post
        $post = $postsModel->find($id);
        $idPost = intval($post->id);

        // On récupère les commentaires valides du post
        $commentsModel = new CommentsModel();

        $comments = $commentsModel->findByPostId($id);



        // On envoie à la vue
        $this->render('posts/show', ['post' => $post, 'comments' => $comments, 'idPost' => $idPost]);

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
            ->addAnchorTag('../posts', 'Cancel', ['class' => 'btn btn-outline-cancel me-3'])
            ->addBouton('Submit', ['value' => 'Submit', 'class' => 'btn btn-outline-success'])
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
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            // L'utilisateur est connecté
            // On vérifie si le formulaire est complet
            if (Form::validate($_POST, ['title', 'chapo', 'body'])) {
                // Le formulaire est complet
                // On se protège contre les failles XSS
                // strip_tags, htmlentities, htmlspecialchars
                $title = strip_tags($_POST['title']);
                $chapo = strip_tags($_POST['chapo']);
                $body = strip_tags($_POST['body']);
                $img = strip_tags($_FILES['img']['name']);

                // On instancie notre modèle
                $post = new PostsModel();


                // On hydrate
                $post->setChapo($chapo)
                    ->setTitle($title)
                    ->setBody($body)
                    ->setImg($img)
                    ->setUserId($_SESSION['user']['id']);

                // On enregistre
                $post->create();
                //save picture
                if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
                    if ($_FILES['img']['size'] <= 2000000) {
                        $fileInfo = pathinfo($_FILES['img']['name']);
                        $extension = $fileInfo['extension'];
                        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
                        if (in_array($extension, $allowedExtensions)) {
                            move_uploaded_file($_FILES['img']['tmp_name'], '' . $_SERVER['DOCUMENT_ROOT'] . '/poo/public/assets/upload/' . basename($_FILES['img']['name']));
                            echo "Success !";
                        }
                    }
                }

                // On redirige
                $_SESSION['message'] = "Your post has been successfully registered";
                header('Location: ../posts');
                exit;
            } else {
                // Le formulaire est incomplet
                $_SESSION['erreur'] = !empty($_POST) ? "Le formulaire est incomplet" : '';
                $title = isset($_POST['title']) ? strip_tags($_POST['title']) : '';
                $chapo = isset($_POST['chapo']) ? strip_tags($_POST['chapo']) : '';
                $body = isset($_POST['body']) ? strip_tags($_POST['body']) : '';
                $img = isset($_FILES['img']['name']) ? strip_tags($_FILES['img']['name']) : '';
            }


            $form = $this->postForm($chapo, $title, $body, $img);

            $this->render('posts/add', ['form' => $form->create()]);

        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function edit(int $id)
    {
        // On vérifie si l'utilisateur est connecté
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            // On va vérifier si l'post existe dans la base
            // On instancie notre modèle
            // On instancie le modèle
            $postsModel = new PostsModel();

            // On va chercher 1 post
            $post = $postsModel->find($id);

            // Si l'post n'existe pas, on retourne à la liste des posts
            if (!$post) {
                http_response_code(404);
                $_SESSION['erreur'] = "The post you are looking for does not exist";
                header('Location: /posts');
                exit;
            }

            // On traite le formulaire
            if (Form::validate($_POST, ['chapo', 'title', 'body'])) {
                // On se protège contre les failles XSS
                $chapo = strip_tags($_POST['chapo']);
                $title = strip_tags($_POST['title']);
                $body = strip_tags($_POST['body']);
                $img = strip_tags($_FILES['img']['name']) == '' ? $post->img : strip_tags($_FILES['img']['name']);


                // On stocke l'post
                $postUpdate = new PostsModel();

                // On hydrate
                $postUpdate->setId(intval($post->id))
                    ->setChapo($chapo)
                    ->setTitle($title)
                    ->setBody($body)
                    ->setImg($img);

                // On met à jour l'post
                $postUpdate->update();

                // On redirige
                $_SESSION['message'] = "Your post has been successfully edited";
                 header('Location: ../show/' . $post->id );
                exit;
            }


            $form = $this->postForm($post->chapo, $post->title, $post->body, $post->img);

            // On envoie à la vue
            $this->render('posts/edit', ['form' => $form->create()]);

        } else {
            // L'utilisateur n'est pas connecté
            $_SESSION['error'] = "You must be logged in to access this page";
            header('Location: users/login');
            exit;

        }
    }

}
