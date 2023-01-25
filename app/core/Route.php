<?php

namespace App\Core;

use Exception;

class Route {
    // Namespace for the controller
    const CONTROLLER_NAMESPACE = 'App\\Controllers\\';

    /**
     * The base variable that will store the routes
     * @var array
     */
    protected array $routes = [];

    /**
     * The base headers on each request
     * @var array
     */
    protected array $headers = [];

    /**
     * Set the needed headers
     * @param array $headers
     */
    public function setHeaders(array $headers = [])
    {
        $this->headers = $headers;
    }

    /**
     * Init the headers
     * @return void
     */
    protected function initHeaders()
    {
        foreach ($this->headers as $headerKey => $headerValue) {
            header("{$headerKey}: {$headerValue}");
        }
    }

    /**
     * @param string $uri
     * @param string $controller
     * @param string $method
     */
    public function get(string $uri, string $controller, string $method)
    {
        $this->routes[] = [
            'uri' => $uri,
            'requestMethod' => 'GET',
            'controller' => self::CONTROLLER_NAMESPACE . $controller,
            'method' => $method
        ];
    }


    /**
     * @param string $uri
     * @param string $controller
     * @param string $method
     */
    public function delete(string $uri, string $controller, string $method)
    {
        $this->routes[] = [
            'uri' => $uri,
            'requestMethod' => 'DELETE',
            'controller' => self::CONTROLLER_NAMESPACE . $controller,
            'method' => $method
        ];
    }

    /**
     * @param string $uri
     * @param string $controller
     * @param string $method
     */
    public function put(string $uri, string $controller, string $method)
    {
        $this->routes[] = [
            'uri' => $uri,
            'requestMethod' => 'PUT',
            'controller' => self::CONTROLLER_NAMESPACE . $controller,
            'method' => $method
        ];
    }

    /**
     * @param string $uri
     * @param string $controller
     * @param string $method
     */
    public function post(string $uri, string $controller, string $method)
    {
        $this->routes[] = [
            'uri' => $uri,
            'requestMethod' => 'POST',
            'controller' => self::CONTROLLER_NAMESPACE . $controller,
            'method' => $method
        ];
    }

    /**
     * @return false|mixed|void
     * @throws Exception
     */
    public function init()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $this->initHeaders();

        foreach ($this->routes as $route) {
            if($route['uri'] === $requestUri && $route['requestMethod'] === $requestMethod) {
                return call_user_func([
                    new $route['controller'],
                    $route['method']
                ]);
            }
        }

        // Prevent the error on options cors requests.
        if($requestMethod === 'OPTIONS') {
            return;
        }

        $this->abort();
    }

    /**
     * @throws Exception
     */
    public function abort($statusCode = 404)
    {
        json(['error' => 'Route not found'], $statusCode);
    }
}