<?php

namespace App;

use App\Controller\IndexController;
use App\Controller\ProductController;
use App\Controller\ProductTypeController;
use App\Controller\TaxController;

class Router
{
    public static function route()
    {
        // Mapeamento de rotas para controllers, métodos e métodos HTTP
        $routes = [
            '/api/' => [
                'prefix' => '/api',
                'routes' => [
                    '/' => [
                        'controller' => IndexController::class,
                        'methods' => ['GET' => 'index']
                    ],
                    '/product' => [
                        'controller' => ProductController::class,
                        'methods' => [
                            'GET' => ['index', 'show'],
                            'POST' => 'store',
                            'PUT' => 'update',
                            'DELETE' => 'delete'
                        ]
                    ],
                    '/product_type' => [
                        'controller' => ProductTypeController::class,
                        'methods' => [
                            'GET' => ['index', 'show'],
                            'POST' => 'store',
                            'PUT' => 'update',
                            'DELETE' => 'delete'
                        ]
                    ],
                    '/tax' => [
                        'controller' => TaxController::class,
                        'methods' => [
                            'GET' => ['index', 'show'],
                            'POST' => 'store',
                            'PUT' => 'update',
                            'DELETE' => 'delete'
                        ]
                    ],
                    '/transaction' => [
                        'controller' => TaxController::class,
                        'methods' => [
                            'GET' => ['index', 'show'],
                            'POST' => 'store',
                            'PUT' => 'update',
                            'DELETE' => 'delete'
                        ]
                    ],
                ]
            ],
        ];

        // Obtenha a URL atual
        $requestUri = $_SERVER['REQUEST_URI'];

        // Remova quaisquer parâmetros da URL
        $requestUri = strtok($requestUri, '?');

        // Obtenha o método HTTP da requisição
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // Iterar sobre as rotas
        foreach ($routes as $route) {
            $prefix = $route['prefix'];
            // Verifique se a URL atual começa com o prefixo da rota
            if (strpos($requestUri, $prefix) === 0) {
                // Remova o prefixo da URL
                $trimmedUri = substr($requestUri, strlen($prefix));
                $params = explode('/', $trimmedUri);
                if (isset($params[2])) {
                    $trimmedUri = "/{$params[1]}";
                }

                // Verifique se a rota existe no mapeamento
                if (array_key_exists($trimmedUri, $route['routes'])) {
                    $routeInfo = $route['routes'][$trimmedUri];
                    $controllerClass = $routeInfo['controller'];
                    $controller = new $controllerClass();
                    $method = $routeInfo['methods'][$requestMethod] ?? null;
                    if (is_array($method) && count($method) > 1) {
                        $method = isset($params[2]) ? $method[1] : $method[0];
                    }
                    if (method_exists($controller, 'validate')) {
                        $data = file_get_contents('php://input');
                        $data = json_decode($data, true);
                        if (!$controller->validate($data)['success']) {
                            // Se a validação falhar, retorne uma resposta de erro
                            return $controller->validate($data);
                        }
                    }

                    if ($method !== null && method_exists($controller, $method)) {
                        switch ($method) {
                            case 'store':
                                $data = file_get_contents('php://input');
                                $data = json_decode($data, true);
                                return $controller->$method($data);
                            case 'update':
                                $data = file_get_contents('php://input');
                                $data = json_decode($data, true);
                                return $controller->$method($params[2], $data);
                            case 'index':
                                return $controller->$method();
                            default:
                                return $controller->$method($params[2]);
                        }
                    } else {
                        return ['error' => 'Method not allowed'];
                    }
                }
            }
        }

        return ['error' => 'Route not found'];
    }
}