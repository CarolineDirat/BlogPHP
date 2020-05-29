<?php

namespace App\FormBuilder;

use App\Application\Form\FormBuilder;
use App\Application\Form\InputTextField;
use App\Application\Form\TextareaField;
use App\Application\Form\MaxLengthValidator;
use App\Application\Form\NotEmptyValidator;
use App\Application\Form\ValuesEqualityValidator;
use App\Application\HTTPRequest;
use App\Application\Entity;

/**
 * CommentFormBuilder.
 *
 * Builder of post form (for add or update a post)
 */
final class PostFormBuilder extends FormBuilder
{
    private HTTPRequest $httpRequest;

    public function __construct(Entity $entity, HTTPRequest $httpRequest)
    {
        parent::__construct($entity);
        $this->setHttpRequest($httpRequest);
    }
    
    public function build(): void
    {
        $this->form
            ->addField(
                new InputTextField([
                    'textLabel' => 'Titre',
                    'name' => 'title',
                    'idField' => 'title',
                    'placeholder' => 'Titre de l\'article',
                    'maxlength' => 150,
                    'required' => 'required',
                    'validators' => [
                        new NotEmptyValidator('Merci d\'écrire un titre.'),
                        new MaxLengthValidator('Merci d\'écrire un titre de moins de 150 caractères', 150),
                    ],
                ])
            )
            ->addField(
                new InputTextField([
                    'textLabel' => 'Chapô',
                    'name' => 'abstract',
                    'idField' => 'abstract',
                    'placeholder' => 'Chapô de l\'article',
                    'maxlength' => 300,
                    'required' => 'required',
                    'validators' => [
                        new NotEmptyValidator('Merci d\'écrire le chapô de l\'article.'),
                        new MaxLengthValidator('Merci d\'écrire un chapô de moins de 300 caractères', 300),
                    ],
                ])
            )
            ->addField(
                new InputTextField([
                    'textLabel' => 'Auteur',
                    'name' => 'author',
                    'idField' => 'author',
                    'value' => $this->httpRequest->getUserSession()->getPseudo(),
                    'required' => 'required',
                    'readonly' => '"true"',
                    'validators' => [
                        new NotEmptyValidator('Merci d\'écrire le chapô de l\'article.'),
                        new ValuesEqualityValidator(
                            'Vous ne pouvez pas modifier votre pseudo',
                            $this->httpRequest->getUserSession()->getPseudo()
                        )
                    ],
                ])
            )            
            ->addField(
                new TextareaField([
                    'textLabel' => 'Contenu de l\'article',
                    'name' => 'content',
                    'idField' => 'content',
                    'placeholder' => '... ici pour écrire l\'article ...',
                    'required' => 'required',
                    'maxlength' => 15000,
                    'rows' => 20,
                    'validators' => [
                        new NotEmptyValidator('Merci d\'écrire l\'article.'),
                        new MaxLengthValidator('Merci d\'écrire un article de moins de 10 000 caractères', 15000)
                    ],
                ])
            )
        ;
    }

    /**
     * Set the value of httpRequest.
     *
     * @return self
     */
    public function setHttpRequest(HTTPRequest $httpRequest): self
    {
        $this->httpRequest = $httpRequest;

        return $this;
    }
}
