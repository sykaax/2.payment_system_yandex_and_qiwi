<?php 
// на данной странице отображается последний купленный человеком товар
// если будет обнаружен hash то будет предложен вариант отправится на страницу buyw если не будет обнаружено хешей вообще
// то будет предложен вариант купить товар
session_start();
require '../db/dbconnect.php';
require '../functionphp/functions.php';

// проверка на ссесию и если всё есть, то делаем запрос в базу данных и выводим от тудаинформацию по купленному товару
if(!isset ($_SESSION['oplachhash'])){ 
	
header("Location: http:/../cab/mycab.php");// перенаправление на страницу личного кабинета если не обнаружена последний
// продажи
exit;
}

else{ // если ссесия установлена то выполняем этот код, запрос в базу данных и вывод товара купленного

	$sessionoplachhash = $_SESSION['oplachhash']; // назначение переменной ссесии
	
	$mysqlzakaztab = mysqli_query($dbconnect, "SELECT * FROM `tabzakaz` WHERE `oplachhash` = '$sessionoplachhash' ");
	// коннект к базе данных для получения данных
	
	// создание масива из таблицы MYSQL
	$assocmysqlzakaztab = mysqli_fetch_assoc ($mysqlzakaztab);	
		
	// назначение данных из масива базы данных полученого
    $oplachidzakaz = $assocmysqlzakaztab['id'];
	$oplachidtovaroplah = $assocmysqlzakaztab['idtovaroplach'];
    $oplachidtovarbuy = $assocmysqlzakaztab['idtovarbuy'];
	$oplachemail = $assocmysqlzakaztab['email'];
	$oplachsum = $assocmysqlzakaztab['sum'];
	$oplachdate = $assocmysqlzakaztab['dateend'];
	
	//коннект к товару и забирание информации из базы о товаре из идтоварполуч заказа
	$mysqltovartab = mysqli_query($dbconnect, "SELECT * FROM `tabrandom` WHERE `id` = '$oplachidtovaroplah' ");
	
    // создание масива из таблицы MYSQL
	$assocmysqltovartab = mysqli_fetch_assoc ($mysqltovartab);	
		
	// назначение данных из масива базы данных полученого
	$oplachtovar = $assocmysqltovartab['keytovar'];
	
    $querytb = "SELECT nametovar FROM `tabtovars` WHERE `idtovar` = '$oplachidtovarbuy' "; 
    $resulttb = mysqli_query($dbconnect,$querytb) or die(mysqli_error()); // запрос бд таблицы товаров 
	$rowtb = $resulttb->fetch_assoc();
    
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<div> 
	

	<?php // это форма которая будет отправлена по нажатию на кнопку, на buyw.php там уже делается генерация SESSION
	// и перенаправление на оплату сервиса оплаты
?>
<link rel="stylesheet" href="../css/style.css" />
<title>payment.comx - приём платежей.</title>
<link rel="icon" href="../images/favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"/>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
<div class="wrap">
<div class="namedeskup">
<div class="payment-types-title"><img  class="logopay" src="../images/logopay.png"  width="50">Оплаченный счёт<br><div class="linkpayment">payment.comx - приём платежей</div></div>
<ul id="menudesk">
  <li><a href="../cab/mycab.php"><img  class="logocorz" src="../images/logocorz.png"  width="11"> МОИ ПОКУПКИ</a></li>
  <li><a href="../contac/contac.php"><img  class="logopeople" src="../images/logopeople.png"  width="11"> КОНТАКТЫ</a></li>
  <li><a href="../contac/contac.php"><img  class="logotex" src="../images/logotex.png"  width="11"> ТЕХ. ПОДДЕРЖКА</a></li>
</ul>
</div>

<div class="zakazop"><p><?php echo 'Название: ' . $rowtb['nametovar'] . '  ' ;?></p></div>
<div class="authmail-panel-main">
    
    <?php  
    
         echo 'Счёт №'. $oplachidzakaz . 
             ' Оплачено ' . $oplachsum . '.00 руб.' .
             ' Дата (' . $oplachdate . 
             ')<br> E-mail (' . $oplachemail .
     ')<div class="oplatatovar"><div class="oplataHight">Ваш оплаченный товар:</div>  Используйте его: ' . $oplachtovar  .' </div>' ;
    
    ?>
    

</div> 
</div>
	
	</body>
	</html>



<?php
}




?>