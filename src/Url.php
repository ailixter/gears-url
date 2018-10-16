<?php

/*
 * (C) 2018, AII (Alexey Ilyin).
 */

namespace Ailixter\Gears;

use Ailixter\Gears\Exceptions\UrlException;
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
class Url extends ParsedData
{
    function __construct($data = [])
    {
        $this->set($data);
    }

    public function set($data)
    {
        if (!is_array($data)) {
            $data = $this->parseUrl($data);
        }
        foreach ($this->propertyKeys() as $key) {
            $this->$key = isset($data[$key]) ? $data[$key] : null;
        }
        return $this;
    }

    public function clear()
    {
        $this->set([]);
        return $this;
    }

    public function assign(Url $url)
    {
        foreach ($this->propertyKeys() as $key) {
            $this->$key = $url->$key;
        }
        return $this;
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
            $path = $this->path;
            if ($path[0] !== '/' && isset($this->host)) {
                $url .= '/';
            }
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

    public function isConsistent()
    {
        if (!isset($this->host)) {
            return !isset($this->user) && !isset($this->pass) && !isset($this->port);
        }
        return true;
    }

    protected function parseUrl($str)
    {
        $data = parse_url((string)$str);
        if (!is_array($data)) {
            throw UrlException::forParse($str);
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
        $this->propertySet(self::QUERY, $data);
        return $this;
    }

    protected function issetQuery()
    {
        return !!$this->query;
    }
    
    protected function buildQuery(array $data)
    {
        return http_build_query($data);
    }

    public function getQueryParam($param, $default = null)
    {
        return isset($this->query[$param]) ? $this->query[$param] : $default;
    }

    public function setQueryParam($param, $value)
    {
        $query = $this->query;
        $query[$param] = $value;
        $this->query = $query;
        return $this;
    }
}
