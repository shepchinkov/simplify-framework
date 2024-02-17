<?php

namespace Core;

/**
* Контроллер, предназначенный для реализации ответов в формате application/json. Обычно, для API.
*/
abstract class RESTController implements IController
{
    protected $data = [];

    /**
    * Устанавливает данные, отправляемые в шаблон Mustache.
    *
    * Устанавливает значение для массива $data.
    */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
    * Функционал контроллера, реализуемый разработчиком. 
    */
    abstract protected function main();

    /**
    * Инициализирует функционал контроллера.
    * 
    * Сначала вызывается метод main() - функционал контроллера, реализовываемый разработчиком.
    * Затем вызывается метод render() - данные формируются согласно типу контроллера: applictaion/json или text/html.
    */
    public function init()
    {
        $this->main();
        $this->render();
    }

    /**
    * Производит отрисовку данных пользователю в формате контроллера: applicatin/json или text/html. 
    */
    final public function render()
    {
        header("Content-Type: application/json");
        echo json_encode($this->data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}