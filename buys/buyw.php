<?php 
// Данная страница принимает с GET параметры, сверяет их с базой данных и если все совпадает, записывает заказ в базу данных
// и отправляет человека по форме на страницу оплаты яндекс денег или киви, потом обновляется и ждет завершения покупки, после
// завершения покупки и проверка когда пришла оплата, стараница выдает товар и перенаправляет уже на страницу купленного товара
session_start();
require '../db/dbconnect.php';
require '../functionphp/functions.php';


$getid = $_GET['id']; // айди товара который покупается (все цены, имена на него уже из базы данных братся будут)
$getpaymenttype = $_GET['paymenttype']; // тип способа оплаты который передается с buy.php
$getpar = $_GET['par']; // айди партнера которому с продажи поступят деньги
$getpar2 = $_GET['par2']; // айди реферала уже партнера которому с продажи поступят деньги 10%
$getemail = $_GET['emailzakaz']; // емаил который был уканазн на страницы выборас способа buy.php

// Уборка вредоностного кода из GET
$getid = funcformatstrnum($getid);
$getpaymenttype = funcformatstremail($getpaymenttype);
$getpar = funcformatstrnum($getpar);
$getpar2 = funcformatstrnum($getpar2);
$getemail = funcformatstremail($getemail);

//специальная проверка и возможность удалить свой заказ, во время проведения оплаты
// проверка есть ли запрос на удалиние заказа и возврат назад к выбору оплаты 
if(isset ($_POST['deletezakazhash']) and isset($_SESSION['zakazhash'])){
    
    //установка переменной хеша из ссесии
    $hashzakaz = $_SESSION['zakazhash'];
    
    //запрос в базу данных для извлечения ида товара, партнерского ида чтобы передать на страницу
    //обратно к выбору оплату, нужно знать ид товара который человек покупал и у кого
    $mysqldeletetovarcheck = mysqli_query($dbconnect, "SELECT idtovarbuy, idpart, idreferal FROM `tabzakaz` WHERE 
	`zakazhash` = '$hashzakaz' AND `oplata` = '0' AND `vidaltovar` = '0'");
    
    //проверка успешен ли запрос в базу данных был если всё хорошо берем ид товара, пратнера и
    //удаляем заказ, перенаправляя на страницу покупки товара, выбора способа оплаты.
	if(mysqli_num_rows($mysqldeletetovarcheck) != 0){
        
    // создание масива из таблицы MYSQL
	$assocmysqldeletetovarcheck = mysqli_fetch_assoc ($mysqldeletetovarcheck);
        
    // присваивание данных из таблицы MYSQL чтобы использовать их в ссылке
    $deleteidtovarbuy = $assocmysqldeletetovarcheck['idtovarbuy'];
    $deleteidpart = $assocmysqldeletetovarcheck['idpart'];
    $deleteidreferal = $assocmysqldeletetovarcheck['idreferal'];
        
     //удаление заказа из базы данных
    $mysqlvidaltovardelete = mysqli_query($dbconnect, "delete from `tabzakaz` where `zakazhash` = '$hashzakaz'");
    }
    
	session_destroy(); //удаление всех ссесий чтобы можно было начать покупку товара
	header("Location: http://payment.comx/buys/buy.php?id=$deleteidtovarbuy&par=$deleteidpart&par2=$deleteidreferal");// возвращаемся на страницу выбора способа оплаты
	exit;
}
// проверка установлена ссесия заказа или нету неоплаченного заказа 
elseif (!isset($_SESSION['zakazhash']) and !isset($_SESSION['oplachhash'])){
	// код првоерки существует ли товар в базе данных или нет, если есть то делается заказ устанавливается сессия
	$mysqlqidtovar = mysqli_query($dbconnect, "SELECT idtovar, nametovar, price, priceprofit, descoplata FROM `tabtovars` WHERE `idtovar` = '$getid' ");
	if (  mysqli_num_rows($mysqlqidtovar) == 0 )
	{
		header("Location: http:/buys/buywtovarnone.php");
		exit;
	}
	// если проверка прошла то делается назначение переменных и создается заказ с хешем
	else{
		
	// создание масива из таблицы MYSQL
	$associdtovar = mysqli_fetch_assoc ($mysqlqidtovar);	
		
	// назначение данных из масива базы данных полученого
	$buynametovar = $associdtovar['nametovar'];
	$buyprice = $associdtovar['price']; 
	$buypriceprofit = $associdtovar['priceprofit'];
	$buyidtovar = $associdtovar['idtovar'];
	$zakazhash = mt_rand(100000000000, 1999999999999999); // создание индивидуального хеша для сесси
	
	//создания заказа и запись его в базу данных ниже
	$mysqlqzakaz = mysqli_query($dbconnect, "INSERT INTO `tabzakaz` (`id`, `email`, `idtovarbuy`,`idtovaroplach`, 
`sum`, `sumproficit`, `zakazhash`, `oplata`, `idpart`, `idreferal`, `datestart`, `dateend`, `vidaltovar`, `paymenttype`
, `oplachhash` ) 
VALUES (NULL, '$getemail', '$getid', NULL, '$buyprice', '$buypriceprofit', '$zakazhash', '0', '$getpar', 
'$getpar2', CURRENT_TIMESTAMP, NULL, '0', '$getpaymenttype', NULL ); ") or die("Ошибка " . mysqli_error($dbconnect));
 echo 'запись в базу данных';
 echo $getpaymenttype;
    $_SESSION['zakazhash'] = $zakazhash; // Установка сессии для индефикации покупки
	echo "<SCRIPT LANGUAGE=javascript>window.location.reload()</SCRIPT>";// обновление автоматическое страницы 
	}	
}
elseif(isset ($_SESSION['oplachhash'])){// Если установлена сессия товара кулпенного то предлагаем либо продолжить покупку
// либо вернутся на страницу купленного товара
    
	if(isset ($_POST['deleteoplachhash'])){
	session_destroy(); //удаление всех ссесий чтобы можно было начать покупку товара
	echo "<SCRIPT LANGUAGE=javascript>window.location.reload()</SCRIPT>";// перезагружаем страницу
	exit;
	}
	elseif(isset ($_POST['gooplachhash'])){ // перенаправление на страницу купленного товара
	header("Location: http:/buys/buywoplach.php");
	exit;
	}
	else{ // если постов не передано то просто выводятся 2 кнопки для выдачи метода пост.
		//echo 'Добрый день! Вы уже покупали у нас товар, желаете посмотреть уже купленный товар или купить новый?' . '
		//<form action="" method="POST">
     //<input name="gooplachhash" type="submit" value="Посмотреть уже купленный товар" />
	 //<input name="deleteoplachhash" type="submit" value="Продолжить покупку нового товара" />
//</form> ' ;
        require 'buyhtmlpokupali.php';
	}
}
//в случае если сессия устанавлена значит выполняется другой код который будет показывать кнопку оплаты
//по нажатию на которую человек будет отправлятся уже на сайт платежной системы, но эта страница должна будет ждать и обновалятся
//пока не пройдет оплата а когда пройдет то должно проивестись выдача тоара человеку
else{
	$hashzakaz = $_SESSION['zakazhash'];
	//сразу идет проверка и обращение в базу данных прошла ли оплата или нет, если не прошла то вывод окна с оплатой и кнопкой
	$oplatamysqltest = mysqli_query($dbconnect, "SELECT zakazhash, oplata, vidaltovar 
	FROM `tabzakaz` WHERE `zakazhash` = '$hashzakaz' AND `oplata` = '1' AND `vidaltovar` = '0' ");
	if(mysqli_num_rows($oplatamysqltest) == 0){
		
	$oplataform = mysqli_query($dbconnect, "SELECT id, zakazhash, oplata, vidaltovar, sum, paymenttype 
	FROM `tabzakaz` WHERE `zakazhash` = '$hashzakaz' AND `oplata` = '0' AND `vidaltovar` = '0' ");
	
	// здесь означает что человек не произвел оплату и ему нужно выдать кнопку для оплаты и сказать что нужно оплатить
	// после этого обновить страницу автоматически для того чтобы проверить пришла оплата или нет и запустить другой скрипт
	
	// создание масива из таблицы MYSQL
	$assocoplataform = mysqli_fetch_assoc ($oplataform);	
	
	// назначение данных из масива базы данных полученого
	$butformidzakaza = $assocoplataform['id']; 
	$butformsum = $assocoplataform['sum'];
    $butformpaymenttype = $assocoplataform['paymenttype']; 	
	
	require 'buywform.php'; // подключение файла с формами для оплаты
	
	//echo '<input type="submit" value="Перейти на //страницу оплаты" onclick="submitfunc();">'; // кнопка по нажатию на которую вызовится функция
	// js которая отправит форму платежную из файла buywform.php исходя из пааметра paymenttype
	
	//echo 'Оплата по вашему заказу ожидается, не закрывайте эту страницу, после оплаты вы получите товар здесь'; 
    // кнопка для отмены оплтаы и возвращения назад
   // echo ' <form action="" method="POST">
   // <input name="deletezakazhash" type="submit" value="Отменить оплату и вернутся на страницу выбора способа оплаты" />
//</form> ' ;
	
	
	
	echo "<SCRIPT LANGUAGE=javascript>
	function reloadbuyw() {
  window.location.reload();
}  setTimeout(reloadbuyw, 10000);
	</SCRIPT>";
	// скрипт обновления страницы для проверки пришла ли оплата
	
    require 'buyhtmlwait.php';
	
	
	exit;

}
	else{
	// дополнительная проверка и поиск заказа где оплата прошла а товар не выдан, после этого будет
	// происходить выдача товара с последющим созданием сессии для просмотра товара и страницой купленного товара
	$mysqlvidaltovarcheck = mysqli_query($dbconnect, "SELECT email, idtovarbuy FROM `tabzakaz` WHERE 
	`zakazhash` = '$hashzakaz' AND `oplata` = '1' AND `vidaltovar` = '0'");
	if(mysqli_num_rows($mysqlvidaltovarcheck) != 0){
		
	unset($_SESSION['zakazhash']); // удаление ссессии для невозможности повторного прохождения покупки
	$oplachhash = mt_rand(100000000000, 1999999999999999); // создание индивидуального хеша для сесси кулпенного товара
	$_SESSION['oplachhash'] = $oplachhash ; // установка хеша кодированного для просмотра купленного товара
	
	// создание масива из таблицы MYSQL
	$assocmysqlvidaltovarcheck = mysqli_fetch_assoc ($mysqlvidaltovarcheck);	
		
	// назначение данных из масива базы данных полученого
	$buypoluchemail = $assocmysqlvidaltovarcheck['email'];
	$buypoluchidtovarbuy = $assocmysqlvidaltovarcheck['idtovarbuy'];
	
	// далее идет код проверки существует в базе авторизации уже человек с таким эмаилом или нет,
   // если покупка совершается в первый раз на данный эмаил то создается почта в базе данных для авторизации
	 $query = "SELECT email FROM `tabauto` WHERE `email` = '$buypoluchemail'"; // запрос который пойдет в базу данных
	 $result = mysqli_query($dbconnect,$query) or die(mysql_error()); // ответ и запрашиваем в базу данных 
	 $rows = mysqli_num_rows($result); // создание масива из полученного резултата
     if($rows != 1){ // проверка есть ли эмаил в базе данных или покупается впервые товар если
	$query = "INSERT INTO `tabauto` (`email`) VALUES ('$buypoluchemail'); ";
    $result = mysqli_query($dbconnect, $query) or die("Ошибка " . mysqli_error($dbconnect));
            }
			
	// выбор свободного товара из базы данных, с привязкой к заказу для покупателя
	$mysqlfreetovar = mysqli_query($dbconnect, "SELECT * FROM `tabrandom` WHERE `active` = '0' AND `idtovara` = '$buypoluchidtovarbuy' LIMIT 1 ")or die("Ошибка " . mysqli_error($dbconnect));
	// создание масива из таблицы MYSQL где свободный товар чтобы его ид записать и присовоить заказу
	$assocmysqlfreetovar = mysqli_fetch_assoc ($mysqlfreetovar);	
	// назначение данных из масива базы данных полученого, запись ида для того чтобы присвоить его заказу
	$buyfreeid = $assocmysqlfreetovar['id']; 
    // обновление MYSQL и занесения в таблицу товары данные о том что товар куплен и получен, привязан к эмаил и заказу
	$mysqlfreetovarUPDATE = mysqli_query($dbconnect, "UPDATE `tabrandom` SET `active` = '1'
	 WHERE `id` = '$buyfreeid' ")or die("Ошибка " . mysqli_error($dbconnect));
	// обновление MYSQL таблицы заказа и занесения туда данных о купленном товаре
    $mysqlfreetovartabzakaz = mysqli_query($dbconnect,"UPDATE `tabzakaz` SET `idtovaroplach` = '$buyfreeid', `dateend` = CURRENT_TIMESTAMP ,
	`vidaltovar` = '1' , `oplachhash` = '$oplachhash' WHERE `zakazhash` = '$hashzakaz' ")or die("Ошибка " . mysqli_error($dbconnect));
	// Отправка уведомления о том что товар купленн на почту
	$mail = mail('$buypoluchemail', 'Оплаченный товар', 'Добрый день спасибо за покупку вот ссылка $linkmycabglobal');
	
	header("Location: http:/buys/buywoplach.php");
		exit;
	
		}
		//если проверка не прошла и ответа от mysql на заказ, hash и oplata не прошла выводим ошибку о том что
		//оплата не прошла или уже прошла но товар был выдан
		else{
			echo 'Произошла ошибка данного заказа не найдено обратитесь в поддержку';
			exit;
		}
		
	}
}



?>