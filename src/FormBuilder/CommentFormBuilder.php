<?php

namespace App\FormBuilder;

use App\Application\Form\FormBuilder;
use App\Application\Form\MaxLengthValidator;
use App\Application\Form\NotEmptyValidator;
use App\Application\Form\TextareaField;

//use App\Application\HTTPRequest;

/**
 * CommentFormBuilder.
 *
 * Builder of comment form on post page
 */
final class CommentFormBuilder extends FormBuilder
{
    public function build(): void
    {
        // one textarea field for the content of a comment
        $this->form->addField(
            new TextareaField([
                'name' => 'content',
                'idField' => 'content',
                'placeholder' => '... ici pour écrire un commentaire ...',
                'maxlength' => 1500,
                'required' => 'required',
                'rows' => 8,
                'validators' => [
                    new NotEmptyValidator('Merci d\'écrire un commentaire pour pouvoir l\'envoyer.'),
                    new MaxLengthValidator('Merci d\'écrire un commentaire de moins de 1500 caractères', 1500),
                ],
            ])
        );
    }
}
