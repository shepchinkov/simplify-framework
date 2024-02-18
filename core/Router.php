<?php

namespace Core;

define("SIMPLIFY_CONFIG_PATH", dirname(__FILE__) . "/../simplify.ini");

ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
* Организует сравнение URI с объектами типа IController
*
* Позволяет сопоставлять заданные пользователем URI пути с объектами IController, которые создаются
* в папке app/controllers, дабы в последствии их связать между собой методом addRoute().
*
*
*/
abstract class Router
{

    // Хранит в себе объекты класса StaticRoute.
    private static array $routes = [];
    
    /**
    * Добавляет новое сравнение контроллера с URI.
    *
    * Создает объект StaticRoute и сохраняет его для последующего использования
    * в статическую переменную $routes. Подробнее про StaticRoute в StaticRoute.php
    *
    * @param string      $uri URI - путь после имени хоста до необходимой страницы. 
    * Для пустого пути используется "/". Слеши в начале и конце строк необязательны.
    * @param IController $controller Объект, реализующий интерфейс IController, т.е.
    * класс вашего контроллера, написанный в папке app/controllers.
    * @param string      $method Позволяет ограничить доступ к контроллеру по определенному
    * HTTP методу. Может пригодиться для реализации CORS. По-умолчанию стоит "ALL", т.е. 
    * доступ при помощи любого метода.
    */
    public static function addRoute(string $uri, IController $controller, string $method = "ALL")
    {
        self::$routes[] = new StaticRoute($controller, trim(strtolower($uri), "/"), strtolower($method));
    }

    /**
    * Осуществляет поиск контроллера по URI.
    *
    * Имеется возможность поиска контроллера с фильтром по методу, который он реализует.
    * Алгоритм фильтрации по методу осуществляется следующим образом:
    *   1. Сначала метод пытается найти контроллер, который реализует определенный метод, указанный в $method.
    *   2. Затем пытается найти контроллер, реализующий все методы, т.е. $method = "ALL".
    * 
    * Если в шаге №1 был найден ответ, то возвращается он. Если нет, возвращается контроллер из шага №2. 
    * Если ни один контроллер не был найден, возвращается null.
    *
    * Контроллеры, реализующие конкретные HTTP методы, более специфичные. Из этого следует, что они имеют больший приоритет во время поиска.
    *
    * @param string $uri URI, который реализует контроллер.
    * @param string $method Фильтр по методу, который реализует контроллер. 
    */
    private static function findController(string $uri, string $method = "ALL"): ?IController
    {
        // Ищет контроллер, реализующий конкретный метод, указанный в $method.
        foreach (self::$routes as $route) {
            if ($route->uri == $uri and $route->method == strtolower($method)) {
                return $route->controller;
            }
        }

        // Ищет контроллер, реализующий все HTTP методы.
        foreach (self::$routes as $route) {
            if ($route->uri == $uri and $route->method == "all") {
                return $route->controller;
            }
        }

        // В противном случае возвращает null.
        return null;
    }

    /**
    * Запуск механизма фреймворка.
    *
    * Основная задача метода - это сопоставление введенного пользователем URI с контроллером с его последующим вызовом.
    * Также данный метод реализует механизм отображения ошибок и инициализирует базовый класс моделей Core\Model. 
    */
    public static function init()
    {
        $uri = strtolower(trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/"));
        $controller = self::findController($uri, $_SERVER["REQUEST_METHOD"]);

        if (!$controller) {
            $route = $_SERVER["SERVER_NAME"] . rtrim($_SERVER["REQUEST_URI"], "/");

            // TODO: Добавить возможность делать кастомную страницу ошибки 404
            $controller = new \Controller\ServerError(
                404, 
                "404 This page doesn't exist",
                "Error 404, route \"$route\" has not been registered."
            );
        }

        $frameworkConfigSettings = parse_ini_file(SIMPLIFY_CONFIG_PATH, true);

        try {
            if ($frameworkConfigSettings["SIMPLIFY"]["mysql_module"]) {
                Model::init();
            }

            $controller->init();
        } catch (\Throwable $th) {
            if ($frameworkConfigSettings["SIMPLIFY"]["error_output"]) {
                (new \Controller\ServerError(
                    500, 
                    "500 Internal Server Error",
                    "There was an error on the server side.",
                    $th->getMessage() . "\n" . $th->getTraceAsString()
                ))->init();
            }
        }
    }
}