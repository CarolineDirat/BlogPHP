<?php

namespace App\FormBuilder;

use App\Application\Entity;
use App\Application\Form\FormBuilder;
use App\Application\Form\NotEmptyValidator;
use App\Application\Form\TextareaField;
//use App\Application\HTTPRequest;

/**
 * CommentFormBuilder
 * 
 * Builder of comment form on post page
 */
final class CommentFormBuilder extends FormBuilder
{
    public function build(): void
    {
        $this->form->addField(new TextareaField([
                'name' => 'content',
                'idField' => 'content',
                'placeholder' => 'Un commentaire ?',
                'required' => 'required',
                'rows' => 8,
                'validators' => [
                    new NotEmptyValidator('Merci d\'écrire un commentaire pour pouvoir l\'envoyer.')
                ],
            ])
        );
    }
}
