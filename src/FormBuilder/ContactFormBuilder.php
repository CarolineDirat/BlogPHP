<?php

namespace App\FormBuilder;

use App\Application\Form\FormBuilder;
use App\Application\Form\InputTextField;
use App\Application\Form\InputEmailField;
use App\Application\Form\TextareaField;
use App\Application\Form\NotEmptyValidator;
use App\Application\Form\MaxLengthValidator;

final class ContactFormBuilder extends FormBuilder
{
    public function build(): void
    {
        $this->form
            ->addField(
                new InputTextField([
                    'textLabel' => 'Prénom',
                    'name' => 'firstName',
                    'idField' => 'firstName',
                    'placeholder' => 'Prénom',
                    'required' => true,
                    'maxlength' => 50,
                    'validators' => [
                        new NotEmptyValidator('Merci de spécifier votre Prénom.'),
                        new MaxLengthValidator('Le prénom spécifié est trop long (50 caractères maximum)', 50)
                    ]
            ]))
            ->addField(
                new InputTextField([
                    'textLabel' => 'Nom',
                    'name' => 'lastName',
                    'idField' => 'lastName',
                    'placeholder' => 'Nom',
                    'required' => true,
                    'maxlength' => 50,
                    'validators' => [
                        new NotEmptyValidator('Merci de spécifier votre Nom.'),
                        new MaxLengthValidator('Le nom spécifié est trop long (50 caractères maximum)', 50)
                    ]
            ]))
            ->addField(
                new InputEmailField([
                    'textLabel' => 'Adresse Email',
                    'name' => 'email1',
                    'idField' => 'email1',
                    'placeholder' => 'Adresse Email',
                    'required' => true,
                    'maxlength' => 250,
                    'validators' => [
                        new NotEmptyValidator('Merci de spécifier votre email.'),
                        new MaxLengthValidator('L\'email spécifié est trop long (250 caractères maximum)', 250)
                    ]
            ]))
            ->addField(
                new InputEmailField([
                    'textLabel' => 'Confirmez votre adresse email',
                    'name' => 'email2',
                    'idField' => 'email2',
                    'placeholder' => 'Confirmez votre adresse email',
                    'required' => true,
                    'maxlength' => 250,
                    'validators' => [
                        new NotEmptyValidator('Merci de confirmer votre adresse email.'),
                        new MaxLengthValidator('L\'email spécifié est trop long (250 caractères maximum)', 250)
                    ]
            ]))
            ->addField(
                new TextareaField([
                    'textLabel' => 'Message',
                    'name' => 'messageContact',
                    'idField' => 'messageContact',
                    'placeholder' => 'Message',
                    'required' => true,
                    'rows' => 5,
                    'validators' => [
                        new NotEmptyValidator('Merci de confirmer votre adresse email.')
                    ]
            ]))
            ->addField(
                new InputTextField([
                    'textLabel' => 'Recopier le code',
                    'name' => 'captchaPhrase',
                    'idField' => 'captchaPhrase',
                    'placeholder' => 'Recopier le code',
                    'required' => true,
                    'maxlength' => 50,
                    'validators' => [
                        new NotEmptyValidator('Merci de spécifier le code.')
                    ]
            ]))
        ;
    }
}
