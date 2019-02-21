<?php

namespace gone\responses\interfaces;

interface ResponseInterface{
    public function protocolVersion($protocol_version = null);

    public function body($body = null);

    public function status();

    public function headers();

    public function cookies();

    public function code($code = null);

    public function prepend($content);

    public function append($content);

    public function isLocked();

    public function requireUnlocked();

    public function lock();

    public function unlock();

    public function sendHeaders($override = false);

    public function sendCookies($override = false);

    public function sendBody();

    public function send();

    public function isSent();

    public function chunk($str = null);

    public function header($key, $value = null);

    public function cookie($key, $value = '', $expiry = null, $path = '/', $domain = null, $secure = false, $httponly = false);

    public function noCache();

    public function redirect($url, $code = 302);

    public function dump($obj);

    public function file($path, $filename = null);

    public function json($object, $jsonp_prefix = null);
}