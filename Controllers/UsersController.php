<?php

namespace App\Controllers;

use App\Core\Form;
use App\Libraries\Helper;
use App\Libraries\Session;
use App\Libraries\SuperGlobal;
use App\Models\UsersModel;

class UsersController extends Controller
{
    private $form;
    private $global;
    private $session;
    private $helper;

    public function __construct()
    {
        $this->form = new Form();
        $this->global = new SuperGlobal();
        $this->session = new Session();
        $this->helper = new Helper();
    }

    /**
     * Connexion des utilisateurs
     * @return void
     */
    public function login()
    {
        // On vérifie si le formulaire est complet
        if (Form::validate($this->global->get_POST(), ['email', 'password'])) {
            // Le formulaire est complet
            // On va chercher dans la base de données l'utilisateur avec l'email entré
            $usersModel = new UsersModel;
            $safePost = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $userArray = $usersModel->findOneByEmail($safePost['email']);

            // Si l'utilisateur n'existe pas
            if (!$userArray) {
                // On envoie un message de session
                $this->session->set('error', 'Incorrect e-mail address and/or password');
                $this->helper->redirect('login');
            }

            // L'utilisateur existe
            $user = $usersModel->hydrate($userArray);

            // On vérifie si le mot de passe est correct
            if (password_verify($this->global->get_POST('password'), $user->getPassword())) {
                // Le mot de passe est bon
                // On crée la session
                $user->setSession();
                $this->helper->redirect('../posts');
            } else {
                // Mauvais mot de passe
                $this->session->set('error', 'Incorrect e-mail address and/or password');
                $this->helper->redirect('login');
            }
        }

        $this->form->startForm()
            ->startDiv(['class' => 'form-group mb-3'])
            ->addInput('email', 'email', ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Enter your email'])
            ->endDiv()
            ->startDiv(['class' => 'form-group mb-3'])
            ->addInput('password', 'password', ['id' => 'pass', 'class' => 'form-control', 'placeholder' => 'Enter your password'])
            ->endDiv()
            ->startDiv(['class' => 'd-flex flex-row justify-content-around'])
            ->addBouton('Login', ['class' => 'bnt btn-outline-success btn-sm mt-2'])
            ->addAnchorTag('#', 'No account?
            Register', ['class' => 'bnt color btn-sm a-tag align-self-center'])
            ->endDiv()
            ->endForm();

        $this->render('users/login', ['loginForm' => $this->form->create()]);

    }

    /**
     * Inscription des utilisateurs
     * @return void
     */
    public function register()
    {

        // On vérifie si le formulaire est valide
        if (Form::validate($this->global->get_POST(), ['name', 'email', 'password'])) {
            // Le formulaire est valide
            // On "nettoie" l'adresse email
            $safePost = filter_input_array(INPUT_POST, [
                "email" => FILTER_SANITIZE_STRING,
                "name" => FILTER_SANITIZE_STRING,
            ]);
            $email = strip_tags($safePost['email']);
            $name = strip_tags($safePost['name']);

            // On chiffre le mot de passe
            if ($this->global->get_POST('password') === $this->global->get_POST('confirm_password')) {
                $pass = password_hash($this->global->get_POST('password'), PASSWORD_BCRYPT);

                // On hydrate l'utilisateur
                $user = new UsersModel;

                $user->setEmail($email);
                $user->setName($name);
                $user->setPassword($pass);

                // On stocke l'utilisateur
                $user->create();
                $this->helper->redirect('../users/login');

            } else {
                $this->session->set('error', 'The informations are not valid');

                $this->helper->redirect('register');
            }
        }
        $this->form->startForm()
            ->startDiv(['class' => 'form-group mb-3'])
            ->addInput('text', 'name', ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter your name'])
            ->endDiv()
            ->startDiv(['class' => 'form-group mb-3'])
            ->addInput('email', 'email', ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Enter your email'])
            ->endDiv()
            ->startDiv(['class' => 'form-group mb-3'])
            ->addInput('password', 'password', ['id' => 'pass', 'class' => 'form-control', 'placeholder' => 'Enter your password'])
            ->endDiv()
            ->startDiv(['class' => 'form-group mb-3'])
            ->addInput('password', 'confirm_password', ['id' => 'pass', 'class' => 'form-control', 'placeholder' => 'Confirm your password'])
            ->endDiv()
            ->startDiv(['class' => 'd-flex flex-row justify-content-around'])
            ->addBouton('Submit', ['class' => 'bnt btn-outline-success btn-sm mt-2'])
            ->addAnchorTag('#', 'Have an account? Login', ['class' => 'bnt color btn-sm a-tag align-self-center'])
            ->endDiv()
            ->endForm();

        $this->render('users/register', ['registerForm' => $this->form->create()]);
    }

    /**
     * Déconnexion utilisateur
     * @return void
     */
    public function logout()
    {
        session_destroy();
        // unset($_SESSION['user']);
        $this->helper->redirect($this->global->get_SERVER('HTTP_REFERER'));
    }
}
