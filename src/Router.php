<?php

namespace NanoPHP;

use NanoPHP\Controllers\BaseController;
use NanoPHP\Library\Http\Response;
use ReflectionClass;

class Router
{
    private string $URI;
    private string $method;
    private array $routes = [];
    private array $params = [];
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

    public function setMethod(string $method): self
    {
        $this->method = strtolower($method);
        return $this;
    }

    public function setRoutes(array $routes): self
    {
        $this->routes = $routes;
        return $this;
    }

    private function getRoute()
    {
        $URIWithNoSlash = ltrim($this->URI, '/');

        $currentRouteArray = explode("/", $URIWithNoSlash);

        $routesArray = [];

        foreach ($this->routes as $key => $val) {
            foreach ($val['route'] as $k => $v) {
                $routeWithNoSlash = ltrim($k, '/');
                $routesArray[] = [
                    'method' => $val['method'],
                    'route'  => explode('/', $routeWithNoSlash)
                ];
            }
        }
        
        $correctRouteKeyPosition = $this->getCorrectRoute($currentRouteArray, $routesArray);

        return $this->routes[$correctRouteKeyPosition];
    }

    private function getCorrectRoute(array $currentRouteArray, array $routesArray)
    {
        $foundRoute = false;
        $paramPosition = 0;
        
        foreach ($routesArray as $key => $routes) {
            foreach ($routes['route'] as $rKey => $rVal) {
                $rVal = ltrim(rtrim($rVal, '}'), '{');
                $valueToCompare = $currentRouteArray[$rKey] ?? "";
                
                if (
                    $rVal !== $valueToCompare &&
                    @preg_match("/" . $rVal . "/", $valueToCompare) == false
                ) {
                    $foundRoute = false;
                    continue 2;
                } elseif ($rVal === "") {
                    if (
                        $rVal === $valueToCompare &&
                        strtolower($this->method) === strtolower($routes['method'])
                    ) {
                        $foundRoute = true;
                        break;
                    }
                } elseif ($rVal === $valueToCompare) {
                    if (isset($currentRouteArray[$rKey + 1])) {
                        continue;
                    } elseif (strtolower($this->method) === strtolower($routes['method'])) {
                        $foundRoute = true;
                        break;
                    }
                } elseif (
                    @preg_match("/^" . $rVal . "$/", $valueToCompare) == true &&
                    strtolower($this->method) === strtolower($routes['method'])
                ) {
                    $paramKey = $this->routes[$key]['params'][$paramPosition];
                    $this->params[$paramKey] = $valueToCompare;
                    $paramPosition++;
                    $foundRoute = true;
                    continue;
                }
            }

            if ($foundRoute === true) {
                return $key;
            }

            $this->params = [];
        }

        Response::abort(404);
    }

    public function route()
    {
        try {
            $routeAndMethod = $this->getRoute();
        } catch (\Exception $e) {
            if ($this->di->make("config")::DEBUG_MODE) {
                echo $e;
                exit();
            } else {
                Response::abort(404);
            }
        }

        $currentRoute = ltrim(key($routeAndMethod['route']), '/');
        $currentRoute = "/" . $currentRoute;

        $controllerAndFunction = $routeAndMethod['route'][$currentRoute];

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

            $response = $controllerObject->$functionName(...$parametersToPassToMethod);

            if (!($response instanceof \NanoPHP\Library\Http\Response)) {
                echo "Value returned from the controller is not a valid Response";
                die();
            }

            foreach ($response->getHeaders() as $key => $value) {
                header("$key: $value[0]");
            }

            http_response_code($response->getStatusCode());

            echo $response->getBody();
        } catch (\Exception $e) {
            if ($this->di->make("config")::DEBUG_MODE) {
                echo $e;
            } else {
                Response::abort(500);
            }
        }
    }

    private function getMethodParamsInstantiated(BaseController $controllerObject, string $function): array
    {
        $reflectorClass           = new ReflectionClass($controllerObject);
        $reflectorMethod          = $reflectorClass->getMethod($function);
        $reflectorMethodParams    = $reflectorMethod->getParameters();
        $parametersToPassToMethod = [];

        foreach ($reflectorMethodParams as $param) {
            $class = $param->getClass();
            if (
                $param->getType()->getName() === "string" &&
                isset($this->params[$param->getName()])
            ) {
                $parametersToPassToMethod[] = $this->params[$param->getName()];
            } elseif ($class != null) {
                $parametersToPassToMethod[] = $class->newInstance();
            } else {
                $parametersToPassToMethod[] = null;
            }
        }
        
        return $parametersToPassToMethod;
    }
}
