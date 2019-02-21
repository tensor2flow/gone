<?php

namespace gone\responses;

use RuntimeException;
use gone\Gone;
use gone\exceptions\ResponseAlreadySentException;
use gone\responses\AbstractResponse;
use gone\responses\interfaces\ResponseInterface;

class Response extends AbstractResponse implements ResponseInterface{
    public function chunk($str = null){
        parent::chunk($str);
        if (Gone::$nan !== $str) {
            printf("%x\r\n", strlen($str));
            echo "$str\r\n";
            flush();
        }
        return $this;
    }

    public function dump($obj){
        if (is_array($obj) || is_object($obj)) {
            $obj = print_r($obj, true);
        }
        $this->append('<pre>' .  htmlentities($obj, ENT_QUOTES) . "</pre><br />\n");
        return $this;
    }

    public function file($path, $filename = null){
        if ($this->sent) {
            throw new ResponseAlreadySentException('Response has already been sent');
        }
        $this->body('');
        $this->noCache();
        if (null === $filename) {
            $filename = basename($path);
        }
        if (null === $mimetype) {
            $mimetype = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path);
        }
        $this->header('Content-type', $mimetype);
        $this->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
        if (false === $this->chunked) {
            $this->header('Content-length', filesize($path));
        }
        $this->sendHeaders();
        $bytes_read = readfile($path);
        if (false === $bytes_read) {
            throw new RuntimeException('The file could not be read');
        }
        $this->sendBody();
        $this->lock();
        $this->sent = true;
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
        return $this;
    }

    public function json($object, $jsonp_prefix = null){
        $this->body('');
        $this->noCache();
        $json = json_encode($object);
        if (Gone::$nan !== $jsonp_prefix) {
            $this->header('Content-Type', 'text/javascript');
            $this->body("$jsonp_prefix($json);");
        } else {
            $this->header('Content-Type', 'application/json');
            $this->body($json);
        }
        $this->send();
        return $this;
    }
}