<?php
namespace App\Application;

/**
 * to represent the client's request
 */
final class HTTPRequest // extends ApplicationComponent
{
    /**
     * get a cookie variable if it exists
     *
     * @param  string $key
     * @return mixed
     */
    public function cookieData($key)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }
   
    /**
     * to know if a cookie variable exist
     *
     * @param  string $key
     * @return bool
     */
    public function cookieExists($key)
    {
        return isset($_COOKIE[$key]);
    }

    /**
     * get a session variable if it exists
     *
     * @param  string $key
     * @return mixed
     */
    public function sessionData($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
   
    /**
     * to know if a session variable exist
     *
     * @param  string $key
     * @return bool
     */
    public function sessionExists($key)
    {
        return isset($_SESSION[$key]);
    }
   
    /**
     * get a GET variable if it exists
     *
     * @param  string $key
     * @return mixed
     */
    public function getData($key)
    {
        return isset($_GET[$key]) ? htmlspecialchars($_GET[$key]) : null;
    }
   
    /**
     * to know if a GET variable exist
     *
     * @param  string $key
     * @return bool
     */
    public function getExists($key)
    {
        return isset($_GET[$key]);
    }
   
    /**
     * get a POST variable if it exists
     *
     * @param  string $key
     * @return mixed
     */
    public function postData($key)
    {
        return isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : null;
    }
   
    /**
     * to know if a POST variable exist
     *
     * @param  string $key
     * @return bool
     */
    public function postExists($key)
    {
        return isset($_POST[$key]);
    }
   
    /**
     * get the URI that was provided to access this page. For example: '/index.php'.
     *
     * @return string
     */
    public function requestURI()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Request method used to access the page; for example 'GET', 'HEAD', 'POST', 'PUT'.
     *
     * @return string
     */
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
