<?php

class Core
{
    private $currentController = '';
    private $currentAction = '';

    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function process()
    {
        $controllerName = ucfirst($this->currentController) . 'Controller';
        if (is_readable('controllers/' . $controllerName . '.php')) {
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                $actionName = 'action' . ucfirst($this->currentAction);
                if (method_exists($controller, $actionName)) {
                    $controller->$actionName($this->getUrlArg(3));
                } else {
                    die($this->currentAction . ' action not found');
                }
            } else {
                die($this->currentController . ' controller not found');
            }
        } else {
            die($this->currentController . ' controller not found');
        }
    }

    public function setDefaultController($controller)
    {
        if ($this->getUrlArg(1) == '') {
            $this->currentController = $controller;
        } else {
            $this->currentController = $this->getUrlArg(1);
        }
    }

    public function setDefaultAction($action)
    {
        if ($this->getUrlArg(2) == '') {
            $this->currentAction = $action;
        } else {
            $this->currentAction = $this->getUrlArg(2);
        }
    }

    private function getUrlArg($part)
    {
        $requestUrl = array_values(explode('/', ltrim($_SERVER['REQUEST_URI'], '/')));
        return isset($requestUrl[$part - 1]) ? $requestUrl[$part - 1] : '';
    }
}

function __autoload($className)
{
    $classPath = 'controllers/' . $className . '.php';
    if (file_exists($classPath)) {
        include $classPath;
    } else {
        die('File not found');
    }
}
