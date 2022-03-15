<?php

namespace App\Core;

class Form
{
    private $formCode = '';

    /**
     * génère le formulaire Html
     * @return string
     */
    public function create(): string
    {
        return $this->formCode;
    }

    /**
     * Valide si tous les champs proposé sont remplis
     * @param array $form tableau issus du formulaire ($_POST | $_GET
     * @param array $fields
     * @return bool
     */
    public static function validate(array $form, array $fields): bool
    {
        // On parcours les champs
        foreach ($fields as $field) {
            // Si le champs est absent ou vide dans le formulaire
            if (!isset($form[$field]) || empty($form[$field])) {
                // On retourne "false"
                return false;
            }
        }
        return true;
    }

    /**
     * Ajouts des attributs envoyés à la balise
     * @param array $attributes Tableau associatif [ 'class' => 'form-control', 'required' => true]
     * @return string
     */
    public function addAttributes(array $attributes): string
    {
        // On initialise une chaine de caractères
        $str = '';

        // on liste les attributs "courts"
        $shorts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];

        // On boucle sur le tableau d'attributs
        foreach($attributes as $attribute => $value){
            // Si l'attribut est dans la liste des attributs courts
            if(in_array($attribute, $shorts) && $value == true){
                $str .= " $attribute";
            }else{
                // On ajoute attribut='valeur'
                $str .= " $attribute=\"$value\"";
            }
        }

        return $str;
    }

    /**
     * Balise d'ouverture du formulaire
     * @param string $method Méthode du formulaire (post ou get)
     * @param string $action Action du formulaire
     * @param array $attributes Attributs
     * @return Form
     */
    public function startForm(string $method = 'post', string $action = '#', array $attributes = []): self
    {
        // On crée la balise form
        $this->formCode .= "<form action='$action' method='$method'";

        // On ajoute les attributs éventuels
        $this->formCode .= $attributes ? $this->addAttributes($attributes).'>' : '>';

        return $this;
    }

    /**
     * Balise de fermeture du formulaire
     * @return Form
     */
    public function endForm():self
    {
        $this->formCode .= '</form>';
        return $this;
    }

    /**
     * Ajout d'un label
     * @param string $for
     * @param string $text
     * @param array $attributes
     * @return Form
     */
    public function addLabelFor(string $for, string $text, array $attributes = []):self
    {
        // On ouvre la balise
        $this->formCode .= "<label for='$for'";

        // On ajoute les attributs
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';

        // On ajoute le texte
        $this->formCode .= ">$text</label>";

        return $this;
    }
    /**
     * Ajout d'un champ input
     * @param string $type
     * @param string $name
     * @param array $attributes
     * @return Form
     */
    public function addInput(string $type, string $name, array $attributes = []):self
    {
        // On ouvre la balise
        $this->formCode .= "<input type='$type' name='$name'";

        // On ajoute les attributs
        $this->formCode .= $attributes ? $this->addAttributes($attributes).'>' : '>';

        return $this;
    }

    /**
     * Ajoute un champ textarea
     * @param string $name Nom du champ
     * @param string $value Valeur du champ
     * @param array $attributes Attributs
     * @return Form Retourne l'objet
     */
    public function addTextarea(string $name, string $value = '', array $attributes = []):self
    {
        // On ouvre la balise
        $this->formCode .= "<textarea name='$name'";

        // On ajoute les attributs
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';

        // On ajoute le texte
        $this->formCode .= ">$value</textarea>";

        return $this;
    }


    /**
     * Ajoute un bouton
     * @param string $text
     * @param array $attributes
     * @return Form
     */
    public function addBouton(string $text, array $attributes = []):self
    {
        // On ouvre le bouton
        $this->formCode .= '<button ';

        // On ajoute les attributs
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';

        // On ajoute le texte et on ferme
        $this->formCode .= ">$text</button>";

        return $this;
    }

    /**
     * Balise d'ouverture div
     * @param array $attributes Attributs
     * @return Form
     */
    public function startDiv( array $attributes = []): self
    {
        // On crée la balise div
        $this->formCode .= "<div";

        // On ajoute les attributs éventuels
        $this->formCode .= $attributes ? $this->addAttributes($attributes).'>' : '>';

        return $this;
    }

    /**
     * Balise de fermeture du formulaire
     * @return Form
     */
    public function endDiv():self
    {
        $this->formCode .= '</div>';
        return $this;
    }

    /**
     * Balise d'ouverture div
     * @param array $attributes Attributs
     * @return Form
     */
    public function startSpan( array $attributes = []): self
    {
        // On crée la balise div
        $this->formCode .= "<span";

        // On ajoute les attributs éventuels
        $this->formCode .= $attributes ? $this->addAttributes($attributes).'>' : '>';

        return $this;
    }

    /**
     * Balise de fermeture du formulaire
     * @param $value
     * @return Form
     */
    public function endSpan($value):self
    {
        $this->formCode .= $value .'</span>';
        return $this;
    }

    /**
     * Balise d'ouverture a
     * @param string $path
     * @param string $text
     * @param array $attributes Attributs
     * @return Form
     */
    public function addAnchorTag(string $path, string $text,array $attributes = []): self
    {
        // On crée la balise a
        $this->formCode .= "<a href='$path'";

        // On ajoute les attributs éventuels
        $this->formCode .= $attributes ? $this->addAttributes($attributes).'>'. $text .'</a>': '>'. $text .'</a>';

        return $this;
    }
}
