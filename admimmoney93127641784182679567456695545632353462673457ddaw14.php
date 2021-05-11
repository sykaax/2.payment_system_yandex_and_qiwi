<?php
// админка для вывода продаж по дням для кирилла.

require 'db/dbconnect.php';
if(isset($_GET['HAUI31231516789sdaxcFwq4SDqwdhuqiwdq1d01USayqqPOAKmqyzpowigasydiahDASIDFGOASdyuahsdjAUISYGDFyAIGSYDHIAUOSDAIGYUSduyasgdahk197fak196aausdhasdugasdauwdhawdawd842'])){
echo 'ok';

	$query = "SELECT * FROM `tabzakaz` WHERE `datestart` >= '2019-08-31' AND `datestart` <= '2019-09-30' ORDER BY id DESC"; // запрос к базе данных
	$sqlsq = mysqli_query($dbconnect,$query) or die(mysqli_error()); // сам запросс
	
	while ($result = mysqli_fetch_array($sqlsq)) { // цикл вайл который выводит все заказы в таблицу
      
    
        $idrovar2b = $result['sum'];
        $allsum = $allsum + $idrovar2b;
		echo '<br>';
		echo $allsum;
		
		}


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
