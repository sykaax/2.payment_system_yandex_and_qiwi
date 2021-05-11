<?php 
// Данный файл собрал в себе множество функций который требуются на постоянной основе
// а также глобальные перменные для нужд скриптов
$linkmyglobalhttp = 'http://payment.comx/'; // переменные
$linkmyglobal = 'payment.comx';
$linkmycabglobal = 'http://payment.comx/mycab.php';
$linkmyglobalhttpcab = 'http://payment.comx/cab';
$linkmyglobalhttpadmin = 'http://payment.comx/admin';
function funcformatstrnum($str) // функция удаления фредоностоного кода и оставлений только цифр
    {
		$str = preg_replace('![^0-9]+!', '', $str);
        $str = trim($str);
        $str = stripslashes($str);
        $str = htmlspecialchars($str);
        return $str;
    }
	
function funcformatstremail($str) // функция удаления фредоностоного кода и оставлений букв вроде как XD вроде ну должны
// удалятся собаки и т д. делалась для email но используется и в другой части кода на buyw.php например
    {
        $str = trim($str);
        $str = stripslashes($str);
        $str = htmlspecialchars($str);
        return $str;
    }


?>