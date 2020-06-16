<?php

namespace App\Application;

use Exception;

abstract class Application
{
    /**
     * httpRequest.
     *
     * @var HTTPRequest
     */
    protected HTTPRequest $httpRequest;

    /**
     * twigRenderer.
     *
     * @var TwigRenderer
     */
    protected TwigRenderer $twigRenderer;

    /**
     * router.
     *
     * @var Router
     */
    protected Router $router;

    /**
     * module.
     *
     * name of the application module (public or admin)
     *
     * @var string
     */
    protected string $module = '';

    public function __construct(HTTPRequest $httpRequest)
    {
        $this->setHttpRequest($httpRequest);
        $this->setTwigRenderer(new TwigRenderer('../templates'));
        $this->setRouter(new Router());
        $this->checkToken();
    }
    
    /**
     * checkToken
     * 
     * delete user session and his tokens, if tokens exists and expired
     *
     * @return void
     */
    public function checkToken(): void
    {
        $httpRequest = $this->getHttpRequest();
        if (
            !empty($httpRequest->getSession('token')) &&
            $httpRequest->getTokenTime() <= (time() - LENGTH_SESSION)
        ) {
            $httpRequest->unsetSession('user');
            $httpRequest->unsetSession('token');
            $httpRequest->unsetSession('token_time');
        }
    }

    /**
     * run.
     *
     * method which will execute the application
     *
     * @return void
     */
    abstract public function run(): void;

    /**
     * implementController.
     *
     * define and execute the controller
     *
     * @return void
     */
    public function implementController(string $action, string $page): void
    {
        $classController = 'App\\Controller\\'.ucfirst($page).ucfirst($this->getModule()).'Controller';
        if (!class_exists($classController)) {
            throw new Exception($classController."controller doesn't exist");
        }
        $controller = new $classController($action, $page, $this->getHttpRequest());
        $controller->execute()->send($this->twigRenderer);
    }

    /**
     * Get httpRequest.
     *
     * @return HTTPRequest
     */
    public function getHttpRequest(): HTTPRequest
    {
        return $this->httpRequest;
    }

    /**
     * Set httpRequest.
     *
     * @return self
     */
    public function setHttpRequest(HTTPRequest $httpRequest): self
    {
        $this->httpRequest = $httpRequest;

        return $this;
    }

    /**
     * Set twigRenderer.
     *
     * @param TwigRenderer $twigRenderer twigRenderer
     *
     * @return self
     */
    public function setTwigRenderer(TwigRenderer $twigRenderer): self
    {
        $this->twigRenderer = $twigRenderer;

        return $this;
    }

    /**
     * Get router.
     *
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * Set router.
     *
     * @param Router $router router
     *
     * @return self
     */
    public function setRouter(Router $router): self
    {
        $this->router = $router;

        return $this;
    }

    /**
     * Get name of the application module (public or admin).
     *
     * @return string
     */
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * Set name of the application module (public or admin).
     *
     * @param string $module name of the application module (public or admin)
     *
     * @return self
     */
    public function setModule(string $module): self
    {
        $this->module = $module;

        return $this;
    }
}
