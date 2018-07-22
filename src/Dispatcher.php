<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 14/07/18
 * Time: 15:34
 */

namespace AW;


class Dispatcher
{
    private $request, $callable;

    public function __construct(Request $request, $callable)
    {
        $this->request = $request;
        $this->callable = $callable;
    }

    public function dispatch()
    {
        if (gettype($this->callable) == 'string') {
            if (strpos($this->callable, '@') === false) {
                $this->callable($this->request);
            } else {
                list($class, $action) = explode('@', $this->callable);
                (new $class)->{$action}($this->request);
            }
        } else {
            $callable = $this->callable;
            $callable($this->request);
        }
    }

    public function __destruct()
    {
       exit;
    }
}