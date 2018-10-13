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
    public $scheme;
    public $host;
    public $port;
    public $user;
    public $pass;
    public $path;
    public $query;
    public $fragment;

    final public static function keys()
    {
        static $keys;
        return $keys ? $keys : $keys = array_keys(get_class_vars(__CLASS__));
    }
}
