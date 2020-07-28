<?php ## Данные для БД
/* Подключение к базе данных MySQL с помощью вызова драйвера */
$dsn = 'mysql:dbname=new_book_catalog;host=localhost'; // имя базы данных и адрес сервера 
$user = 'mysql'; // имя пользователя
$password = 'mysql'; // пароль

try {
    $link = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}
?>