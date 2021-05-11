<?php
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
<div class="payment-types-title"><img  class="logopay" src="../images/logopay.png"  width="50">Оплата заказа<br><div class="linkpayment">payment.comx - приём платежей</div></div>
<ul id="menudesk">
  <li><a href="../cab/mycab.php"><img  class="logocorz" src="../images/logocorz.png"  width="11"> МОИ ПОКУПКИ</a></li>
  <li><a href="../contac/contac.php"><img  class="logopeople" src="../images/logopeople.png"  width="11"> КОНТАКТЫ</a></li>
  <li><a href="../contac/contac.php"><img  class="logotex" src="../images/logotex.png"  width="11"> ТЕХ. ПОДДЕРЖКА</a></li>
</ul>
</div>

<div class="authmail-panel-main">
    <div class="authmaildesk"><p>Оплата по вашему заказу ожидается, не закрывайте эту страницу, после оплаты вы получите товар здесь</p>
    </div>
    <img class="imgload" src="load.gif"><br>
<input type="submit" value="          Перейти на страницу оплаты          " onclick="submitfunc();">
    
    <script type="text/javascript">
    function deletefunc() {
    document.forms['deletefuncc'].submit();
	}
    </script>
    
    <form>
    <input name="deletezakazhash" type="submitsmal" value="Отменить оплату и вернутся" onclick="deletefunc();" 
            />
    </form>
    
<form action="" name="deletefuncc" method="POST">
  <input type="hidden"  name="deletezakazhash" value="Отменить оплату и вернутся">
</form> 

</div> 
</div>
	
	</body>
	</html>

