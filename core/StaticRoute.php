<?php

namespace Core;

/**
* ООП оболочка и абстракция ассоциации контроллеров с URI адресами.
*
* Этот класс необходим для хранения метаданных о маршрутах. Помимо, собственно, 
* адреса и объекта контроллера, StaticRoute содержит в себе такие данные как:
*    ➣ Метод. Предоставляет возможность реализовать разные контроллеры для разных HTTP методов по одному и тому же адресу. 
*             Может пригодиться для обхода CORS.
*/
class StaticRoute
{
    public readonly IController $controller;
    public readonly string      $uri;
    public readonly string      $method;
    
    private static array $staticRoutes = [];
    
    /**
    * @param IController $controller Объект контроллера, реализующего интерфейс IController (BaseController, RESTController).
    * @param string      $uri URI, с которым ассоциируется контроллер.
    * @param string      $method Название HTTP метода, который реализует контроллер. Допускает значение "ALL".
    */
    public function __construct(IController $controller, string $uri, string $method)
    {
        $this->controller = $controller;
        $this->uri        = $uri;
        $this->method     = $method;
    }
}