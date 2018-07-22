<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 14/07/18
 * Time: 12:08
 */

namespace AW\Env;


abstract class AbstractEnv
{
    protected $attrs = [];

    abstract public function __construct($varEnv);

    protected function bootstrap($varEnv)
    {
        foreach ($varEnv as $key => $value) {
            $this->attrs[$this->toCamelCase($key)] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_ENCODED);
        }
    }

    protected function toCamelCase($string)
    {
        $result = strtolower($string);
        preg_match_all('/_[a-z]/', $result, $matches);
        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }
        return $result;
    }

    public function __get($attr)
    {
        return isset($this->attrs[$attr]) ? $this->attrs[$attr] : false;
    }

    public function addAttr($key, $value)
    {
        $this->attrs[$this->toCamelCase($key)] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_ENCODED);
    }

    public function addAttrPair(array $attrs)
    {
        foreach ($attrs as $key => $value) {
            $this->addAttr($key, $value);
        }
    }
}