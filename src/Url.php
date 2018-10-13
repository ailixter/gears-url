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
        foreach ($this->keys() as $key) {
            $this->$key = isset($data[$key]) ? $data[$key] : null;
        }
        return $this;
    }

    public function clear()
    {
        $this->set([]);
    }

//    public function assign(Url $url)
//    {
//        $this->set(get_object_vars($url->parsed));
//    }

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
        $this->query = $data; // <==
    }

    protected function buildQuery(array $data)
    {
        return http_build_query($data);
    }
}
