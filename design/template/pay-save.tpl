<!doctype html public "-//w3c//dtd html 4.0 transitional//en"> 
<html> 
	<head>
		<meta http-equiv="content-type" content="text/html; charset=windows-1251"/> 
		<title></title> 
		<style type="text/css"> body {font-family:arial;} </style> 
		<body{$tpl['print']}> 
		<h1>Заказ № {$tpl['orderId']} от {$tpl['orderDate']} г.</h1> <br>
		<p><font size="2"><strong>ФИО:</strong> {$tpl['orderFace']}</font></p>
		<p><font size="2"><strong>Телефон:</strong> {$tpl['orderPhone']}</font></p>
		<p><font size="2"><strong>Email:</strong> {$tpl['orderEmail']}</font></p>
		<p><font size="2"><strong>Компания:</strong> {$tpl['orderCompany']}</font></p>
		<p><font size="2"><strong>Адрес:</strong> {$tpl['orderAddress']}</font></p>		
		
		<p align="center"><strong><font size="2">Перечень заказываемых товаров</font></strong></p>	 
		{$tpl['orderText']}
		<p><font size="2"><strong>Условия доставки:</strong> {$tpl['orderDelivery']}</font></p>
		<p><font size="2">{$tpl['orderDescr']}</font></p>
		<p><font size="2">Cайт заказа - <b>{$tpl['domainName']}</b></font></p>
	</body> 
</html>