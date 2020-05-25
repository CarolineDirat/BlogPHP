<?php

namespace App\FormBuilder;

use App\Application\Form\FormBuilder;
use App\Application\Form\InputTextField;
use App\Application\Form\MaxLengthValidator;
use App\Application\Form\NotEmptyValidator;

//use App\Application\Form\ValuesEqualityValidator;
//use App\Application\HTTPRequest;

/**
 * LoginFormBuilder.
 *
 * Build the login form for the login page
 */
final class LoginFormBuilder extends FormBuilder
{
    public function build(): void
    {
        $this->form
            ->addField(
                new InputTextField([
                    'textLabel' => 'Nom',
                    'name' => 'username',
                    'idField' => 'username',
                    'placeholder' => 'Nom',
                    'maxlength' => 50,
                    'validators' => [
                        new MaxLengthValidator('Le nom spécifié est trop long (50 caractères maximum)', 50),
                    ],
                ])
            )
            ->addField(
                new InputTextField(
                    [
                        'textLabel' => 'Votre pseudo',
                        'name' => 'pseudo',
                        'idField' => 'pseudo',
                        'placeholder' => 'Votre pseudo',
                        'maxlength' => 50,
                        'autofocus' => true,
                        'validators' => [
                            new NotEmptyValidator('Merci de spécifier votre pseudo.'),
                            new MaxLengthValidator('Le nom spécifié est trop long (50 caractères maximum)', 50),
                        ],
                    ]
                )
            )
            ->addField(
                new InputTextField(
                    [
                        'textLabel' => 'Votre mot de passe',
                        'name' => 'password',
                        'idField' => 'password',
                        'placeholder' => 'Votre mot de passe',
                        'maxlength' => 255,
                        'validators' => [
                            new NotEmptyValidator('Merci de spécifier votre mot de passe.'),
                            new MaxLengthValidator('Le nom spécifié est trop long (50 caractères maximum)', 255),
                        ],
                    ]
                )
            )
        ;
    }
}
