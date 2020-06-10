<?php

namespace App\FormBuilder;

use App\Application\Entity;
use App\Application\Form\FormBuilder;
use App\Application\Form\InputTextField;
use App\Application\Form\InputEmailField;
use App\Application\Form\InputPasswordField;
use App\Application\Form\MaxLengthValidator;
use App\Application\Form\MinLengthValidator;
use App\Application\Form\NotEmptyValidator;
use App\Application\Form\HoneypotValidator;
use App\Application\Form\ValuesEqualityValidator;
use App\Application\Form\RegexValidator;
use App\Application\Form\UniqueValidator;

final class RegisterFormBuilder extends FormBuilder
{    
    /**
     * pseudos
     *
     * @var string[]
     */
    private array $pseudos;

    /**
     * pseudos
     *
     * @var string[]
     */
    private array $emails;
    
    public function __construct(Entity $register, array $pseudos, array $emails)
    {
        parent::__construct($register);
        $this->pseudos = $pseudos;
        $this->emails = $emails;
    }

    public function build(): self
    {
        $this->form
            ->addField(
                new InputTextField([
                    'textLabel' => 'Votre pseudo',
                    'name' => 'pseudo',
                    'idField' => 'pseudo-Register',
                    'placeholder' => 'Pseudo',
                    'required' => 'required',
                    'maxlength' => 50,
                    'validators' => [
                        new NotEmptyValidator('Merci de spécifier un pseudo pour vous nommer sur le site.'),
                        new MaxLengthValidator('Le pseudo spécifié est trop long (50 caractères maximum)', 50),
                        new UniqueValidator('Ce pseudo est déjà utilisé, veuillez en choisir un autre.', $this->pseudos),
                    ],
                ])
            )
            ->addField(
                new InputTextField([
                    'name' => 'confirmPseudo',
                    'idField' => 'confirm-pseudo-Register',
                    'placeholder' => 'Confirmer votre pseudo',
                    'maxlength' => 50,
                    'validators' => [
                        new MaxLengthValidator('Le pseudo spécifié est trop long (50 caractères maximum)', 50),
                        new HoneypotValidator('Cette valeur n\'est pas correcte'),
                    ],
                ])
            )
            ->addField(
                new InputEmailField([
                    'textLabel' => 'Adresse Email',
                    'name' => 'email',
                    'idField' => 'email',
                    'placeholder' => 'Adresse Email',
                    'required' => 'required',
                    'maxlength' => 250,
                    'validators' => [
                        new NotEmptyValidator('Merci de spécifier votre email.'),
                        new MaxLengthValidator('L\'email spécifié est trop long (250 caractères maximum)', 250),
                        new UniqueValidator('Cet email est déjà utilisé, veuillez en choisir un autre.', $this->emails),
                    ],
                ])
            )
            ->addField(
                new InputEmailField([
                    'name' => 'confirmEmail',
                    'idField' => 'confirm-email',
                    'placeholder' => 'Confirmez votre adresse email',
                    'required' => 'required',
                    'maxlength' => 250,
                    'validators' => [
                        new NotEmptyValidator('Merci de confirmer votre adresse email.'),
                        new MaxLengthValidator('L\'email spécifié est trop long (250 caractères maximum)', 250),
                        new ValuesEqualityValidator(
                            'L\'email de confirmation doit être identique au premier email',
                            $this->getValueField('email')
                        ),
                    ],
                ])
            )
            ->addField(
                new InputPasswordField([
                    'textLabel' => 'Mot de passe',
                    'name' => 'password',
                    'idField' => 'password-register',
                    'placeholder' => 'Mot de passe avec au moins 1 majuscule, 1 chiffre et 8 caractères en tout',
                    'title' => 'Il faut au moins 1 majuscule, 1 chiffre et 8 caractères en tout',
                    'pattern' => '/^(?=.*[A-Z])(?=.*\d).+$/',
                    'required' => 'required',
                    'maxlength' => 250,
                    'minlength' => 8,
                    'validators' => [
                        new NotEmptyValidator('Merci de spécifier votre mot de passe'),
                        new MaxLengthValidator('Le mot de passe spécifié est trop long (100 caractères maximum)', 250),
                        new MinLengthValidator('Le mot de passe spécifié est trop court (8 caractères minimum)', 8),
                        new RegexValidator(
                            'Le mot de passe spécifié doit contenir au moins 1 majuscule et 1 chiffre.', 
                            '/^(?=.*[A-Z])(?=.*\d).+$/'
                        ),
                    ],
                ])
            )
            ->addField(
                new InputPasswordField([
                    'name' => 'confirmPassword',
                    'idField' => 'confirm-password',
                    'placeholder' => 'Confirmer votre mot de passe',
                    'title' => 'Il faut au moins 1 majuscule, 1 chiffre et 8 caractères en tout',
                    'pattern' => '/^(?=.*[A-Z])(?=.*\d).+$/',
                    'required' => 'required',
                    'maxlength' => 250,
                    'minlength' => 8,
                    'validators' => [
                        new NotEmptyValidator('Merci de confirmer votre mot de passe.'),
                        new ValuesEqualityValidator(
                            'Le mot de passe de confirmation doit être identique au premier mot de passe',
                            $this->getValueField('password')
                        ),
                    ],
                ])
            )
        ;

        return $this;
    }
}
