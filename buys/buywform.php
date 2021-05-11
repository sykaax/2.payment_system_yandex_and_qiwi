<?php 
// в данном фале хранятся формы HTML для оплаты яндекс деньги, киви, вебмани
// скрипт js отвечает за выбор формы изходя из платежного способа, функция активируется кнопкой на страницу buyw.php
?>

<html>
<script type="text/javascript">

function submitfunc() {
    document.forms['<?php echo $butformpaymenttype ?>'].submit();
	}

</script>
<form method="POST" target="_blank" name="paybankcart" action="https://money.yandex.ru/quickpay/confirm.xml">
    <input type="hidden" name="receiver" value="410016347247012">
    <input type="hidden" name="quickpay-form" value="shop">
	<input type="hidden" name="targets" value="Оплата заказа №<?php echo $butformidzakaza;?> на сайте <?php echo $linkmyglobalhttp; ?>">
	<input type="hidden" name="sum" value="<?php echo $butformsum; ?>" data-type="number">
	<input type="hidden" name="paymentType" value="AC">
	<input type="hidden" name="label" value="<?php echo $butformidzakaza; // Тут идзаказа который потом будет передан обработчику?>"> 
    <input type="hidden" name="successURL" value="<?php echo $linkmyglobalhttp; ?>buys/buyw.php">
</form>
<form method="POST" target="_blank" name="payyandmoney" action="https://money.yandex.ru/quickpay/confirm.xml">
    <input type="hidden" name="receiver" value="410016347247012">
    <input type="hidden" name="quickpay-form" value="shop">
	<input type="hidden" name="targets" value="Оплата заказа №<?php echo $butformidzakaza;?> на сайте <?php echo $linkmyglobalhttp; ?>">
	<input type="hidden" name="sum" value="<?php echo $butformsum; ?>" data-type="number">
	<input type="hidden" name="paymentType" value="PC">
	<input type="hidden" name="label" value="<?php echo $butformidzakaza; // Тут идзаказа который потом будет передан обработчику?>"> 
    <input type="hidden" name="successURL" value="<?php echo $linkmyglobalhttp; ?>buys/buyw.php">
</form>
<form method="POST" target="_blank" name="paymobmtc" action="https://money.yandex.ru/quickpay/confirm.xml">
    <input type="hidden" name="receiver" value="410016347247012">
    <input type="hidden" name="quickpay-form" value="shop">
	<input type="hidden" name="targets" value="Оплата заказа №<?php echo $butformidzakaza;?> на сайте <?php echo $linkmyglobalhttp; ?>">
	<input type="hidden" name="sum" value="<?php echo $butformsum; ?>" data-type="number">
	<input type="hidden" name="paymentType" value="MC">
	<input type="hidden" name="label" value="<?php echo $butformidzakaza; // Тут идзаказа который потом будет передан обработчику?>"> 
    <input type="hidden" name="successURL" value="<?php echo $linkmyglobalhttp; ?>buys/buyw.php">
</form>
<form method="POST" target="_blank" name="paymobmegafon" action="https://money.yandex.ru/quickpay/confirm.xml">
    <input type="hidden" name="receiver" value="410016347247012">
    <input type="hidden" name="quickpay-form" value="shop">
	<input type="hidden" name="targets" value="Оплата заказа №<?php echo $butformidzakaza;?> на сайте <?php echo $linkmyglobalhttp; ?>">
	<input type="hidden" name="sum" value="<?php echo $butformsum; ?>" data-type="number">
	<input type="hidden" name="paymentType" value="MC">
	<input type="hidden" name="label" value="<?php echo $butformidzakaza; // Тут идзаказа который потом будет передан обработчику?>"> 
    <input type="hidden" name="successURL" value="<?php echo $linkmyglobalhttp; ?>buys/buyw.php">
</form>
<form method="POST" target="_blank" name="paymobbilain" action="https://money.yandex.ru/quickpay/confirm.xml">
    <input type="hidden" name="receiver" value="410016347247012">
    <input type="hidden" name="quickpay-form" value="shop">
	<input type="hidden" name="targets" value="Оплата заказа №<?php echo $butformidzakaza;?> на сайте <?php echo $linkmyglobalhttp; ?>">
	<input type="hidden" name="sum" value="<?php echo $butformsum; ?>" data-type="number">
	<input type="hidden" name="paymentType" value="MC">
	<input type="hidden" name="label" value="<?php echo $butformidzakaza; // Тут идзаказа который потом будет передан обработчику?>"> 
    <input type="hidden" name="successURL" value="<?php echo $linkmyglobalhttp; ?>buys/buyw.php">
</form>
<form method="POST" target="_blank" name="paymobtele2" action="https://money.yandex.ru/quickpay/confirm.xml">
    <input type="hidden" name="receiver" value="410016347247012">
    <input type="hidden" name="quickpay-form" value="shop">
	<input type="hidden" name="targets" value="Оплата заказа №<?php echo $butformidzakaza;?> на сайте <?php echo $linkmyglobalhttp; ?>">
	<input type="hidden" name="sum" value="<?php echo $butformsum; ?>" data-type="number">
	<input type="hidden" name="paymentType" value="MC">
	<input type="hidden" name="label" value="<?php echo $butformidzakaza; // Тут идзаказа который потом будет передан обработчику?>"> 
    <input type="hidden" name="successURL" value="<?php echo $linkmyglobalhttp; ?>buys/buyw.php">
</form>

<form method="GET" target="_blank" name="payQIWi" action="https://qiwi.com/payment/form/99">
  <input type="hidden" name="extra[‘account’]" value="79268750228">
  <input type="hidden" name="amountInteger" value="<?php echo $butformsum; ?>">
  <input type="hidden" name="amountFraction" value="00">
  <input type="hidden" name="extra[‘comment’]" value="Zakaz [<?php echo $butformidzakaza;?>]">
  <input type="hidden" name="currency" value="643">
  <input type="hidden" name="blocked[0]" value="comment">
  <input type="hidden" name="blocked[1]" value="sum">
  <input type="hidden" name="blocked[2]" value="account">
</form>

</html>

