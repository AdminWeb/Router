<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 14/07/18
 * Time: 11:01
 */

namespace AW;


class Router
{
    private $methods = ['GET', 'POST', 'PUT', 'OPTIONS', "DELETE"];

    private $routes = [], $request;

    public function __construct(Request $request)
    {
        $this->setRequest($request);
    }

    public function __call($name, $args)
    {
        if (in_array(strtoupper($name), $this->methods)) {
            list($uri, $callable) = $args;
            $this->routes[strtoupper($name)][$uri] = $callable;
        }
    }

    public function run()
    {
        $found = false;

        $method = strtoupper($this->request->getServer()->requestMethod);

        foreach ($this->routes[$method] as $uri => $callable) {

            $routeMatcher = new RouterMatch($this->request, $uri);

            if ($routeMatcher->matcherFound()) {

                $req = $this->request->addParams($routeMatcher->getParams());

                $found = $routeMatcher->routeMatched();

                if ($found) {

                    $dispatcher = new Dispatcher($req, $callable);

                    $dispatcher->dispatch();

                }
            }
        }
        if (!$found) {
            throw new \Exception('Route and action not found!');
        }
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     * @return Router
     */
    public function setRequest(Request $request): Router
    {
        $this->request = $request;
        return $this;
    }
}