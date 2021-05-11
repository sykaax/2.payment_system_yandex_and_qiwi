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
<div class="payment-types-title"><img  class="logopay" src="../images/logopay.png"  width="50">Кабинет администратора<br><div class="linkpayment">payment.comx - приём платежей</div></div>
<ul id="menudesk">
  <li><a href="../cab/mycab.php"><img  class="logocorz" src="../images/logocorz.png"  width="11"> МОИ ПОКУПКИ</a></li>
  <li><a href="../contac/contac.php"><img  class="logopeople" src="../images/logopeople.png"  width="11"> КОНТАКТЫ</a></li>
  <li><a href="../contac/contac.php"><img  class="logotex" src="../images/logotex.png"  width="11"> ТЕХ. ПОДДЕРЖКА</a></li>
</ul>
</div>


<div class="authmail-panel-main">
    <table class="table">
        <div class="authmaildesk">
        Здесь показаны все ваши поступления, все продажи с которых был заказан вывод денег.
        После нажатия на кнопку заказа вывода денег на киви или яндекс ваши продажи с основной страницы перемещаются сюда и находятся в архиве здесь.
        </div>
        
        <tbody>
        <tr>
        <td>Номер счёта</td>
        <td>Цена </td>
        <td>Ваша прибыль <br>(вы получаете 70% от прибыли)</td>
         <td>Вывод денег был заказан через </td>
        <td>Дата </td>
        </tr>
    <?php
                $emailadmin = $_SESSION['emailadmin']; // назначение эмайла от которого нужно просмотреть заказы
    
    //запрос в базу данных для получения айди партнера чтобы сделать запрос
    $querytb = "SELECT * FROM `tabadmins` WHERE `email` = '$emailadmin' "; 
    $resulttb = mysqli_query($dbconnect,$querytb) or die(mysqli_error()); // запрос бд таблицы товаров 
	$rowtb = $resulttb->fetch_assoc();
            
    $idpart = $rowtb['idpart']; // назначение ида партнера чтобы посмотреть его покупки
    
	$query = "SELECT * FROM `tabzakaz` WHERE `idpart` = '$idpart' and `oplata` = '1' and `moneypart` = '1' ORDER BY id DESC"; // запрос к базе данных
	$sqlsq = mysqli_query($dbconnect,$query) or die(mysqli_error()); // сам запросс
	while ($result = mysqli_fetch_array($sqlsq)) { // цикл вайл который выводит все заказы в таблицу
         if($result['paymenttype'] === 'payQIWi'){
        $resultpaymenttype = 'Оплачено с помощью QIWI';
    }
    else{
    $resultpaymenttype = 'Оплачено с помощью YandexMoney';
    }
		echo '
<tr>
<td>' . "
Счет оплаты ". $result['id'] ."</td>
<td>".$result['sum'] .".00 руб.</td>
<td>".$result['sumproficit'] .".00 руб.</td>
<td>".$resultpaymenttype ."</td>
<td>".$result['datestart'] ."</td>
</tr>
";}
    
    //далее идут формы которые через POST делаю вывод денег и редакцию базу данных
    //добавляя деньги на заказ вывода.
	?>
    
    </tbody>
    </table>
     
 
 <br>

<form action="mycabadmin.php" method="POST">
<input type="submit"  name="" value="Вернутся на страницу основную">
</form>
</div> 
</div>
	
	</body>
	</html>