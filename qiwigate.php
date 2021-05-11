<?php
//данный файл получает данные через qiwi api нужно обновлять ключ индивидуальный каждые 180 дней,
//следющие обновление нужно сделать 30 явнаря, а так всё збс, после этого 
//данные из масива полученного сверяются с базой данных, и если всё хорошо то проёденную оплату
//замечает скрипт и меняет значине oplata на 1. скрипт нужно запускать каждую минуту
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
require 'db/dbconnect.php'; // подключение базы данных
require_once 'Qiwi.php'; // подключение qiwi листа с функциями для киви запроса

// сама функция киви и коннект с киви апи
// пр итоге выдется один масив с данными
$qiwi = new Qiwi('79268750228', '39a772e82d433e797a3bd71cd281e512');
$getHistory = $qiwi->getPaymentsHistory([
	'startDate' => '2018-01-01T00:00:00+03:00', //дата откуда брать платежи
	'endDate' => '2025-10-01T00:00:00+03:00',  // дата откуда заканчивать брать платежи
	'rows' => '12' //количество проведенных оплат вывести в масиве
]);

// 12 раз идёт назначение переменных из масивов, чтобы было легче потом индефицировать
// данные

$status0 = ($getHistory['data']['0']['status']); // путь до статуса успешна оплата или нет
$amount0 = ($getHistory['data']['0']['sum']['amount']); // путь до суммы платежа
$comment0 = ($getHistory['data']['0']['comment']); // путь до коментария платежа

$status1 = ($getHistory['data']['1']['status']); // путь до статуса успешна оплата или нет
$amount1 = ($getHistory['data']['1']['sum']['amount']); // путь до суммы платежа
$comment1 = ($getHistory['data']['1']['comment']); // путь до коментария платежа

$status2 = ($getHistory['data']['2']['status']); // путь до статуса успешна оплата или нет
$amount2 = ($getHistory['data']['2']['sum']['amount']); // путь до суммы платежа
$comment2 = ($getHistory['data']['2']['comment']); // путь до коментария платежа

$status3 = ($getHistory['data']['3']['status']); // путь до статуса успешна оплата или нет
$amount3 = ($getHistory['data']['3']['sum']['amount']); // путь до суммы платежа
$comment3 = ($getHistory['data']['3']['comment']); // путь до коментария платежа

$status4 = ($getHistory['data']['4']['status']); // путь до статуса успешна оплата или нет
$amount4 = ($getHistory['data']['4']['sum']['amount']); // путь до суммы платежа
$comment4 = ($getHistory['data']['4']['comment']); // путь до коментария платежа

$status5 = ($getHistory['data']['5']['status']); // путь до статуса успешна оплата или нет
$amount5 = ($getHistory['data']['5']['sum']['amount']); // путь до суммы платежа
$comment5 = ($getHistory['data']['5']['comment']); // путь до коментария платежа

$status6 = ($getHistory['data']['6']['status']); // путь до статуса успешна оплата или нет
$amount6 = ($getHistory['data']['6']['sum']['amount']); // путь до суммы платежа
$comment6 = ($getHistory['data']['6']['comment']); // путь до коментария платежа

$status7 = ($getHistory['data']['7']['status']); // путь до статуса успешна оплата или нет
$amount7 = ($getHistory['data']['7']['sum']['amount']); // путь до суммы платежа
$comment7 = ($getHistory['data']['7']['comment']); // путь до коментария платежа

$status8 = ($getHistory['data']['8']['status']); // путь до статуса успешна оплата или нет
$amount8 = ($getHistory['data']['8']['sum']['amount']); // путь до суммы платежа
$comment8 = ($getHistory['data']['8']['comment']); // путь до коментария платежа

$status9 = ($getHistory['data']['9']['status']); // путь до статуса успешна оплата или нет
$amount9 = ($getHistory['data']['9']['sum']['amount']); // путь до суммы платежа
$comment9 = ($getHistory['data']['9']['comment']); // путь до коментария платежа

$status10 = ($getHistory['data']['10']['status']); // путь до статуса успешна оплата или нет
$amount10 = ($getHistory['data']['10']['sum']['amount']); // путь до суммы платежа
$comment10 = ($getHistory['data']['10']['comment']); // путь до коментария платежа

$status11 = ($getHistory['data']['11']['status']); // путь до статуса успешна оплата или нет
$amount11 = ($getHistory['data']['11']['sum']['amount']); // путь до суммы платежа
$comment11 = ($getHistory['data']['11']['comment']); // путь до коментария платежа

//идёт далее 12 проверок массивов, на проверку кто оплатил.

if($status0 == 'SUCCESS' ){ //проверка если оплата успеша, идет попытка потверждения оплаты
  $comment0 = substr($comment0, 7, -1); //убираем лишние знаки у комментария при оплате
  $mysqltovarUPDATE0 = mysqli_query($dbconnect, "UPDATE `tabzakaz` SET `oplata` = '1'
  WHERE `id` = '$comment0' and `oplata` = '0' and `sum` = '$amount0' ");
}
if($status1 == 'SUCCESS' ){ //проверка если оплата успеша, идет попытка потверждения оплаты
  $comment1 = substr($comment1, 7, -1); //убираем лишние знаки у комментария при оплате
  $mysqltovarUPDATE1 = mysqli_query($dbconnect, "UPDATE `tabzakaz` SET `oplata` = '1'
  WHERE `id` = '$comment1' and `oplata` = '0' and `sum` = '$amount1' ");
}
if($status2 == 'SUCCESS' ){ //проверка если оплата успеша, идет попытка потверждения оплаты
  $comment2 = substr($comment2, 7, -1); //убираем лишние знаки у комментария при оплате
  $mysqltovarUPDATE2 = mysqli_query($dbconnect, "UPDATE `tabzakaz` SET `oplata` = '1'
  WHERE `id` = '$comment2' and `oplata` = '0' and `sum` = '$amount2' ");
}
if($status3 == 'SUCCESS' ){ //проверка если оплата успеша, идет попытка потверждения оплаты
  $comment3 = substr($comment3, 7, -1); //убираем лишние знаки у комментария при оплате
  $mysqltovarUPDATE3 = mysqli_query($dbconnect, "UPDATE `tabzakaz` SET `oplata` = '1'
  WHERE `id` = '$comment3' and `oplata` = '0' and `sum` = '$amount3' ");
  echo'workokaystatus4=3';
}
if($status4 == 'SUCCESS' ){ //проверка если оплата успеша, идет попытка потверждения оплаты
  $comment4 = substr($comment4, 7, -1); //убираем лишние знаки у комментария при оплате
  $mysqltovarUPDATE0 = mysqli_query($dbconnect, "UPDATE `tabzakaz` SET `oplata` = '1'
  WHERE `id` = '$comment4' and `oplata` = '0' and `sum` = '$amount4' ");
}
if($status5 == 'SUCCESS' ){ //проверка если оплата успеша, идет попытка потверждения оплаты
  $comment5 = substr($comment5, 7, -1); //убираем лишние знаки у комментария при оплате
  $mysqltovarUPDATE5 = mysqli_query($dbconnect, "UPDATE `tabzakaz` SET `oplata` = '1'
  WHERE `id` = '$comment5' and `oplata` = '0' and `sum` = '$amount5' ");
}
if($status6 == 'SUCCESS' ){ //проверка если оплата успеша, идет попытка потверждения оплаты
  $comment6 = substr($comment6, 7, -1); //убираем лишние знаки у комментария при оплате
  $mysqltovarUPDATE6 = mysqli_query($dbconnect, "UPDATE `tabzakaz` SET `oplata` = '1'
  WHERE `id` = '$comment6' and `oplata` = '0' and `sum` = '$amount6' ");
}
if($status7 == 'SUCCESS' ){ //проверка если оплата успеша, идет попытка потверждения оплаты
  $comment7 = substr($comment7, 7, -1); //убираем лишние знаки у комментария при оплате
  $mysqltovarUPDATE7 = mysqli_query($dbconnect, "UPDATE `tabzakaz` SET `oplata` = '1'
  WHERE `id` = '$comment7' and `oplata` = '0' and `sum` = '$amount7' ");
}
if($status8 == 'SUCCESS' ){ //проверка если оплата успеша, идет попытка потверждения оплаты
  $comment8 = substr($comment8, 7, -1); //убираем лишние знаки у комментария при оплате
  $mysqltovarUPDATE8 = mysqli_query($dbconnect, "UPDATE `tabzakaz` SET `oplata` = '1'
  WHERE `id` = '$comment8' and `oplata` = '0' and `sum` = '$amount8' ");
}
if($status9 == 'SUCCESS' ){ //проверка если оплата успеша, идет попытка потверждения оплаты
  $comment9 = substr($comment9, 7, -1); //убираем лишние знаки у комментария при оплате
  $mysqltovarUPDATE9 = mysqli_query($dbconnect, "UPDATE `tabzakaz` SET `oplata` = '1'
  WHERE `id` = '$comment9' and `oplata` = '0' and `sum` = '$amount9' ");
}
if($status10 == 'SUCCESS' ){ //проверка если оплата успеша, идет попытка потверждения оплаты
  $comment10 = substr($comment10, 7, -1); //убираем лишние знаки у комментария при оплате
  $mysqltovarUPDATE10 = mysqli_query($dbconnect, "UPDATE `tabzakaz` SET `oplata` = '1'
  WHERE `id` = '$comment10' and `oplata` = '0' and `sum` = '$amount10' ");
}
if($status11 == 'SUCCESS' ){ //проверка если оплата успеша, идет попытка потверждения оплаты
  $comment11 = substr($comment11, 7, -1); //убираем лишние знаки у комментария при оплате
  $mysqltovarUPDATE11 = mysqli_query($dbconnect, "UPDATE `tabzakaz` SET `oplata` = '1'
  WHERE `id` = '$comment11' and `oplata` = '0' and `sum` = '$amount11' ");
}
exit();

//данная часть скрипта мусор, его можно оставить для будующих
//редакций это вывод платежей масива через echo
/*
echo "<br><br>$status0";
echo "<br><br>$amount0";
echo "<br><br>$comment0";

echo "<br><br>$status1";
echo "<br><br>$amount1";
echo "<br><br>$comment1";

echo "<br><br>$status2";
echo "<br><br>$amount2";
echo "<br><br>$comment2";
    
echo "<br><br>$status3";
echo "<br><br>$amount3";
echo "<br><br>$comment3";
    
echo "<br><br>$status4";
echo "<br><br>$amount4";
echo "<br><br>$comment4";
    
echo "<br><br>$status5";
echo "<br><br>$amount5";
echo "<br><br>$comment5";
    
echo "<br><br>$status6";
echo "<br><br>$amount6";
echo "<br><br>$comment6";

echo "<br><br>$status7";
echo "<br><br>$amount7";
echo "<br><br>$comment7";

echo "<br><br>$status8";
echo "<br><br>$amount8";
echo "<br><br>$comment8";
    
echo "<br><br>$status9";
echo "<br><br>$amount9";
echo "<br><br>$comment9";
    
echo "<br><br>$status10";
echo "<br><br>$amount10";
echo "<br><br>$comment10";
    
echo "<br><br>$status11";
echo "<br><br>$amount11";
echo "<br><br>$comment11";
$stringcomment = $comment2;
$stringcomment = substr($stringcomment, 7, -1);
   echo '<br>';
    echo $stringcomment;
    */
?>