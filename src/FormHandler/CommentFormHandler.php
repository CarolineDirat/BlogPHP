<?php

namespace App\FormHandler;

use App\Application\Form\Form;
use App\Application\Form\FormHandler;
use App\Application\HTTPRequest;
use App\Entity\Comment;
use App\Model\CommentManagerPDO;

class CommentFormHandler extends FormHandler
{
    private CommentManagerPDO $manager;

    public function __construct(Form $form, CommentManagerPDO $manager, HTTPRequest $httpRequest)
    {
        parent::__construct($form, $httpRequest);
        $this->setManager($manager);
    }

    /**
     * process.
     *
     * check form validity, then if it's ok, save the comment in database
     *
     * @return bool
     */
    public function process(): bool
    {
        $comment = $this->form->getEntity();
        if ($comment instanceof Comment && $this->form->isValid()) {
            return $this->manager->save($comment);
        }

        return false;
    }

    /**
     * Set the value of manager.
     *
     * @return self
     */
    public function setManager(CommentManagerPDO $manager): self
    {
        $this->manager = $manager;

        return $this;
    }
}
