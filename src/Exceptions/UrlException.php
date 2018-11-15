<?php

/*
 * (C) 2018, AII (Alexey Ilyin).
 */

namespace Ailixter\Gears\Exceptions;

/**
 * @author AII (Alexey Ilyin)
 */
class UrlException extends Exception
{

    public static function forParse($url)
    {
        return new static("Failure in parsing URL '$url'");
    }

}
