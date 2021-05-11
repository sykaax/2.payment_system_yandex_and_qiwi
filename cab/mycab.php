<?php 
// на данной старнице показываются все покупки человека
// авторизация происходит по почте через authmail.php 
// человек заходит, исходя из его ссессии ищется покупки эмайла и его все заказы.
require '../db/dbconnect.php';
require '../functionphp/functions.php';
session_start();

	if(!isset($_SESSION["hashsession"])){ // проверяем авторизирован человек ли 
header("Location: authmail.php"); // если нету сессии с авторизацией по почте то отарвляем его авторизироватся
exit(); }
else{
	// пример как могли бы выводится данные на страницу это пример можно удалить
	//echo "вы успешно зашли на сайт ваша сессия";
	//echo $_SESSION['hashsession'];
	//echo "<br>ваш email ";
	//echo $_SESSION['email'];
    //echo " <br> ваш заказ $row[idzakaza] <br>";



	
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


<div class="authmail-panel-main">
    <table class="table"><tbody>
        <tr>
        <td>Номер счёта</td>
        <td>Цена </td>
        <td>Дата </td>
        </tr>
    <?php  
    
	$emailss = $_SESSION['email']; // назначение эмайла от которого нужно просмотреть заказы
	$query = "SELECT * FROM `tabzakaz` WHERE `email` = '$emailss' and `vidaltovar` = '1' ORDER BY id DESC"; // запрос к базе данных
	$sqlsq = mysqli_query($dbconnect,$query) or die(mysqli_error()); // сам запросс
	while ($result = mysqli_fetch_array($sqlsq)) { // цикл вайл который выводит все заказы в таблицу
		echo '
<tr>
<td><a href = "zakazt.php?idzakaza=' . $result['id'] . '&&idtovaroplach=' .  $result["idtovaroplach"] . '</a>">' . "
Счет оплаты ". $result['id'] ."</td>
<td>".$result['sum'] .".00 руб.</td>
<td>".$result['datestart'] ."</td>
</tr>
";}
	 
    
    ?>
    
    </tbody>
    </table>
     
 
 




</div> 
</div>
	
	</body>
	</html>
        <?php 
        }
        ?>