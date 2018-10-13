<?php

/*
 * (C) 2018, AII (Alexey Ilyin).
 */

namespace Ailixter\Gears\Url;

/**
 * @author AII (Alexey Ilyin)
Scheme
Host
Port
User
Pass
Path
Query
Fragment
 */
class ParsedData
{
    private $scheme;
    private $host;
    private $port;
    private $user;
    private $pass;
    private $path;
    private $query;
    private $fragment;

    final public static function keys()
    {
        static $keys;
        return $keys ? $keys : $keys = array_keys(get_class_vars(__CLASS__));
    }

    public function __get($key)
    {
        $method = "get{$key}";
        if (method_exists($this, $method)) {
            $value = $this->$method();
        } elseif (property_exists($this, $key)) {
            $value = $this->$key;
        } else {
            throw new RuntimeException();
        }
        return $value;
    }

    public function __isset($key)
    {
        return !is_null($this->__get($key));
    }

    public function __set($key, $value)
    {
        $method = "set{$key}";
        if (method_exists($this, $method)) {
            $this->$method($value);
        } elseif (property_exists($this, $key)) {
            $this->$key = $value;
        } else {
            throw new RuntimeException();
        }
    }

    public function __unset($key)
    {
        $this->__set($key, null);
    }

}
