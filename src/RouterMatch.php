<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 14/07/18
 * Time: 12:48
 */

namespace AW;


class RouterMatch
{
    private $pattern = '/(:\w*)/', $request, $uri;

    public function __construct(Request $request, $uri)
    {
        $this->request = $request;
        $this->uri = $uri;
    }

    public function matcherFound()
    {
        return count($this->clear($this->getRequestUriArray())) == count($this->clear($this->getUriArray()));
    }

    private function getUriArray()
    {
        return explode('/', $this->uri);
    }
    private function getRequestUriArray()
    {
        return explode('/', $this->request->getServer()->requestUri);
    }

    private function clear(array $array)
    {
        return array_filter($array, function ($el) {
            return !empty($el);
        });
    }

    public function getParams()
    {
        return array_combine( $this->clear($this->getUriArray()),$this->clear($this->getRequestUriArray()));
    }

    public function getVariables()
    {
        return preg_grep($this->pattern, $this->getUriArray());
    }

    private function getTrueUriParts()
    {
        return array_filter($this->getRequestUriArray(), function ($item) {
            return !empty($item);
        });
    }

    private function getTrueRouteParts()
    {
        return array_map(function ($item) {
            return str_replace('/', '', $item);
        }, array_filter(preg_split($this->pattern, $this->uri), function ($item) {
            return !empty($item);
        }));
    }

    private function cleanRoute()
    {
        $arrayKeys = array_keys($this->getVariables());
        $replace = $this->getTrueUriParts();
        foreach ($arrayKeys as $key => $indice) {
            unset($replace[$indice]);
        }
        return $replace;
    }

    public function routeMatched()
    {
        $result = $this->getTrueRouteParts();

        $replace = $this->cleanRoute();

        return !array_diff($replace, $result);
    }
}