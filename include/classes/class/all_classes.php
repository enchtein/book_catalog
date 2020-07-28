<?php
##all_classes.php
require_once "../../GeekForLess/include/classes/bdconnect_pdo.php"; // вызов подключения к бд

require_once "../include/classes/class/BookInfo.php"; // просмотр информации по книге (унаследован от класса PublishRefain)
require_once "../include/classes/class/Email.php"; // Класс для отправки письма
require_once "../include/classes/class/PublishRefain.php"; // отображение refain на странице
require_once "../include/classes/class/QueryBuilder.php"; // Класс для построения PDO запросов
require_once "../include/classes/class/Search.php"; // Класс для поиска по сайту
require_once "../include/classes/class/Validate.php"; // Класс для валидации
?>