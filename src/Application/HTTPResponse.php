<?php

namespace App\Application;

/**
 * HTTPResponse
 *
 * to represent the controller's response
 */
final class HTTPResponse
{
    /**
     * page
     *
     * to deduce the template to use
     *
     * @var string
     */
    private $page;

    /**
     * params
     *
     * data to be transmitted to the view
     *
     * @var array
     */
    private $params;


    public function __construct(string $page, array $params = [])
    {
        $this->setPage($page);
        $this->setParams($params);
    }
    
    public function getPage() : string
    {
        return $this->page;
    }

    public function getParams() : array
    {
        return $this->params;
    }

    public function setPage(string $page) : void
    {
        $this->page = $page;
    }

    public function setParams(array $params) : void
    {
        $this->params = $params;
    }
}
