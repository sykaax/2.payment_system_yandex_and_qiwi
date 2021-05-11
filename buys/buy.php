<?php 
// данный файл отвечает за вывод страницы покупки товара и перенаправление на оплату
// файл сверяет из get параментров данные с таблицой товаров доступных для покупки и в случае
// успешного ответа от базы данных страница предлагает выбрать способ оплаты и по нажатию на кнопку оплатить
// принимает емаил, через форму post-get отправляет на страницу buyw.php предварительно создав SESSION HASH
// через который уже будет индифицироватся заказ, также идет запись в базу данных о том что создается новый заказ
// и покупается такой то товар по такой то цене в такую то дату и т д. Дальнейшая обработка заказа происходит на
// buyw.php. А эта старница только геннерирует заказ и отправляет человека на страницу ожидания оплаты. страница
// ожидания товара уже в свою очередь из HASH смотрит заказ и геннерирует post форму для отправлений пользователя
// на страницу платежной системы. Страница buyw.php не должна закрыватся и просто будет ждать когда скрипты
// зачисят деньги и потвердят оплату. В случае когда оплата будет зачислена а товар не будет выдан, то будет
// произведена опперация по Завершению заказа в базе данных а также удалению сессию HASHZAKAZ и создания
// сессии HASHOPLAT по которой пользователь сможет прсомотреть конкретно свой купленный товар
require '../db/dbconnect.php';
require '../functionphp/functions.php';
$getid = $_GET['id']; // айди товара который покупается (все цены, имена на него уже из базы данных братся будут)
$getpar = $_GET['par']; // айди партнера которому с продажи поступят деньги
$getpar2 = $_GET['par2']; // айди реферала уже партнера которому с продажи поступят деньги
 
// Уборка вредоностного кода из GET
$getid = funcformatstrnum($getid);
$getpar = funcformatstrnum($getpar);
$getpar2 = funcformatstrnum($getpar2);

// Проверка наличия товара и установка переменных Имени, цены, описания товара из таблицы
// в случае ненахождиения товара из GET запроса пользователя, пользовтаель перенаправляется на страницу ошибки
// в случае нахождения выводится код для продолжения оплаты товара, ввод эмаил и способа оплаты.
$mysqlqidtovar = mysqli_query($dbconnect, "SELECT idtovar, nametovar, price, descoplata FROM `tabtovars` WHERE `idtovar` = '$getid' ");
	
	if (  mysqli_num_rows($mysqlqidtovar) == 0 )
	{
		header("Location: http:/buys/buytovarnone.php");
		exit;
	}
	
	//ниже выводится код оплаты товара
	else {
	// создание масива из таблицы MYSQL
	$associdtovar = mysqli_fetch_assoc ($mysqlqidtovar);	
		
	// назначение данных из масива базы данных полученого
	$buynametovar = $associdtovar['nametovar'];
	$buyprice = $associdtovar['price']; 
	$buydescoplata = $associdtovar['descoplata'];
	$buyidtovar = $associdtovar['idtovar'];
    
	//Код самой страницы оплаты для выбора способа оплаты и отправления 
	//echo 'Добрый день вы собираетесь купить товар ' . $buynametovar .
	//' <br>по цене ' .// $buyprice . ' <br>описание товара ' . $associdtovar['descoplata'];
	
	?> 
	<html>
	<body>
    <head>
        
        </head>
	<div> 
	<?php // это скрипт который принимает выбор способа оплаты и меняет значение способа оплаты в форме ниже?>
  <script type="text/javascript">

function payform (id) {
const elem = document.querySelector('.active');
elem.classList.remove('active');
elem.classList.add('inactive');
id1 = id;
id = '#' + id;

const elemid = document.querySelector(id);
elemid.classList.remove('inactive');
elemid.classList.add('active');
document.getElementById('paymenttype').value = id1;
	}

</script>

	<?php // это форма которая будет отправлена по нажатию на кнопку, на buyw.php там уже делается генерация SESSION
	// и перенаправление на оплату сервиса оплаты?>
<link rel="stylesheet" href="../css/style.css" />
<title>payment.comx - приём платежей.</title>
<link rel="icon" href="../images/favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"/>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">

<div class="wrap">
<div class="namedeskup">
<div class="payment-types-title"><img  class="logopay" src="../images/logopay.png"  width="50">Выберите способ оплаты<br><div class="linkpayment">payment.comx - приём платежей</div></div>
<ul id="menudesk">
  <li><a href="../cab/mycab.php"><img  class="logocorz" src="../images/logocorz.png"  width="11"> МОИ ПОКУПКИ</a></li>
  <li><a href="../contac/contac.php"><img  class="logopeople" src="../images/logopeople.png"  width="11"> КОНТАКТЫ</a></li>
  <li><a href="../contac/contac.php"><img  class="logotex" src="../images/logotex.png"  width="11"> ТЕХ. ПОДДЕРЖКА</a></li>
</ul>
</div>
<div class="namedeskupdown2">
<div class="greypolosa"> 
<div class="paymentnalichie"> 
<p>в наличии</p>
</div>
<div class="paymentkupit">
<p><img  class="logoprice" src="../images/logoprice.png"  width="20">Купить: <?php echo $buynametovar; ?> </p>
</div>
</div>
<div class="bluepolosa">
<div class="koplate">
<p>К оплате: <?php echo $buyprice; ?>.00 руб.</p>
</div>
</div>


 
</div>
<div class="payment">
<div class="payment-types">

<div class="payment-types-icons">

<div class="payment-types-icons-row"> 
<div class="payment-types-icons-container">
<i id="payyandmoney" onClick="payform(this.id)" class="active" style="background: url(/images/paysystems/yandex.png) no-repeat;"></i>
<label>
Способ оплаты: Яндекс.Деньги<br />
Комиссия: 6% </label>
</div>
<div class="payment-types-icons-container">
<i id="paybankcart" onClick="payform(this.id)" class="inactive" style="background: url(/images/paysystems/rcc.png) no-repeat;"></i>
<label>
Способ оплаты: Банковская карта<br />
Комиссия: 3,4% </label>
</div>
<div class="payment-types-icons-container">
<i id="payQIWi" onClick="payform(this.id)" class="inactive" style="background: url(/images/paysystems/qiwi.png) no-repeat;" ></i>
<label>
Способ оплаты: QIWI<br />
Комиссия: 5,5% </label>
</div>


</div> <div class="payment-types-icons-row"> <div class="payment-types-icons-container">
<i id="paymobmtc" onClick="payform(this.id)" class="inactive" style="background: url(/images/paysystems/mts.png) no-repeat;"></i>
<label>
Способ оплаты: МТС<br />
Комиссия: 18% </label>
</div>

<div class="payment-types-icons-container">
<i id="paymobbilain" onClick="payform(this.id)" class="inactive" style="background: url(/images/paysystems/bln.png) no-repeat;"></i>
<label>
Способ оплаты: Билайн<br />
Комиссия: 22.5% </label>
</div>
<div class="payment-types-icons-container">
<i id="paymobtele2" onClick="payform(this.id)" class="inactive" style="background: url(/images/paysystems/tl2.png) no-repeat;"></i>
<label>
Способ оплаты: ТЕЛЕ2<br />
Комиссия: 26% </label>
</div>
</div> 

<div class="payment-types-icons-row"> 
<!--
<div class="payment-types-icons-container">
<i id="payinternetbnak" onClick="payform(this.id)" class="inactive" style="background: url(/images/paysystems/bnk.png) no-repeat;" ></i>
<label>
Способ оплаты: Интернет-банкинг<br />
Комиссия: 2,5% </label>
</div> 
<div class="payment-types-icons-container">
<i id="paywebmoneycart" onClick="payform(this.id)" class="inactive" style="background: url(/images/paysystems/ppc.png) no-repeat;" ></i>
<label>
Способ оплаты: Webmoney Card<br />
Без комиссии. </label>
</div>
<div class="payment-types-icons-container">
<i id="paybitcoin" onClick="payform(this.id)" class="inactive" style="background: url(/images/paysystems/btc.png) no-repeat;"  ></i>
<label>
Способ оплаты: Bitcoin<br />
Без комиссии. </label>
</div> 
<div class="payment-types-icons-container">
<i id="payterminal" onClick="payform(this.id)" class="inactive" style="background: url(/images/paysystems/atm.png) no-repeat;" ></i>
<label>
Способ оплаты: Терминал<br />
Комиссия: 2% </label>
</div>--->
</div> <div class="payment-types-icons-row"> 
<!--
<div class="payment-types-icons-container">
<i id="paypochtarus" onClick="payform(this.id)" class="inactive" style="background: url(/images/paysystems/mail.png) no-repeat;" ></i>
<label>
Способ оплаты: Почта России<br />
Комиссия: 2,5% </label>
</div>
<div class="payment-types-icons-container">
<i id="paygiftcart" onClick="payform(this.id)" class="inactive" style="background: url(/images/paysystems/paygift.png) no-repeat;" ></i>
<label>
Способ оплаты: Подарочная карта<br />
Без комиссии. </label>
</div>
<div class="payment-types-icons-container">
<i id="payskinssteam" onClick="payform(this.id)" class="inactive" style="background: url(/images/paysystems/skincash.png) no-repeat;" ></i>
<label>
Способ оплаты: Скины Steam<br />
Без комиссии. </label>
</div> <div class="payment-types-icons-container">
<i class="inactive" data-curr="" data-cmsn="" data-name=""   style="cursor: default"></i>
</div>---->
</div> </div> 


</div>


</div>

<div class="payment-panel-main">
    
  <div class="payment-check">
  <div class="emaildesc">
Внимание! Укажите ваш действующий Е-mail для доставки товара:
</div>
  <form method="GET" name="formbuyw" action="buyw.php">
    <input type="hidden" name="id" value="<?php echo $buyidtovar ;?>">
	<input type="hidden" name="par" value="<?php echo $getpar ;?>">
	<input type="hidden" name="par2" value="<?php echo $getpar2 ;?>0">
    <input type="hidden" id="paymenttype" name="paymenttype" value="paybankcart" >

 	<input type="email" name="emailzakaz"  placeholder="Введите ваш E-mail"  required> 
    <input name="submit" type="submit" value="Продолжить оплату" /> </br></br>
	<input type="checkbox" name="formbuyw" value="1" id="payment-check" checked required />
	
	<label for="payment-check">
Я ознакомлен(а) с <a href="#" target="_blank">пользовательским соглашением</a>,
описанием и региональными ограничениями товара.
</label>
    </form> 
	<div class="emaildesc">
После оплаты посмотреть товар можно в <a href="../cab/mycab.php" target="_blank">МОИ ПОКУПКИ</a>
</div>
<div class="float-error-block" id="agree_error" style="display:none">Требуется подтверждение</div>
</div>  




 
</div>
</div></div>
	
	<body>
	</html>
	<?php
	//  место на php код и закрытие if скобки которая пришла сверху
	
	}	
    ?>