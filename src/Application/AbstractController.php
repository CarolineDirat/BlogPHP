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
    protected $view = '';
    /**
     * httpRequest
     *
     * @var HTTPRequest
     */
    protected $httpRequest;
    
    

    public function __construct(string $action, string $view, HTTPRequest $httpRequest)
    {
        $this->setAction($action);
        $this->setView($view);
        $this->setHTTPRequest($httpRequest);
    }
                
    /**
     * to execute a method corresponding to the action of the request
     *
     * @return void
     */
    public function execute() : void
    {
        $method = 'execute'.ucfirst($this->action).ucfirst($this->view);

        if (!is_callable([$this, $method])) {
            throw new \RuntimeException('L\'action "'.$this->action.'" n\'est pas définie sur ce view');
        }

        $this->$method($this->httpRequest);
    }

    public function setView(string $view) : void
    {
        if (!is_string($view) || empty($view)) {
            throw new \InvalidArgumentException('Le view doit être une chaine de caractères valide');
        }

        $this->view = $view;
    }

    public function getView() : string
    {
        return $this->view;
    }

    public function setAction(string $action) : void
    {
        if (!is_string($action) || empty($action)) {
            throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
        }

        $this->action = $action;
    }

    public function getAction() : string
    {
        return $this->action;
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
