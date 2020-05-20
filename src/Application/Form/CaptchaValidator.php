<?php

namespace App\Application\Form;

use App\Application\HTTPRequest;
use Gregwar\Captcha\PhraseBuilder;

/**
 * CaptchaValidator
 * 
 * checks captcha phrase value
 */
class CaptchaValidator extends Validator
{
    private HTTPRequest $httpRequest;

    public function __construct(string $errorMesssage, HTTPRequest $httpRequest)
    {
        parent::__construct($errorMesssage);
        $this->setHttpRequest($httpRequest); 
    }

    public function isValid(?string $value): bool
    {
        return PhraseBuilder::comparePhrases($this->httpRequest->getSession('captchaPhrase'), $value);
    }

    /**
     * Get the value of httpRequest
     */ 
    public function getHttpRequest(): HTTPRequest
    {
        return $this->httpRequest;
    }

    /**
     * Set the value of httpRequest
     * 
     * @param HTTPRequest $httpRequest
     *
     * @return  self
     */ 
    public function setHttpRequest(HTTPRequest $httpRequest): self
    {
        $this->httpRequest = $httpRequest;

        return $this;
    }
}
