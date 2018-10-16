<?php

/*
 * (C) 2018, AII (Alexey Ilyin).
 */

namespace Ailixter\Gears\Url;

use Ailixter\Gears\StrictProps;

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
    use StrictProps;

    const SCHEME    =  'scheme';
    const HOST      =  'host';
    const PORT      =  'port';
    const USER      =  'user';
    const PASS      =  'pass';
    const PATH      =  'path';
    const QUERY     =  'query';
    const FRAGMENT  =  'fragment';

    private $scheme;
    private $host;
    private $port;
    private $user;
    private $pass;
    private $path;
    private $query;
    private $fragment;
}
