<?php 
// Данный файл это страница ошибки на которую человек попадает когда переходит на страницу buy.php и ненайдено
// совпадения idtovar в базе данных и из GET запроса ссылки

require '../db/dbconnect.php';
require '../functionphp/functions.php';
echo 'Добрый день к сожалению данного товара не найдено! Перенаправляем'
echo "<SCRIPT LANGUAGE=javascript>history.back()</SCRIPT>";// возвращаемся на страницу назад
?>