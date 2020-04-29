<?php
namespace App\Application;

abstract class AbstractController // extends ApplicationComponent
{
    protected $action = '';
    protected $module = '';
    protected $httpRequest;
    protected $twig;
    //protected $page = null;
    //protected $view = '';

    public function __construct($action, $module, HTTPRequest $httpRequest)
    {
        $this->setAction($action);
        $this->setModule($module);
        $this->httpRequest = $httpRequest;
    }
        
    public function execute()
    {
        $method = 'execute'.ucfirst($this->action);

        if (!is_callable([$this, $method]))
        {
        throw new \RuntimeException('L\'action "'.$this->action.'" n\'est pas définie sur ce module');
        }

        $this->$method($this->httpRequest);
    }

    public function setModule($module)
    {
        if (!is_string($module) || empty($module))
        {
        throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
        }

        $this->module = $module;
    }

    public function setAction($action)
    {
        if (!is_string($action) || empty($action))
        {
        throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
        }

        $this->action = $action;
    }

    public function getHTTPRequest()
    {
        return $this->httpRequest;
    }

    public function setHTTPReques($httpRequest)
    { 
        if(!$httpRequest instanceof HTTPRequest)
        {
            throw new \InvalidArgumentException('La requête du client doit être une instance de \App\Application\HTTPRequest');
        }
        $this->httpRequest = $httpRequest;
    }
}
