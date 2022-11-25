<?php

class Router {
    private $configuration;
    private $defaultController;
    private $defaultMethod;

    public function __construct($configuration, $defaultController, $defaultMethod) {
        $this->configuration = $configuration;
        $this->defaultController = $defaultController;
        $this->defaultMethod = $defaultMethod;
    }

    public function redirect($controllerName = "", $methodName = "") {
        $controller = $this->getControllerFrom($controllerName);
        $this->executeMethodFrom($controller, $methodName);
    }

    private function getControllerFrom($controllerName) {
        $fullControllerName = $this->getFullControllerName($controllerName);
        $validControllerName = method_exists($this->configuration, $fullControllerName) ? $fullControllerName : $this->getFullControllerName($this->defaultController);
        return call_user_func(array($this->configuration,$validControllerName));
    }

    private function executeMethodFrom($controller, $methodName) {
        $validMethod = method_exists($controller, $methodName) ? $methodName : $this->defaultMethod;
        return call_user_func(array($controller, $validMethod));
    }

    private function getFullControllerName($controllerName): string {
        return "get" . ucfirst($controllerName) . "Controller";
    }
}