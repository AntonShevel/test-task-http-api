<?php
/**
 * Created by PhpStorm.
 * User: zerg
 * Date: 10/15/14
 * Time: 1:22 AM
 */

namespace Router;

class Router {

    private $routeCollection;
    private $basePath = '';
    private $parameters = array();

    public function __construct(RouteCollection $routeCollection) {
        $this->routeCollection = $routeCollection;
    }

    public function setBasePath($basePath) {
        $this->basePath = $basePath;
    }
    public function getBasePath() {
        return $this->basePath;
    }

    public function setParameters(array $parameters) {
        $this->parameters = $parameters;
    }
    public function getParameters() {
        return $this->parameters;
    }

    public function checkCurrentRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        foreach ($this->routeCollection as $route) {
            if ($method != $route->getMethod()) {
                continue;
            }
            if ($uri != $this->basePath . $route->getUrl()) {
                continue;
            }
            return $route->fireAction($this->getParameters());
        }
        throw new \Exception('No route found');
    }
}