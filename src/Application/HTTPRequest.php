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
     * @return string
     */
    public function cookieData(string $key)
    {
        return filter_input(INPUT_COOKIE, $key, FILTER_SANITIZE_STRING);
    }
   
    /**
     * to know if a cookie variable exist
     *
     * @param  string $key
     * @return bool
     */
    public function hasCookie(string $key)
    {
        return filter_has_var(INPUT_COOKIE, $key);
    }
       
    /**
     * get a GET variable if it exists
     *
     * @param  string $key
     * @return string
     */
    public function getData(string $key)
    {
        return filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
    }
   
    /**
     * to know if a GET variable exist
     *
     * @param  string $key
     * @return bool
     */
    public function hasGet(string $key)
    {
        return filter_has_var(INPUT_GET, $key);
    }
   
    /**
     * get a POST variable if it exists
     *
     * @param  string $key
     * @return string
     */
    public function postData(string $key)
    {
        if ($key === 'email' || $key === 'email1' || $key === 'email2') {
            $sanitizedEmail = filter_input(INPUT_POST, $key, FILTER_SANITIZE_EMAIL);
            return filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL);
        }
        return filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
    }
   
    /**
     * to know if a POST variable exist
     *
     * @param  string $key
     * @return bool
     */
    public function hasPost(string $key)
    {
        return filter_has_var(INPUT_POST, $key);
    }
   
    /**
     * get the URI that was provided to access this page. For example: '/index.php'.
     *
     * @return string
     */
    public function requestURI()
    {
        return filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING);
    }

    /**
     * Request method used to access the page; for example 'GET', 'HEAD', 'POST', 'PUT'.
     *
     * @return string
     */
    public function method()
    {
        return filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);
    }
}
