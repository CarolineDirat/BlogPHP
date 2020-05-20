<?php

namespace App\FormBuilder;

use App\Application\Form\FormBuilder;
use App\Application\Form\InputTextField;
use App\Application\Form\InputEmailField;
use App\Application\Form\TextareaField;
use App\Application\Form\NotEmptyValidator;
use App\Application\Form\MaxLengthValidator;
use App\Application\Form\CaptchaValidator;
use App\Application\HTTPRequest;
use App\Application\Entity;

final class ContactFormBuilder extends FormBuilder
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
                    'textLabel' => 'Prénom',
                    'name' => 'firstName',
                    'idField' => 'firstName',
                    'placeholder' => 'Prénom',
                    'required' => 'required',
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
                    'required' => 'required',
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
                    'required' => 'required',
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
                    'required' => 'required',
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
                    'required' => 'required',
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
                    'required' => 'required',
                    'maxlength' => 6,
                    'validators' => [
                        new NotEmptyValidator('Merci de spécifier le code.'),
                        new MaxLengthValidator('Le code spécifié est trop long (6 caractères maximum)', 6),
                        new CaptchaValidator('Le code recopié n\'est pas le bon. Aide : vous pouvez tout écrire en minuscule', $this->httpRequest)
                    ]
            ]))
        ;
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
