<?php

namespace App\FormHandler;

use App\Application\Form\Form;
use App\Application\Form\FormHandler;
use App\Application\HTTPRequest;
use App\Entity\Post;
use App\Model\PostManagerPDO;

class PostFormHandler extends FormHandler
{
    private PostManagerPDO $manager;

    public function __construct(Form $form, PostManagerPDO $manager, HTTPRequest $httpRequest)
    {
        parent::__construct($form, $httpRequest);
        $this->setManager($manager);
    }

    /**
     * process.
     *
     * check form validity, then if it's ok, save the Post in database
     */
    public function process(): bool
    {
        $post = $this->form->getEntity();
        if ($post instanceof Post && $this->form->isValid()) {
            return $this->manager->save($post);
        }

        return false;
    }

    /**
     * Set the value of manager.
     */
    public function setManager(PostManagerPDO $manager): self
    {
        $this->manager = $manager;

        return $this;
    }
}
