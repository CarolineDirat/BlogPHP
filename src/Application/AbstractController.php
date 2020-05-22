<?php

namespace App\Application;

use RuntimeException;

abstract class AbstractController
{
    /**
     * the resquest action, to know the name of the method to execute.
     *
     * @var string
     */
    protected $action = '';
    /**
     * the name of the request page, to know the name of the method to execute.
     *
     * @var string
     */
    protected $page = '';
    /**
     * the client's request.
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
     * to execute a method corresponding to the action and the page of the request.
     */
    public function execute(): HTTPResponse
    {
        $method = 'execute'.ucfirst($this->action).ucfirst($this->page);

        if (!is_callable([$this, $method])) {
            throw new RuntimeException('The execute'.ucfirst($this->action).ucfirst($this->page).' controller is not defined for this page');
        }

        return $this->{$method}($this->httpRequest);
    }

    public function setPage(string $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getPage(): string
    {
        return $this->page;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setHTTPRequest(HTTPRequest $httpRequest): self
    {
        $this->httpRequest = $httpRequest;

        return $this;
    }

    public function getHTTPRequest(): HTTPRequest
    {
        return $this->httpRequest;
    }
}
