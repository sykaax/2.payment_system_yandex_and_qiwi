<?php 
// данный файл отвечает за коннект к базе данных и последующим опперация станадартным.
$dbconnect = mysqli_connect("localhost", "root", "", "u0562844_default");
mysqli_query($dbconnect, "SET NAMES utf8");
// Проверка коннекта
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


?>