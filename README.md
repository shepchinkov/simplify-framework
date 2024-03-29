# **Simplify**. Simple PHP framework
**Simplify** - это маленький PHP фреймворк, реализующий паттерн MVC, разработанный с целью саморазвития и закрепления знаний путем переизобретения велосипеда. Я решил выложить его здесь и время от времени обновлять. PHP не мой основной язык, однако время от времени требуется написать панель администратора или простой лендинг, и интересно делать это при помощи собственноручно сотканных инструментов.

### Быстрый старт
Для того, чтобы быстро что-то создать при помощи Simplify, нужно сделать следующее:

1\. Ввести команду `composer install` в каталоге проекта.

2\. Создать контроллер страницы. Для этого создаем файл в 
   `app/controllers/{имя класса с заглавной буквы}.php`
   Пример: `app/controllers/Main.php`
   
3\. Чтобы реализовать контроллер, нужно в пространстве имен `Controller` переопределить метод `main()` у класса `BaseController`. Таким образом, структура базового контроллера будет выглядеть следующим образом:
```php
<?php

namespace Controller;

class Main extends \Core\BaseController
{
    /**
    * Вся логика контроллера содержится в методе main().
    */
    function main()
    {
        // Создадим переменную, которая будет помещена в шаблон Mustache.
        $name = "Hello, world!";
        
        // Установим массив данных, отправляемых в шаблон Mustache.
        $this->setData(["name" => $name]);
        
        // Т.к. это базовый контроллер, не предназначенный для API запросов
        // вам обязательно нужно установить шаблон для него (об этом далее).
        // Шаблон, располагающийся в app/views, указывается без расширения.
        $this->setView("main");
    }
}
```
4\. Далее нам нужно создать шаблон [Mustache](https://github.com/bobthecow/mustache.php/wiki/Mustache-Tags) в папке `app/views` с расширением `.mustache`. По сути, это обычный HTML код, содержащий в себе тэги шаблонизации. В качестве примера будем использовать следующий файл `app/views/main.mustache`:
```html
<!DOCTYPE html>
<html>
    <head>
        <title>The test template</title>
        <meta charset="utf8">
    </head>
    <body>
        Hello, {{ name }}!
    </body>
</html>
```

5\. После создания шаблона, установите его для контроллера при помощи `$this->setView()` в шаге #3.

6\. Создайте **маршрут** для данного контроллера - ассоциацию URI адреса с объектом. Эта формулировка подразумевает под собой пользователя, который переходит на страницу по заданной адресной строке, после чего фреймворк ищет ассоциацию с данным путем и вызывает метод `main()` у контроллера, связанным с этим URI. Так будет выглядеть подобное связывание в файле `index.php`:
```php
<?php
require "vendor/autoload.php";

use Core\Router;

// Связываем вызов метода main() у контроллера объекта Controller\Main с маршрутом "/"
Router::addRoute("/", new Controller\Main);

Router::init(); // Инициализация работы фреймворка
```
На этом, можно сказать, все. Однако если вам требуется реализовать базу данных, то в этом случае нужно отредактировать конфигурацию Simplify в файле `simplify.ini`. Включите модуль базы данных, изменив параметр **mysql_module** на `true`. Теперь ваша конфигурация будет выглядеть следующим образом:
```ini
[SIMPLIFY]
error_output = true
mysql_module = true

[MYSQL]
host     = "127.0.0.1"
port     = 3306
database = "your database here"
user     = "admin"
password = "your password here"
charset  = "utf8mb4"
```