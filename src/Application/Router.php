<?php

namespace App\Application;

use DOMDocument;
use Exception;


class Router 
{    
    /**
     * routes
     *
     * @var Route[]
     */
    private array $routes = [];
    
    /**
     * addRoute
     * 
     * add a route in the array routes property of the router
     *
     * @param  Route $route
     * @return void
     */
    public function addRoute(Route $route): void
    {
        if (!in_array($route, $this->routes)) {
            $this->routes[] = $route;
        }

    }
        
    /**
     * loadRoutes
     * 
     * load routes in the router from configutation xml file
     *
     * @return void
     */
    public function loadRoutes(): void
    {
        $xml = new DOMDocument();//http://blogphp/
        $xml->load(str_replace('src\Application','',__DIR__).'\config\routes.xml');
        $routes = $xml->getElementsByTagName('route');
        foreach ($routes as $route) {
            $this->addRoute(new Route(
                $route->getAttribute('module'),
                $route->getAttribute('action'),
                $route->getAttribute('page'),
            ));
        }
    }
    
    /**
     * checkRoute
     * 
     * check if a route exists 
     *
     * @param  Route $route
     * @return void
     */
    public function checkRoute(Route $route): void
    {
        $this->loadRoutes();
        if (!in_array($route, $this->getRoutes())) {
            throw new Exception("No Route corresponding to the Request");
        }
    }

    /**
     * Get routes
     *
     * @return  Route[]
     */ 
    public function getRoutes(): array
    {
        return $this->routes;
    }
}


    
