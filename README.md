# **Simplify**. Simple PHP framework
**Simplify** - это маленький PHP фреймворк, реализующий паттерн MVC, разработанный с целью саморазвития и закрепления знаний путем переизобретения велосипеда. Я решил выложить его здесь и время от времени обновлять. PHP не мой основной язык, однако время от времени требуется написать панель администратора или простой лендинг, и интересно делать это при помощи собственноручно сотканных инструментов.

### Быстрый старт
Для того, чтобы быстро что-то создать при помощи Simplify, нужно сделать следующее:

1\. Ввести команду `composer install` в каталоге проекта.
2\. Создать контроллер главной / иной страницы. Для этого создаем файл в 
   `app/controllers/{название контролера}.php`
3\. Чтобы создать контроллер, нужно в пространстве имен `Controller` переопределить метод `main()` у базового класса `BaseController`. Таким образом, структура базового контроллера будет выглядеть следующим образом:
```php
<?php

namespace Controller;

class Main extends \Core\BaseController
{
    protected function main()
    {
        // Логика контроллера здесь
        
        // Т.к. это базовый контроллер, не предназначенный для API запросов
        // вам обязательно нужно установить шаблон для него (об этом далее)
        $this->setView("{Файл с шаблоном}");
    }
}
```
4\. Далее нам нужно создать шаблон [Mustache](https://github.com/bobthecow/mustache.php/wiki/Mustache-Tags) в папке `app/views` с расширением `.mustache`. По сути, это обычный HTML код, содержащий в себе тэги шаблонизации.
5\. После создания шаблона, установите его для контроллера при помощи `$this->setView()` в пункте #3.
6\. Создайте статический маршрут для данного контроллера, чтобы связать URI с его вызовом в `index.php`:
```php
<?php
require "vendor/autoload.php";

use Core\Router;

// Связываем вызов метода main() у контроллера объекта Controller\Main с маршрутом "/"
Router::addStaticRoute("/", new Controller\Main);

Router::init(); // Инициализация работы фреймворка
```
7\. 

### Устройство
Файловая структура выглядит следующим образом:
```
app/
   ├─ controllers/
   ├─ models/
   ├─ views/
core/
   ├─ BaseController.php
   ├─ Model.php
   ├─ View.php
   ├─ Router.php
index.php
simplify.ini
```

#### core/
В ядре содержатся классы, реализующие каждый компонент паттерна MVC и `Router.php`, их объединяющий.

##### BaseController.php
Этот класс необходим для создания контроллеров.