<?php
// админка для вывода продаж по дням для кирилла.

require 'db/dbconnect.php';
if(isset($_GET['HAUISDqwdhuqiwdq1d01USayqqPOAKmqyzpowigasydiahDASIDFGOASdyuahsdjAUISYGDFyAIGSYDHIAUOSDAIGYUSduyasgdahk197fak196aausdhasdugasdauwdhawdawd842'])){
echo ' <link rel="stylesheet" href="../css/style.css" />
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
        <tbody>
        <tr>
        <td>Номер счёта</td>
        <td>Назваение игры </td>
        <td>Цена </td>
         <td>Вывод денег доступен через </td>
        <td>Дата </td>
        </tr>
';
echo 'ok';


	$query = "SELECT * FROM `tabzakaz` WHERE `oplata` = '1' ORDER BY id DESC"; // запрос к базе данных
	$sqlsq = mysqli_query($dbconnect,$query) or die(mysqli_error()); // сам запросс
	while ($result = mysqli_fetch_array($sqlsq)) { // цикл вайл который выводит все заказы в таблицу
         if($result['paymenttype'] === 'payQIWi'){
        $resultpaymenttype = 'Оплачено с помощью QIWI';
    }
    else{
    $resultpaymenttype = 'Оплачено с помощью YandexMoney';
    }
        $idrovar2b = $result['idtovarbuy'];
        $query2 = "SELECT * FROM `tabtovars` WHERE `idtovar` = '$idrovar2b'"; // запрос к базе данных
	$sqlsq2 = mysqli_query($dbconnect,$query2) or die(mysqli_error());
        $result2 = mysqli_fetch_array($sqlsq2);
		echo '
<tr>
<td>' . "
Счет оплаты ". $result['id'] ."</td>
<td>".$result2['nametovar'] ."</td>
<td>".$result['sum'] .".00 руб.</td>
<td>".$resultpaymenttype ."</td>
<td>".$result['datestart'] ."</td>
</tr>
";}


}

else{
echo 'Digital Оса
Есть
В Digital Лесу

Digital Оса
Есть
В Digital Лесу
(Wow!)

Digital Оса
Есть
В Digital Лесу
(Wow!)

Что ты мелешь
Братик?
(Ау)

Что ты мелешь?
Что ты мелешь?

Что ты мелешь братик?
Что ты мелешь?
Что ты мелешь?
(Йоу!)

Что ты мелешь
Братик?
Что ты мелешь?
Мелешь!?
(Йоу!(Йоу!))

Что ты мелешь
Братик?
Что ты мелешь?
ЧТО ТЫ МЕЛЕШЬ!?
(Вау!)

Digital Оса
Есть
В Digital Лесу
(Wow!)

Digital Оса
Есть
В Digital Лесу
(Wow!)

Digital Оса
Есть
В Digital Лесу
(Wow!)

Digital Оса
Есть
В Digital Лесу
(Wow!)

D1g1t@l...

[Почему не пчела?]

Я летаю
Где хочу
Я ведь
Digital Оса

Я летаю
Я летаю!
Я летаю
В Digital Лесаh

Digital Osa
В Digital Лесах!

Я летаю
Я летаю!
Я ведь
Digital Оса

Я летаю
Я летаю!
Я летаю
Где хочу!

Я ведь
Digital Оса
Я из
Digital Лесов
(Ауа!)

[Вжух вжух]
(Я из Digital Лесов!)
(Ага!)

(Я из Digital Лесов..)

{c00L Dr0p}

{Какой-то SFX}

Не поймать
Тебе Осу

Не поймать
Тебе
Осу!

Я!
Digital
Оса

Я летаю
Где хочу!

(Я летаю где хочу [Cause Im Digital])
(Я летаю где хочу [Cause Im Digital])

Я из
Digital LesoB

Я летаю
Где хоchu

(Я из Digital Lesov)
(Я летаю где хочу)

{Шо-то про qu@l1ty b@55 h3r3}

Digital Оса
Не боится
Слона

Digital Оса
Не боится
Слона...

Digital Оса
Не боится
Слона

Digital Оса...

{Блин рип жизнь бтв}

Я из
Digital Лесов

Я летаю
Где хочу!

(Я из Digital Lesov)
(Я летаю где хочу)

Не поймать
Тебе меня
Я невидим
Для тебя

(Не поймать тебе меня)
(Я невидим для тебя!)

Я из
Digital Лесов

Я из
Digital Лесов...';
}

?>
