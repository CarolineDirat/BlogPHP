<?php

namespace App\Application;

use App\Entity\User;

/**
 * To represent the client's request.
 */
final class HTTPRequest
{
    public function __construct()
    {
        session_start();
    }
    
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
     * generateToken.
     *
     * Generate a token and its duration and save them in session
     *
     * @return void
     */
    public function generateToken(): void
    {
        $this->setSession('token', sha1(random_bytes(32)));
        $_SESSION['token_time'] = time();
    }

    /**
     * getTokenTime.
     *
     * get token_time session
     *
     * @return int
     */
    public function getTokenTime(): int
    {
        $tokenTime = isset($_SESSION['token_time']) ? filter_var($_SESSION['token_time'], FILTER_VALIDATE_INT, []) : false;

        return !empty($tokenTime) ? $tokenTime : 0;
    }

    /**
     * get a string session variable if it exists.
     *
     * @return ?string or false if the filter fails
     */
    public function getSession(string $key): ?string
    {
        $session = isset($_SESSION[$key]) ? filter_var($_SESSION[$key], FILTER_SANITIZE_STRING, []) : null;

        return  !empty($session) ? $session : null;
    }

    /**
     * setSession.
     *
     * edit or create a string session variable
     */
    public function setSession(string $key, string $value): void
    {
        $_SESSION[$key] = filter_var($value, FILTER_SANITIZE_STRING, []);
    }
    
    /**
     * hasSession
     * 
     * checks if a variable exists in $_SESSION[$key]
     *
     * @param  string $key
     * @return bool
     */
    public function hasSession(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * getUserSession.
     *
     * @return ?User
     */
    public function getUserSession(): ?User
    {
        return (!empty($_SESSION['user'])) ? $_SESSION['user'] : null;
    }

    /**
     * setUserSession.
     *
     * @param  User $user
     * @return void
     */
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
        if ('email' === $key || 'confirmEmail' === $key || 'email1' === $key || 'email2' === $key) {
            $sanitizedEmail = filter_input(INPUT_POST, $key, FILTER_SANITIZE_EMAIL);

            return filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL);
        }

        return filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
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
