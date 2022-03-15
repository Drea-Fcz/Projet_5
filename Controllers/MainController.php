<?php
namespace App\Controllers;

use App\Core\Form;

class MainController extends Controller
{
    public function index()
    {
        $form = new Form();
        $form->startForm()
            ->startDiv(['class' => 'row'])
            ->startDiv(['class' => 'col-md-6 mb-2'])
            ->addInput('text', 'firstname', ['class' => 'form-control shadow-box', 'id' => 'firstname', 'placeholder' => 'Firstname'])
            ->endDiv()
            ->startDiv(['class' => 'col-md-6 mb-2'])
            ->addInput('text', 'lastname', ['class' => 'form-control shadow-box', 'id' => 'lastname', 'placeholder' => 'Lastname'])
            ->endDiv()
            ->endDiv()
            ->startDiv(['class' => 'row mt-1'])
            ->startDiv(['class' => 'col-md-12 mb-2'])
            ->addInput('email', 'email', ['class' => 'form-control shadow-box', 'id' => 'email', 'placeholder' => 'Email'])
            ->endDiv()
            ->endDiv()
            ->startDiv(['class' => 'row mt-1'])
            ->startDiv(['class' => 'col-md-12 mb-2'])
            ->addTextarea('message', 'message', ['class' => 'form-control shadow-box', 'id' => 'message', 'placeholder' => 'Enter your message'])
            ->endDiv()
            ->endDiv()
            ->startDiv(['class' => 'col-12 mt-3'])
            ->addBouton('Send', ['class' => 'bnt btn-outline-success btn-sm'])
            ->endDiv()
            ->endForm();

        $this->render('main/index', ['visitorForm' => $form->create()], 'home');
    }
}
