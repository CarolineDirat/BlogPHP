<?php

namespace App\FormBuilder;

use App\Application\Form\FormBuilder;
use App\Application\Form\ValuesEqualityValidator;
use App\Application\Form\MaxLengthValidator;
use App\Application\Form\NotEmptyValidator;
use App\Application\Form\TextareaField;
use App\Application\Form\InputTokenField;
use App\Application\Entity;
use App\Application\HTTPRequest;

/**
 * CommentFormBuilder.
 *
 * Builder of comment form on post page
 */
final class CommentFormBuilder extends FormBuilder
{
    private HTTPRequest $httpRequest;
    
    /**
     * action
     * 
     * used to define idField of token field
     *
     * @var string
     */
    private string $action;
    
    public function __construct(Entity $entity, HTTPRequest $httpRequest, string $action)
    {
        parent::__construct($entity);
        $this->setHttpRequest($httpRequest);
        $this->action = $action;
    }

    public function build(): self
    {
        // one textarea field for the content of a comment
        $this->form
            ->addField(
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
            )->addField(
                new InputTokenField([
                    // name property is already defined to 'token' in InputTokenField class
                    'idField' => 'token-comment-'.$this->action,
                    'value' => $this->httpRequest->getSession('token'),
                    'validators' => [
                        new NotEmptyValidator('Essaye de te reconnecter pour voir...'),
                        new ValuesEqualityValidator('Essaye de te reconnecter pour voir...', $this->httpRequest->getSession('token')),
                    ]
                ])
            )
        ;

        return $this;
    }

    /**
     * Set the value of httpRequest
     *
     * @return  self
     */ 
    public function setHttpRequest(HTTPRequest $httpRequest): self
    {
        $this->httpRequest = $httpRequest;

        return $this;
    }
}
