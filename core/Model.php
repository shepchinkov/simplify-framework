<?php

namespace Core;

/**
* Базовый класс моделей. Реализует подключение и работу с конфигурационными файлами. 
*
* Также реализует несколько удобных методов для работы с базами данных. Т.е. это не ORM. 
* При наследовании необходимо переопределить свойство $table.
*
* @todo Сделать реализацию для нескольких баз данных.
*/
abstract class Model
{
    private static $sql;
    protected $table;

    /**
    * Необходим для единоразового подключения к базе данных при обработке текущего запроса. Вызывается в Core\Router.
    */
    final static public function init()
    {
        self::$sql   = self::MySQLConnect();
    }

    /**
    * Осуществляет подключение к базе данных на основании данных, полученных из файла конфигурации.
    */
    private static function MySQLConnect(): \mysqli
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $databaseConfigSettings = parse_ini_file(SIMPLIFY_CONFIG_PATH, true);

        $host      = $databaseConfigSettings["MYSQL"]["host"];
        $port      = $databaseConfigSettings["MYSQL"]["port"];
        $database  = $databaseConfigSettings["MYSQL"]["database"];
        $user      = $databaseConfigSettings["MYSQL"]["user"];
        $password  = $databaseConfigSettings["MYSQL"]["password"];
        $charset   = $databaseConfigSettings["MYSQL"]["charset"];

        $db = new \mysqli($host, $user, $password, $database, $port);
        $db->set_charset($charset);
        $db->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);

        return $db;
    }

    /**
    * Возвращает строки с фильтрацией по равенству переменных после WHERE. 
    */
    final protected function getRawDataByEquals($data)
    {
        $query = "SELECT * FROM `{$this->table}` WHERE";

        foreach ($data as $key => $value) {
            $query .= " `$key`=? AND";
        }

        $query = substr($query, 0, strrpos($query, " AND") - strlen($query));
        $query .= ";";

        $values = array_values($data);

        return $this->preparedQuery($query, ...$values);
    }

    /**
    * Осуществляет неподготовленный SQL запрос. 
    */
    final protected static function query(string $query)
    {
        $result = self::$sql->query($query);

        return $result;
    }

    /**
    * Осуществляет подготовленный SQL запрос.
    *
    * @param string $query SQL запрос.
    * @param mixed  $data Ряд переменных, которые нужно подставить в SQL запрос.
    */
    final protected static function preparedQuery(string $query, ...$data)
    {
        $stmt = self::$sql->prepare($query);
        $stmt->execute($data);
        
        $result = $stmt->get_result();

        return $result;
    }

    /**
    * Возвращает все данные из таблицы.
    */
    final protected function getAllRawData()
    {
        $result = self::$sql->query("SELECT * FROM `{$this->table}`;");

        return $result->fetch_all();
    }
}