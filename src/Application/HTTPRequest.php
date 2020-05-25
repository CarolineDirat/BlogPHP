<?php

namespace App\Application;

use App\Entity\User;

/**
 * To represent the client's request.
 */
final class HTTPRequest
{
    /**
     * get a cookie variable if it exists.
     *
     * @return mixed string || false if the filter fails || null if $key does'nt exist
     */
    public function cookieData(string $key)
    {
        return filter_input(INPUT_COOKIE, $key, FILTER_SANITIZE_STRING);
    }

    /**
     * to know if a cookie variable exist.
     */
    public function hasCookie(string $key): bool
    {
        return filter_has_var(INPUT_COOKIE, $key);
    }

    /**
     * get a session variable if it exists.
     *
     * @return mixed string or false if the filter fails
     */
    public function getSession(string $key)
    {
        return filter_var($_SESSION[$key], FILTER_SANITIZE_STRING, []);
    }

    /**
     * setSession.
     *
     * edit or create a session variable
     */
    public function setSession(string $key, string $value): void
    {
        $_SESSION[$key] = filter_var($value, FILTER_SANITIZE_STRING, []);
    }

    public function getUserSession(): User
    {
        return $_SESSION['user'];
    }
    
    public function setUserSession(User $user): void
    {
        $_SESSION['user'] = $user;
    }

    /**
     * unsetSession.
     *
     * delete a session variable
     */
    public function unsetSession(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * get a GET variable if it exists.
     *
     * @return mixed string || false if the filter fails || null if $key does'nt exist
     */
    public function getData(string $key)
    {
        return filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
    }

    /**
     * to know if a GET variable exist.
     */
    public function hasGet(string $key): bool
    {
        return filter_has_var(INPUT_GET, $key);
    }

    /**
     * get a POST variable if it exists.
     *
     * @return mixed string || false if the filter fails || null if $key does'nt exist
     */
    public function postData(string $key)
    {
        if ('email' === $key || 'email1' === $key || 'email2' === $key) {
            $sanitizedEmail = filter_input(INPUT_POST, $key, FILTER_SANITIZE_EMAIL);

            return filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL);
        }

        return filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
    }

    /**
     * to know if a POST variable exist.
     */
    public function hasPost(string $key): bool
    {
        return filter_has_var(INPUT_POST, $key);
    }

    /**
     * get the URI that was provided to access this page. For example: '/index.php'.
     *
     * @return mixed string || false if the filter fails || null if $key does'nt exist
     */
    public function requestURI()
    {
        return filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING);
    }

    /**
     * Request method used to access the page; for example 'GET', 'HEAD', 'POST', 'PUT'.
     *
     * @return mixed string || false if the filter fails || null if $key does'nt exist
     */
    public function method()
    {
        return filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);
    }
}
