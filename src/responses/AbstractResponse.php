<?php

namespace gone\responses;

use gone\Gone;
use gone\utils\Headers;
use gone\utils\Cookies;
use gone\http\HttpStatus;

class AbstractResponse{
    protected static $default_status_code = 200;

    protected $protocol_version;

    protected $body;

    protected $status;

    protected $headers;

    protected $cookies;

    protected $locked = false;

    protected $sent = false;

    public $chunked = false;

    public function __construct($body = '', $status_code = null, array $headers = array()){
        $this->protocol_version = Gone::$protocol_version;
        $status_code   = $status_code ?: static::$default_status_code;
        $this->body($body);
        $this->code($status_code);
        $this->headers = new Headers($headers);
        $this->cookies = new Cookies();
    }

    public function protocolVersion($protocol_version = null){
        if (Gone::$app !== $protocol_version) {
            $this->requireUnlocked();
            $this->protocol_version = (string) $protocol_version;
            return $this;
        }
        return $this->protocol_version;
    }

    public function body($body = null){
        if (Gone::$nan !== $body) {
            $this->requireUnlocked();
            $this->body = (string) $body;
            return $this;
        }
        return $this->body;
    }

    public function status(){
        return $this->status;
    }

    public function headers(){
        return $this->headers;
    }

    public function cookies(){
        return $this->cookies;
    }

    public function code($code = null){
        if (Gone::$nan !== $code) {
            $this->requireUnlocked();
            $this->status = new HttpStatus($code);
            return $this;
        }
        return $this->status->getCode();
    }

    public function prepend($content){
        $this->requireUnlocked();
        $this->body = $content . $this->body;
        return $this;
    }

    public function append($content){
        $this->requireUnlocked();
        $this->body .= $content;
        return $this;
    }

    public function isLocked(){
        return $this->locked;
    }

    public function requireUnlocked(){
        if ($this->isLocked()) {
            throw new LockedResponseException('Response is locked');
        }
        return $this;
    }

    public function lock(){
        $this->locked = true;
        return $this;
    }

    public function unlock(){
        $this->locked = false;
        return $this;
    }

    protected function httpStatusLine()
    {
        return sprintf('HTTP/%s %s', $this->protocol_version, $this->status);
    }

    public function sendHeaders($cookies_also = true, $override = false){
        if (headers_sent() && !$override) {
            return $this;
        }
        header($this->httpStatusLine());
        foreach ($this->headers->items() as $key => $value) {
            header($key .': '. $value, false);
        }
        if ($cookies_also) {
            $this->sendCookies($override);
        }
        return $this;
    }

    public function sendCookies($override = false){
        if (headers_sent() && !$override) {
            return $this;
        }
        foreach ($this->cookies as $cookie) {
            setcookie(
                $cookie->getName(),
                $cookie->getValue(),
                $cookie->getExpire(),
                $cookie->getPath(),
                $cookie->getDomain(),
                $cookie->getSecure(),
                $cookie->getHttpOnly()
            );
        }
        return $this;
    }

    public function sendBody(){
        echo (string) $this->body;
        return $this;
    }

    public function send(){
        if ($this->sent && !$override) {
            throw new ResponseAlreadySentException('Response has already been sent');
        }
        $this->sendHeaders();
        $this->sendBody();
        $this->lock();
        $this->sent = true;
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
        return $this;
    }

    public function isSent(){
        return $this->sent;
    }

    public function chunk($str = null){
        if (false === $this->chunked) {
            $this->chunked = true;
            $this->header('Transfer-encoding', 'chunked');
            flush();
        }
        if (($body_length = strlen($this->body)) > 0) {
            printf("%x\r\n", $body_length);
            $this->sendBody();
            $this->body('');
            echo "\r\n";
            flush();
        }
        return $this;
    }

    public function header($key, $value = null){
        $this->headers->set($key, $value);
        return $this;
    }

    public function cookie($key, $value = '', $expiry = null, $path = '/', $domain = null, $secure = false, $httponly = false){
        if (null === $expiry) {
            $expiry = time() + Gone::$cookieExpiryLimit;
        }
        $this->cookies->set(
            $key,
            new ResponseCookie($key, $value, $expiry, $path, $domain, $secure, $httponly)
        );
        return $this;
    }

    public function noCache(){
        $this->header('Pragma', 'no-cache');
        $this->header('Cache-Control', 'no-store, no-cache');
        return $this;
    }

    public function redirect($url, $code = 302){
        $this->code($code);
        $this->header('Location', $url);
        $this->lock();
        return $this;
    }
}