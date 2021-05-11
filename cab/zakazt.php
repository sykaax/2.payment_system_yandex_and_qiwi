<?php
	
	
	// на этой странице происходит показание товара оставление отзыва

session_start();
require '../db/dbconnect.php';
require '../functionphp/functions.php';
	
	if(!isset($_SESSION['hashsession'])){ // проверка установлена ли HASH SESSION если не установлена то отправляется на
	// атовризацию
header("Location: authmail.php"); 
exit(); 
}

else{ // если авторизацию установлена то делаем уже забор из GET данных и делаем запрос к бд

$idzakaza = $_GET['idzakaza']; // ид заказа который передан должен быть с mycab.php
$idtovaroplach = $_GET['idtovaroplach']; // оплаченый товар который был уканазн на страницы выборас способа buy.php


// Уборка вредоностного кода из GET
$idzakaza = funcformatstrnum($idzakaza);
$idtovaroplah = funcformatstrnum($idtovaroplah);
	
	
$emailss = $_SESSION["email"]; // установка значения из сессии
	

	$query = "SELECT * FROM `tabzakaz` WHERE `email` = '$emailss' and 
	`id` = '$idzakaza' ORDER BY id";
	$result = mysqli_query($dbconnect,$query) or die(mysqli_error()); // запрос бд таблицы закаов
    $row = $result->fetch_assoc();
	
	$queryt = "SELECT * FROM `tabrandom` WHERE `active` = '1' and  
	 `id` = '$idtovaroplach' "; 
    $resultt = mysqli_query($dbconnect,$queryt) or die(mysqli_error()); // запрос бд таблицы товаров 
	$rowt = $resultt->fetch_assoc();
	
    $rowtbquery = $row['idtovarbuy'];// назначение переменной из tabrandoms для tabtovars
    
    $querytb = "SELECT * FROM `tabtovars` WHERE `idtovar` = '$rowtbquery' "; 
    $resulttb = mysqli_query($dbconnect,$querytb) or die(mysqli_error()); // запрос бд таблицы товаров 
	$rowtb = $resulttb->fetch_assoc();
	
	// далее идет например код который можно удалить. 
	// просто код вывода товара
	//echo "вы успешно зашли на сайт ваша сессия";
	//echo $_SESSION["hashsession"];
	//echo "<br>ваш email ";
	//echo $_SESSION["email"];
	//echo " <br> ваш заказ $row[id] <br>";
	//echo "<HR>";
	//echo '<br> ваш заказ ' . $row['id'] . '<br>';
	//echo "<HR>";
    //echo '<div>' . $rowt['id'] . $rowt['akkeygift'] . ' Товар купленный ' . $rowt['keytovar'] .  '</div><br>
	//<div class="Block"> Ваш оплаченный товар ' . $rowt['keytovar'] .' <div>' ;
    ?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<div> 
	

	<?php // это форма которая будет отправлена по нажатию на кнопку, на buyw.php там уже делается генерация SESSION
	// и перенаправление на оплату сервиса оплаты?>
<link rel="stylesheet" href="../css/style.css" />
<title>payment.comx - приём платежей.</title>
<link rel="icon" href="../images/favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"/>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
<div class="wrap">
<div class="namedeskup">
<div class="payment-types-title"><img  class="logopay" src="../images/logopay.png"  width="50">Кабинет покупателя<br><div class="linkpayment">payment.comx - приём платежей</div></div>
<ul id="menudesk">
  <li><a href="../cab/mycab.php"><img  class="logocorz" src="../images/logocorz.png"  width="11"> МОИ ПОКУПКИ</a></li>
  <li><a href="../contac/contac.php"><img  class="logopeople" src="../images/logopeople.png"  width="11"> КОНТАКТЫ</a></li>
  <li><a href="../contac/contac.php"><img  class="logotex" src="../images/logotex.png"  width="11"> ТЕХ. ПОДДЕРЖКА</a></li>
</ul>
</div>

<div class="zakazop"><p><?php echo 'Название: ' . $rowtb['nametovar'] . '  ' ;?></p></div>
<div class="authmail-panel-main">
    
    <?php  
    
         echo 'Счёт №'. $row['id'] . 
             ' Оплачено ' . $row['sum'] . '.00 руб.' .
             ' Дата (' . $row['datestart'] .  
     ')<div class="oplatatovar"><div class="oplataHight">Ваш оплаченный товар:</div>  Используйте его: ' . $rowt['keytovar'] .' </div>' ;
    
    ?>
    
      
 
 



<input type="submit" class="oplataNazad" onclick="history.back();" value="Назад к покупкам"/>
</div> 
</div>
	
	</body>
	</html>

<?php
}