<?php

namespace Core;

/**
* Осуществляет рендер шаблонов Mustache и подставляет туда данные.
*/
abstract class View
{

    /**
    * Отправляет в поток вывода сгенерированный по шаблону Mustache документ.
    *
    * @param string $template Название шаблона, который располагается в папке views/.
    * Название указывается без расширения файла.
    * @param array  $data Ассоциативный массив переменных, подставляемых в шаблон Mustache.
    */
    public static function render(string $template, array $data)
    {
        $engine = new \Mustache_Engine(array(
            "entity_flags" => ENT_QUOTES,
            "loader" => new \Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/../app/views'),
        ));
        
        $m = $engine->loadTemplate($template);
        echo $m->render($data);
    }
}