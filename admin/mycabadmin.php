<?php 
// на данной старнице показываются все покупки человека
// авторизация происходит по почте через authmail.php 
// человек заходит, исходя из его ссессии ищется покупки эмайла и его все заказы.
require '../db/dbconnect.php';
require '../functionphp/functions.php';
session_start();

	if(!isset($_SESSION["hashsessionadmin"])){ // проверяем авторизирован человек ли 
header("Location: authmailadmin.php"); // если нету сессии с авторизацией по почте то отарвляем его авторизироватся
exit(); }
else{
    
    // проверка есть ли запрос на просмотр стори, если есть подключаем страницу admincheckhistory.php
    if(isset ($_POST['checkhistory'])){
        require 'admincheckhistory.php';
        exit();
    }
    
    //проеврка есть ли запрос за вывод киви. если есть, то добалвяем запрос в базу и ставим товарам
    // что деньги с товаров получит партнер
    if(isset ($_POST['zakazqiwi'])){
        
     $emailadmin = $_SESSION['emailadmin']; // назначение эмайла от которого нужно просмотреть заказы
    
    //запрос в базу данных для получения айди партнера чтобы сделать запрос
    $querytb = "SELECT * FROM `tabadmins` WHERE `email` = '$emailadmin' "; 
    $resulttb = mysqli_query($dbconnect,$querytb) or die(mysqli_error()); // запрос бд таблицы товаров 
	$rowtb = $resulttb->fetch_assoc();
        
    // назначение  переменных для упрощёной работы
    $idpart = $rowtb['idpart'];
    $wvivodqiwi = $rowtb['wvivodqiwi']; // партнер ожидает 10-го числа зачесления на киви
     
        
    //запрос в базу данных для получения всех оплаченных заказов партнера, с которых
    //он ещё не получил деньги за вывод
    $queryz = "SELECT SUM(`sumproficit`) FROM `tabzakaz` WHERE `idpart` = '$idpart' and `oplata` = '1' and `moneypart` = '0' and `paymenttype` = 'payQIWi' "; 
    $resultt = mysqli_query($dbconnect,$queryz) or die(mysqli_error()); // запрос бд таблицы товаров 
	$rowt = $resultt->fetch_assoc();    
        
    $sumproficit = $rowt['SUM(`sumproficit`)']; //назначение переменной общего количества денег которое будет зачислено
    
    // обновление MYSQL таблицы заказов, установка что партнер заказал вывод денег
    $mysqlsumproficitupdate = mysqli_query($dbconnect,"UPDATE `tabzakaz` SET `moneypart` = '1'  WHERE `idpart` = '$idpart' and `oplata` = '1' and `moneypart` = '0' and `paymenttype` = 'payQIWi' ")or die("Ошибка " . mysqli_error($dbconnect));
        
    // обновление MYSQL таблицы админов, установка что партнер заказ вывод денег + 
    // соединяем сколько денег с прошлого запроса у него там осталось денег
    
    $wvivodqiwiend = $wvivodqiwi + $sumproficit;// сложение того что было и то что добавляется на запрос вывести
        
    $mysqlwvivodqiwiend = mysqli_query($dbconnect,"UPDATE `tabadmins` SET `wvivodqiwi` = '$wvivodqiwiend'  WHERE `idpart` = '$idpart' ")or die("Ошибка " . mysqli_error($dbconnect));    

    header("Location: mycabadmin.php");// перенаправлению на страницу чтобы убрался POST Запрос
        exit();
    }
    
    //идёт проверка на запрос нужно ли вывести деньги на яндекс.
    if(isset ($_POST['zakazyand'])){
        
    $emailadmin = $_SESSION['emailadmin']; // назначение эмайла от которого нужно просмотреть заказы
    
    //запрос в базу данных для получения айди партнера чтобы сделать запрос
    $querytb = "SELECT * FROM `tabadmins` WHERE `email` = '$emailadmin' "; 
    $resulttb = mysqli_query($dbconnect,$querytb) or die(mysqli_error()); // запрос бд таблицы товаров 
	$rowtb = $resulttb->fetch_assoc();
        
    // назначение  переменных для упрощёной работы
    $idpart = $rowtb['idpart'];
    $wvivodqiwi = $rowtb['wvivodyand']; // партнер ожидает 10-го числа зачесления на яндекс деньги
       
    //запрос в базу данных для получения всех оплаченных заказов партнера, с которых
    //он ещё не получил деньги за вывод
    $queryz = "SELECT SUM(`sumproficit`) FROM `tabzakaz` WHERE `idpart` = '$idpart' and `oplata` = '1' and `moneypart` = '0' and `paymenttype` != 'payQIWi' "; 
    $resultt = mysqli_query($dbconnect,$queryz) or die(mysqli_error()); // запрос бд таблицы товаров 
	$rowt = $resultt->fetch_assoc();    
        
    $sumproficit = $rowt['SUM(`sumproficit`)']; //назначение переменной общего количества денег которое будет зачислено
    
    // обновление MYSQL таблицы заказов, установка что партнер заказал вывод денег
    $mysqlsumproficitupdate = mysqli_query($dbconnect,"UPDATE `tabzakaz` SET `moneypart` = '1'  WHERE `idpart` = '$idpart' and `oplata` = '1' and `moneypart` = '0' and `paymenttype` != 'payQIWi' ")or die("Ошибка " . mysqli_error($dbconnect));
        
    // обновление MYSQL таблицы админов, установка что партнер заказ вывод денег + 
    // соединяем сколько денег с прошлого запроса у него там осталось денег
    
    $wvivodqiwiend = $wvivodqiwi + $sumproficit;// сложение того что было и то что добавляется на запрос вывести
        
    $mysqlwvivodqiwiend = mysqli_query($dbconnect,"UPDATE `tabadmins` SET `wvivodyand` = '$wvivodqiwiend'  WHERE `idpart` = '$idpart' ")or die("Ошибка " . mysqli_error($dbconnect)); 
    
    
    header("Location: mycabadmin.php");// перенаправлению на страницу чтобы убрался POST Запрос
        exit();
    }
	// пример как могли бы выводится данные на страницу это пример можно удалить
	//echo "вы успешно зашли на сайт ваша сессия";
	//echo $_SESSION['hashsession'];
	//echo "<br>ваш email ";
	//echo $_SESSION['email'];
    //echo " <br> ваш заказ $row[idzakaza] <br>";

    $emailadmin = $_SESSION['emailadmin']; // назначение эмайла от которого нужно просмотреть заказы
    
    //запрос в базу данных для получения айди партнера чтобы сделать запрос
    $querytb = "SELECT * FROM `tabadmins` WHERE `email` = '$emailadmin' "; 
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
        Выведено на ваш Yandex кошелёк за всё время: <?php  echo $rowtb['allvivodwasyand']; ?>.00 руб.
        <br> Выведено на ваш Qiwi кошелёк за всё время: <?php  echo $rowtb['allvivodwasqiwi']; ?>.00 руб.
        </div>
        <div class="authmaildesk">Вывод денег производится 10-го, 20-го и 30-го числа
        каждого месяца. <br>В следующий день вывода вы полчите: <br>
            <?php  echo $rowtb['wvivodyand']; ?>.00 руб на ваш Yandex кошелёк.<br>
            <?php  echo $rowtb['wvivodqiwi']; ?>.00 руб на ваш Qiwi кошелёк.<br>
            Для заказа вывода денег вам нужно нажать на кнопку внизу "Заказать вывод".
        </div>
        <tbody>
        <tr>
        <td>Номер счёта</td>
        <td>Цена </td>
        <td>Ваша прибыль <br>(вы получаете 70% от прибыли)</td>
         <td>Вывод денег доступен через </td>
        <td>Дата </td>
        </tr>
    <?php
    $idpart = $rowtb['idpart']; // назначение ида партнера чтобы посмотреть его покупки
    
	$query = "SELECT * FROM `tabzakaz` WHERE `idpart` = '$idpart' and `oplata` = '1' and `moneypart` = '0' ORDER BY id DESC"; // запрос к базе данных
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
<form action="" method="POST">
  <input type="submit"  name="zakazqiwi" value="Заказать вывод на ваш Qiwi кошелёк.     ">
    <input type="submit"  name="zakazyand" value="Заказать вывод на ваш Yandex кошелёк.">
</form>
    <?php echo '<div class="authmaildesk">Вывод Qiwi будет сделан на кошелёк ' .$rowtb['qiwipur'] ;?>
    <?php echo '.</div><div class="authmaildesk">Вывод Yandex будет сделан на кошелёк ' .$rowtb['yandpur'] . '.</div>' ;?>

<form action="" method="POST">
<input type="submit"  name="checkhistory" value="Посмотреть архив ваших зачислений">
</form>
</div> 
</div>
	
	</body>
	</html>
        <?php 
        }
        ?>