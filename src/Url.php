<?php

/*
 * (C) 2018, AII (Alexey Ilyin).
 */

namespace Ailixter\Gears;

use Ailixter\Gears\Url\ParsedData;

/**
 * @property string $scheme
 * @property string $host
 * @property int    $port
 * @property string $user
 * @property string $pass
 * @property string $path
 * @property array  $query
 * @property string $fragment
 * @author AII (Alexey Ilyin)
 */
class Url 
{
    /**
     * @var ParsedData
     */
    protected $parsed;

    function __construct($data = [])
    {
        $this->parsed = new ParsedData();
        $this->set($data);
    }

    public function set($data)
    {
        if (!is_array($data)) {
            $data = $this->parseUrl($data);
        }
        foreach ($this->parsed->keys() as $key) {
            $this->$key = isset($data[$key]) ? $data[$key] : null;
        }
        return $this;
    }

    public function clear()
    {
        $this->set([]);
    }

    public function assign(Url $url)
    {
        $this->set(get_object_vars($url->parsed));
    }

    public function __get($key)
    {
        $method = "get{$key}";
        return method_exists($this, $method) ? $this->$method() : $this->parsed->$key;
    }

    public function __isset($key)
    {
        return !is_null($this->$key);
    }

    public function __set($key, $value)
    {
        if (!property_exists($this->parsed, $key)) {
            throw new RuntimeException();
        }
        $method = "set{$key}";
        method_exists($this, $method) ? $this->$method($value) : $this->parsed->$key = $value;
    }

    public function __unset($key)
    {
        $this->__set($key, null);
    }

    public function __toString()
    {
        $url = '';
        if (isset($this->scheme)) {
            $url .= "{$this->scheme}:";
        }
        if (isset($this->host)) {
            $url .= '//';
            if (isset($this->user)) {
                $url .= "{$this->user}";
                if (isset($this->pass)) {
                    $url .= ":{$this->pass}";
                }
                $url .= '@';
            }
            $url .= "{$this->host}";
            if (isset($this->port)) {
                $url .= ":{$this->port}";
            }
        }
        if (isset($this->path)) {
            $url .= "{$this->path}";
        }
        if (isset($this->query) and $query = $this->buildQuery($this->query)) {
            $url .= "?{$query}";
        }
        if (isset($this->fragment)) {
            $url .= "#{$this->fragment}";
        }
        return $url;
    }

    public function isValid()
    {
        if (isset($this->host)) {
            return true;
        }
        return !isset($this->user) && !isset($this->pass) && !isset($this->port);
    }

    protected function parseUrl($str)
    {
        $data = parse_url((string)$str);
        if (!is_array($data)) {
            throw new RuntimeException();
        }
        return $data;
    }

    protected function parseQuery($str)
    {
        parse_str((string)$str, $data);
        return $data;
    }

    protected function setQuery($data)
    {
        if (!is_array($data)) {
            $data = $this->parseQuery($data);
        }
        $this->parsed->query = $data;
    }

    protected function buildQuery(array $data)
    {
        return http_build_query($data);
    }
}
