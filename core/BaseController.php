<?php

namespace Core;

/**
* Контроллер, предназначенный для реализации ответов в формате text/html. Обязателен рендер шаблонов Mustache.
*/
abstract class BaseController implements IController
{
    protected string $view;
    protected array $data = [];

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
    * Устанавливает шаблон Mustache для последующей отрисовки.
    *
    * @param string $view Название шаблона Mustache, располагающийся в app/views. Указывается без формата файла.
    */
    protected function setView(string $view)
    {
        $this->view = $view;
    }

    /**
    * Производит отрисовку данных пользователю в формате контроллера: applicatin/json или text/html. 
    */
    final public function render()
    {
        View::render($this->view, $this->data);
    }
}