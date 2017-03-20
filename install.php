<?php
//Получаем реквизиты для подключения к БД из файла config.php
require_once("config.php");
//подключение к БД
$mysqli = new mysqli($db_server, $db_user, $db_password, $db_db);
//Удаляем старые таблицы
$result = $mysqli->query("DROP TABLE IF EXISTS `comments`");
$result = $mysqli->query("DROP TABLE IF EXISTS `users`");
//Создаем новые таблицы
$result = $mysqli->query("CREATE TABLE `users` (id int(11) NOT NULL AUTO_INCREMENT, `name` CHAR(10) NOT NULL, `password` CHAR(50) NOT NULL, PRIMARY KEY(`id`)) DEFAULT CHARSET=utf8");
$result = $mysqli->query("CREATE TABLE `comments` (`id` int(11) NOT NULL AUTO_INCREMENT, `name` varchar(50) NOT NULL, `text` varchar(10000) NOT NULL, PRIMARY KEY(`id`)) DEFAULT CHARSET=utf8");
//Добавляем данные
$result = $mysqli->query("INSERT INTO `users` (`id`, `name`, `password`) VALUES (DEFAULT, 'admin', 'MegaSecretPassword'), (DEFAULT, 'admin2', 'BestPassword'), (DEFAULT, 'user', 'Mypassword')");
$result = $mysqli->query("INSERT INTO `comments` (`id`, `name`, `text`) VALUES (DEFAULT, 'Вася', 'Отличная компания'), (DEFAULT, 'Вася', 'Приятно с Вам работать!'), (DEFAULT, 'Петя', 'Спасибо за Плодотворное сотрудничество!'), (DEFAULT, 'Петя', 'Огромное спасибо! У Вас самый лучший сервис!'), (DEFAULT, 'Коля', 'Отличное качество!')");
//Закрываем соединение с БД
$mysqli->close();
echo ("База данных создана и заполнена");
?>