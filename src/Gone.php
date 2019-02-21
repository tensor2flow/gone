<?php

namespace gone;

class Gone{
    public static $app;
    public static $request;
    public static $response;
    public static $service;
    public static $configs;

    public static $nan = null;
    public static $protocol_version = '1.1';
    public static $cookieExpiryLimit = (3600 * 24 * 30);
}