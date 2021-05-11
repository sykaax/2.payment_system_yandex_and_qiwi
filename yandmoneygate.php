<?php
require 'db/dbconnect.php';
require 'functionphp/functions.php';
//данный файл получает post запрос от yandex money и потом из этого пост запроса нужно взять данные и поместить в базу данных о том что оплата прошла

$hash = sha1($_POST['notification_type'].'&'.
$_POST['operation_id'].'&'.
$_POST['amount'].'&'.
$_POST['currency'].'&'.
$_POST['datetime'].'&'.
$_POST['sender'].'&'.
$_POST['codepro'].'&'.
'g5E3+p3Of1bLCRpX5DOx2bRM'.'&'.
$_POST['label']);

$sha1_hash = $_POST['sha1_hash']; // хеш секрет пароль который получил из яндекс денег
$codepro = $_POST['codepro']; // платеж защищен кодом протекции, хуй знает чо но это не дает деньги
$unaccepted = $_POST['unaccepted']; // флаг означает что платеж не получен, заморожен
$label = $_POST['label']; // номер заказа
$amount = $_POST['amount']; // сумма опперации


// проверка совпадает ли сгенерированный хеш с хешом моим, хуй знает как это работает, но вроде как то работает.
if ( $_POST['sha1_hash'] != $hash or $_POST['codepro'] === true or $_POST['unaccepted'] === true) exit('error4');

// проверка правильная ли сумма в итоге уплачена или нет.
  $mysqoplatacheck = mysqli_query($dbconnect, "SELECT * FROM `tabzakaz` WHERE 
	`id` = '$label' and `oplata` = '0' ");
    
    //проверка успешен ли запрос в базу данных был если всё хорошо берем ид товара, пратнера и
    //удаляем заказ, перенаправляя на страницу покупки товара, выбора способа оплаты.
	if(mysqli_num_rows($mysqoplatacheck) != 0){
        
    // создание масива из таблицы MYSQL
	$assocmysqoplatacheck = mysqli_fetch_assoc ($mysqoplatacheck);
	
	$sumcheck = $assocmysqoplatacheck['sum'];
	
	// код ниже проверяет разницу в цифрах в базе данных и с яндекс денег уведомления если разница меньше 20% то всё ок.
	$amountcheck = $amount;
	
	$endamountcheck = floor($amountcheck * 100) / 100;
	
	$endamountcheck1procent = $endamountcheck / 100;
	
	$endamountcheck1sum =  $endamountcheck1procent * 120;
	
	$endamountcheck1sum2d = floor($endamountcheck1sum * 100) / 100;
	
	
	if($endamountcheck1sum2d < $sumcheck){
		exit('eror oplata x2');
	}
	
	else{
		// просто строчка которая означает все хорошо её не удалять пусть будет.
	}
	
	} 
	else {
	 exit('eror oplata numbers');	
	}

// запись в базу данных если exit несработал
  $mysqltovarUPDATEyandex = mysqli_query($dbconnect, "UPDATE `tabzakaz` SET `oplata` = '1'
  WHERE `id` = '$label' and `oplata` = '0' and `sum` = '$sumcheck' ");


?>
