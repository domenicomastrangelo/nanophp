<?php

namespace NanoPHP;

use ReflectionClass;

class Router
{
    private string $URI;
    private array $routes = [];
    private ?\NanoPHP\DependencyInjector $di = null;

    public function __construct()
    {
    }

    public function setDependencyInjector(\NanoPHP\DependencyInjector $di): self
    {
        $this->di = $di;
        return $this;
    }

    public function setURI(string $URI): self
    {
        $this->URI = $URI;
        return $this;
    }

    public function setRoutes(array $routes): self
    {
        $this->routes = $routes;
        return $this;
    }

    private function checkRouteExists(): bool
    {
        if (!in_array($this->URI, array_keys($this->routes))) {
            throw new \Exception("Route $this->URI does not exist");
        }

        return true;
    }

    public function route()
    {
        try {
            $this->checkRouteExists();
        } catch (\Exception $e) {
            if ($this->di->make('client')->DEBUG_MODE) {
                echo $e;
            } else {
                echo "404 - Page not found";
            }
        }

        $controllerAndFunction = $this->routes[$this->URI];

        try {
            $controllerName = '';
            $functionName   = '';
            list($controllerName, $functionName) = explode("@", $controllerAndFunction);
            $controllerName = "App\\Controllers\\" . $controllerName;
            
            if (!class_exists($controllerName)) {
                throw new \Exception("Class $controllerName not found");
            }
            
            $controllerObject = new $controllerName($this->di);

            if (!method_exists($controllerObject, $functionName)) {
                throw new \Exception("Method $functionName not found");
            }

            $parametersToPassToMethod = $this->getMethodParamsInstantiated($controllerObject, $functionName);

            echo $controllerObject->$functionName(...$parametersToPassToMethod);
        } catch (\Exception $e) {
            if ($this->di->make('client')->DEBUG_MODE) {
                echo $e;
            } else {
                echo "500 - Internal Server Error";
            }
        }
    }

    private function getMethodParamsInstantiated(\NanoPHP\Controllers\BaseController $controllerObject, string $function): array
    {
        $reflectorClass           = new ReflectionClass($controllerObject);
        $reflectorMethod          = $reflectorClass->getMethod($function);
        $reflectorMethodParams    = $reflectorMethod->getParameters();
        $parametersToPassToMethod = [];

        foreach ($reflectorMethodParams as $param) {
            $class = $param->getClass();
            if ($class != null) {
                $parametersToPassToMethod[] = $class->newInstance();
            } else {
                $parametersToPassToMethod[] = null;
            }
        }

        return $parametersToPassToMethod;
    }
}
