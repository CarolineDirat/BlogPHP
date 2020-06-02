<?php

namespace App\Application;

class Route 
{    
    /**
     * module
     *
     * @var string
     */
    private string $module;

    /**
     * action
     *
     * @var string
     */
    private string $action;

    /**
     * action
     *
     * @var string
     */
    private string $page;

    public function __construct(string $module, string $action, string $page)
    {
        $this
            ->setModule($module)
            ->setAction($action)
            ->setPage($page)
        ;

    }

    /**
     * Get module
     *
     * @return  string
     */ 
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * Set module
     *
     * @param  string  $module  module
     *
     * @return  self
     */ 
    public function setModule(string $module): self
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get action
     *
     * @return  string
     */ 
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Set action
     *
     * @param  string  $action  action
     *
     * @return  self
     */ 
    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return  string
     */ 
    public function getPage(): string
    {
        return $this->page;
    }

    /**
     * Set action
     *
     * @param  string  $page  action
     *
     * @return  self
     */ 
    public function setPage(string $page): self
    {
        $this->page = $page;

        return $this;
    }
}
