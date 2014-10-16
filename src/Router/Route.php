<?php
/**
 * Created by PhpStorm.
 * User: zerg
 * Date: 10/15/14
 * Time: 12:42 AM
 */

namespace Router;

class Route {
    private $url;
    private $method;
    private $action;

    static $allowedMethods = array('POST', 'GET', 'PUT', 'DELETE');

    function __construct($url, array $options) {
        $this->url = $url;
        $this->action = isset($options['action']) ? $this->setAction($options['action']) : null;
        $this->method = isset($options['method']) ? $this->setMethod($options['method']) : null;
        $method = isset($options['method']) ? $options['method'] : 'GET';
        $this->setMethod($method);
    }

    public function setUrl($url) {
        $this->url = (string) $url;
    }
    public function getUrl() {
        return $this->url;
    }

    public function setAction($action) {
        if (is_array($action)) {
            $this->action = $action;
            return $action;
        } else {
            throw new \InvalidArgumentException('Action must be array');
        }
    }
    public function getAction() {
        return $this->action;
    }

    public function setMethod($method) {
        if (in_array($method, self::$allowedMethods)) {
            $this->method = $method;
            return $method;
        } else {
            throw new \InvalidArgumentException('Method not allowed');
        }
    }
    public function getMethod() {
        return $this->method;
    }

    public function fireAction(array $parameters=array()) {

//        $instance = new $this->action[0]($parameters);
//        call_user_func_array(array($instance, $this->action[1]), $parameters);
        $reflection = new \ReflectionClass($this->action[0]);
        $instance = $reflection->newInstanceArgs($parameters);
        call_user_func(array($instance, $this->action[1]));
    }
}