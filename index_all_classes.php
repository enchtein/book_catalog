<?php
##index_all_classes.php
/*
$mass=scandir('../GeekForLess/include/classes/class');
print_r($mass);
*/
require_once "../GeekForLess/include/classes/bdconnect_pdo.php"; // вызов подключения к бд
require_once "../GeekForLess/include/classes/class/BookInfo.php"; // Класс для просмотра информации по книге
require_once "../GeekForLess/include/classes/class/QueryBuilder.php"; // Класс для построения PDO запросов
require_once "../GeekForLess/include/classes/class/Validate.php"; // Класс для валидации
require_once "../GeekForLess/include/classes/class/Email.php"; // Класс для отправки письма
require_once "../GeekForLess/include/classes/class/Search.php"; // Класс для поиска по сайту
?>