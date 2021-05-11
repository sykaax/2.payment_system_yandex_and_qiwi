<?php
// на этой странице происходит авторизация эмаил

session_start();
require '../db/dbconnect.php';
require '../functionphp/functions.php';

if (isset($_POST['emailauth'])){ //проверка установлен ли емаилаутч пост, нажата ли кнопка если нажата то
//делаем запрос в базу данных на наличие такой почты и отправляем на почту письмо

   $emailauth = $_POST['emailauth']; // емаил который был уканазн при нажатии на кнопку введите эмаил
   
   // Уборка вредоностного кода из POST
   $emailauth = funcformatstremail($emailauth);
  
  $mysqlemailauth = mysqli_query($dbconnect, "SELECT email FROM `tabauto` WHERE `email` = '$emailauth' ");
	// коннект к базе данных для получения данных
	
        if( mysqli_num_rows($mysqlemailauth) != 0 ){ // проверка существует ли такая почта
		
	$hashforemail = mt_rand(100000000, 199999999999); // генерация хеша почты
	
	$sqlhashforemail = mysqli_query($dbconnect, "UPDATE `tabauto` SET `hashforemail` = '$hashforemail' 
	WHERE `email` = '$emailauth' "); // обновление таблицы для того чтобы внести хеш эмайла авторизации пользователя
	
	// отправление письма с почтой
	$mail = mail("$emailauth", "Мои покупки $linkmyglobal", "Добрый день! Покупки вашего e-mail вы можете посмотреть здесь: $linkmyglobalhttpcab/authmail.php?hashforemail=$hashforemail");
	 
		if ($mail == true){ // проверка было ли отправлено письмо или нет.
		//	echo 'письмо было отправленно вам на почту';
            require 'authmailokay.php';
		}
            
		else{ // если почты не было найдено то пишем что такой почты небыло найдено
			//echo "<br> Такой почты не найдено";
            require 'authmailnone.php';
			exit;
		}
		
		}
		else{ // если письмо не было отправлено то пишем что почты не было найдено
			//echo "<br> Такой почты не найдено";
            require 'authmailnone.php';
			exit;
		}


 }
 elseif (isset($_GET['hashforemail']) and !isset($_SESSION['hashsession'])){ //проверка пришёл человек по ссылке и есть ли у него GEt параметр
 
  $hashforemail = $_GET['hashforemail']; // хеш который будем проверять
   
   // Уборка вредоностного кода из POST
   $hashforemail = funcformatstremail($hashforemail);
   
	$hashsession = mt_rand(100000000, 199999999999); //генерация хеша ссесии
	
	$mysqlhashforemalget = mysqli_query($dbconnect, "SELECT * FROM `tabauto` WHERE 
	`hashforemail` = '$hashforemail'"); // запрос есть ли эмаил с такм хешем или нету
	
	if( mysqli_num_rows($mysqlhashforemalget) == 1 ){ // проверка есть ответ от сервера по вопросу хеша или нет
	
	// создание масива из таблицы MYSQL
	$assocmysqlhashforemalget = mysqli_fetch_assoc ($mysqlhashforemalget);	
		
	// назначение данных из масива базы данных полученого
	$authemails = $assocmysqlhashforemalget['email'];
	
	$sqlhashsession = mysqli_query($dbconnect, "UPDATE `tabauto` SET 
	`hashsession` = '$hashsession' , `hashforemail` = '' WHERE 
	`hashforemail` = '$hashforemail' ");   // обновление таблицы и добавления генерированного хеша, удаление 
	// активированного get хеша из письма
	
	$_SESSION['email'] = $authemails;
	$_SESSION['hashsession'] = $hashsession;
	
	echo '<script type="text/javascript">location="mycab.php";</script>';
			
   }
   else{ // если человек дал неверный get параметр выйдет ошибка
				echo $hashforemail;
				echo " <div class='form'><h3>Ваша ссылка недействительна</h3><br/>Нажмите тут чтобы сгеннерировать <a href='authmail.php'>Новая ссылка</a></div>";
				}
    }
elseif( isset($_SESSION['hashsession'])){
	echo 'Добрый день вы уже авторизованны';
	echo '<script type="text/javascript">location="mycab.php";</script>';
}
	else{// вывод кода оставления кнопки
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>


    <html>
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
<div class="payment-types-title"><img  class="logopay" src="../images/logopay.png"  width="50">Вход в кабинет покупателя<br><div class="linkpayment">payment.comx - приём платежей</div></div>
<ul id="menudesk">
  <li><a href="../cab/mycab.php"><img  class="logocorz" src="../images/logocorz.png"  width="11"> МОИ ПОКУПКИ</a></li>
  <li><a href="../contac/contac.php"><img  class="logopeople" src="../images/logopeople.png"  width="11"> КОНТАКТЫ</a></li>
  <li><a href="../contac/contac.php"><img  class="logotex" src="../images/logotex.png"  width="11"> ТЕХ. ПОДДЕРЖКА</a></li>
</ul>
</div>



<div class="authmail-panel-main">
    
  <div class="authmaildesk">
Для доступа ко всем вашим покупкам необходимо авторизоваться. 
Введите ваш E-mail который вы использовали при покупках и капчу, после чего вам на почту поступит авторизационная ссылка.
</div>
      
<div class="form">
<form action="" method="post" name="emailauth">
<input type="email" name="emailauth" placeholder="Введите ваш E-mail" required>
<input name="submit" type="submit" value="Отправить ссылку для входа" />
</form>

 </div>
 




</div> 
</div>
</div>
	
	<body>
	</html>
    

<?php 
	}

?>

