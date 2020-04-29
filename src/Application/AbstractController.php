<?php
namespace App\Application;

abstract class AbstractController // extends ApplicationComponent
{
    /**
     * @var string
     */
    protected $action = '';
    /**
     * @var string
     */
    protected $module = '';
    /**
     * httpRequest
     *
     * @var HTTPRequest
     */
    protected $httpRequest;
    
    //protected $page = null;
    //protected $view = '';

    public function __construct(string $action, string $module, HTTPRequest $httpRequest)
    {
        $this->setAction($action);
        $this->setModule($module);
        $this->setHTTPRequest($httpRequest);
    }
                
    /**
     * to execute a method corresponding to the action of the request
     *
     * @return void
     */
    public function execute() : void
    {
        $method = 'execute'.ucfirst($this->action);

        if (!is_callable([$this, $method])) {
            throw new \RuntimeException('L\'action "'.$this->action.'" n\'est pas définie sur ce module');
        }

        $this->$method($this->httpRequest);
    }

    public function setModule(string $module) : void
    {
        if (!is_string($module) || empty($module)) {
            throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
        }

        $this->module = $module;
    }

    public function setAction(string $action) : void
    {
        if (!is_string($action) || empty($action)) {
            throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
        }

        $this->action = $action;
    }

    public function getHTTPRequest() : HTTPRequest
    {
        return $this->httpRequest;
    }

    public function setHTTPRequest(HTTPRequest $httpRequest) : void
    {
        if (!$httpRequest instanceof HTTPRequest) {
            throw new \InvalidArgumentException('La requête du client doit être une instance de \App\Application\HTTPRequest');
        }
        $this->httpRequest = $httpRequest;
    }
}
