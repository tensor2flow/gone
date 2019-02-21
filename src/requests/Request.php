<?php

namespace gone\requests;

use gone\collections\Listed;
use gone\utils\Server;
use gone\utils\Headers;

class Request extends \stdClass
{
    protected $id;
    
    protected $params_get;
    
    protected $params_post;
    
    protected $params_named;
    
    protected $cookies;
    
    protected $server;
    
    protected $headers;

    protected $files;

    protected $body;

    public function __construct(
        array $params_get = array(),
        array $params_post = array(),
        array $cookies = array(),
        array $server = array(),
        array $files = array(),
        $body = null
    ) {
        $this->params_get   = new Listed($params_get);
        $this->params_post  = new Listed($params_post);
        $this->cookies      = new Listed($cookies);
        $this->server       = new Server($server);
        $this->headers      = new Headers($this->server->getHeaders());
        $this->files        = new Listed($files);
        $this->body         = $body ? (string) $body : null;
        $this->params_named = new Listed();
    }

    public static function createFromGlobals()
    {
        return new static($_GET, $_POST, $_COOKIE, $_SERVER, $_FILES, null);
    }
    
    public function id($hash = true)
    {
        if (null === $this->id) {
            $this->id = uniqid();
            if ($hash) {
                $this->id = sha1($this->id);
            }
        }
        return $this->id;
    }
    
    public function paramsGet()
    {
        return $this->params_get;
    }
    
    public function paramsPost()
    {
        return $this->params_post;
    }
    
    public function paramsNamed()
    {
        return $this->params_named;
    }
    
    public function cookies()
    {
        return $this->cookies;
    }
    
    public function server()
    {
        return $this->server;
    }
    
    public function headers()
    {
        return $this->headers;
    }
    
    public function files()
    {
        return $this->files;
    }
    
    public function body()
    {
        if (null === $this->body) {
            $this->body = @file_get_contents('php://input');
        }
        return $this->body;
    }
    
    public function params($mask = null, $fill_with_nulls = true)
    {
        if (null !== $mask && $fill_with_nulls) {
            $attributes = array_fill_keys($mask, null);
        } else {
            $attributes = array();
        }
        return array_merge(
            $attributes,
            $this->params_get->all($mask, false),
            $this->params_post->all($mask, false),
            $this->cookies->all($mask, false),
            $this->params_named->all($mask, false)
        );
    }

    public function param($key, $default = null)
    {
        $params = $this->params();
        return isset($params[$key]) ? $params[$key] : $default;
    }
    
    public function __isset($param)
    {
        $params = $this->params();
        return isset($params[$param]);
    }
    
    public function __get($param)
    {
        return $this->param($param);
    }
    
    public function __set($param, $value)
    {
        $this->params_named->set($param, $value);
    }
    
    public function __unset($param)
    {
        $this->params_named->remove($param);
    }
    
    public function isSecure()
    {
        return ($this->server->get('HTTPS') == true);
    }
    
    public function ip()
    {
        return $this->server->get('REMOTE_ADDR');
    }
    
    public function userAgent()
    {
        return $this->headers->get('USER_AGENT');
    }
    
    public function uri()
    {
        return $this->server->get('REQUEST_URI', '/');
    }
    
    public function pathname()
    {
        $uri = $this->uri();
        $uri = strstr($uri, '?', true) ?: $uri;
        return $uri;
    }

    public function method($is = null, $allow_override = true)
    {
        $method = $this->server->get('REQUEST_METHOD', 'GET');
        if ($allow_override && $method === 'POST') {
            if ($this->server->exists('X_HTTP_METHOD_OVERRIDE')) {
                $method = $this->server->get('X_HTTP_METHOD_OVERRIDE', $method);
            } else {
                $method = $this->param('_method', $method);
            }
            $method = strtoupper($method);
        }
        if (null !== $is) {
            return strcasecmp($method, $is) === 0;
        }
        return $method;
    }
    
    public function query($key, $value = null)
    {
        $query = array();
        parse_str(
            $this->server()->get('QUERY_STRING'),
            $query
        );
        if (is_array($key)) {
            $query = array_merge($query, $key);
        } else {
            $query[$key] = $value;
        }
        $request_uri = $this->uri();
        if (strpos($request_uri, '?') !== false) {
            $request_uri = strstr($request_uri, '?', true);
        }
        return $request_uri . (!empty($query) ? '?' . http_build_query($query) : null);
    }
}