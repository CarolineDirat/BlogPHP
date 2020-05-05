<?php
namespace App\Application;

abstract class AbstractController
{
    /**
     * the resquest action, to know the name of the method to execute
     *
     * @var string
     */
    protected $action = '';
    /**
     * the name of the request page, to know the name of the method to execute
     *
     * @var string
     */
    protected $page = '';
    /**
     * the client's request
     *
     * @var HTTPRequest
     */
    protected $httpRequest;
   
    public function __construct(string $action, string $page, HTTPRequest $httpRequest)
    {
        $this->setAction($action);
        $this->setPage($page);
        $this->setHTTPRequest($httpRequest);
    }
                
    /**
     * to execute a method corresponding to the action and the page of the request
     *
     * @return HTTPResponse
     */
    public function execute() : HTTPResponse
    {
        $method = 'execute'.ucfirst($this->action).ucfirst($this->page);

        if (!is_callable([$this, $method])) {
            throw new \RuntimeException('L\'action "'.$this->action.'" n\'est pas définie sur cette page');
        }

        return $this->$method($this->httpRequest);
    }

    public function setPage(string $page) : void
    {
        if (!is_string($page) || empty($page)) {
            throw new \InvalidArgumentException('Le page doit être une chaine de caractères valide');
        }

        $this->page = $page;
    }

    public function getPage() : string
    {
        return $this->page;
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
