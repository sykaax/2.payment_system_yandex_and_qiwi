<?php
// скрипт удаляет записи из базы данных которым 2 дня из tabzakaz
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
require 'db/dbconnect.php'; // подключение базы данных
$mysqlzakazDELETE = mysqli_query($dbconnect, "DELETE FROM `tabzakaz`
WHERE `datestart` < DATE_SUB(NOW() , INTERVAL 1 DAY) 
and `dateend` IS NULL and `oplata` = '0' ");
  echo'mmmmmokaygetout';




?>