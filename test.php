<?

	$file = $cDB->pathWWW.'rbk.txt';
	$fl = fopen($file,'w');
	fwrite($fl,date('H:i:s d/m/Y'));
	fclose($fl);



	$ArrX = array();
	
	$summaProdazh = 0;
	$protsentVoznagrazhdeniya = 5;
	$premiyaBlizhaishemu = 20;
	$kolichestvoUchastnikov = 10;
	
	if (isset($_POST['summaProdazh'])) $summaProdazh = (int)$_POST['summaProdazh'];
	if (isset($_POST['protsentVoznagrazhdeniya'])) $protsentVoznagrazhdeniya = (int)$_POST['protsentVoznagrazhdeniya'];
	if (isset($_POST['premiyaBlizhaishemu'])) $premiyaBlizhaishemu = (int)$_POST['premiyaBlizhaishemu'];
	if (isset($_POST['kolichestvoUchastnikov'])) $kolichestvoUchastnikov = (int)$_POST['kolichestvoUchastnikov'];

$html = '<form action="test.php" method="post" enctype="multipart/form-data">
<table border="0" cellpadding="0" cellspacing="5" width="600">
	<tr><td>
	Сумма продаж:
	</td><td align="left" width="300">
		<input name="summaProdazh" type="text" value="'.$summaProdazh.'"> руб.
	</td></tr>
	<tr><td>
	Процент вознаграждения:
	</td><td align="left">
		<input name="protsentVoznagrazhdeniya" type="text" value="'.$protsentVoznagrazhdeniya.'"> %
	</td></tr>
	<tr><td>
	Премия ближайшему к покупателю:
	</td><td align="left">
		<input name="premiyaBlizhaishemu" type="text" value="'.$premiyaBlizhaishemu.'"> %
	</td></tr>
	<tr><td>
	Количество участников в цепочке:
	</td><td align="left">
		<input name="kolichestvoUchastnikov" type="text" value="'.$kolichestvoUchastnikov.'">
	</td></tr>
	<tr><td align="center" colspan="2">
		<br/>
		<input type="submit" name="handle" value="Обработать" style="width:100px;">
		<br/>
	</td></tr>
	<tr><td valign="top" colspan="2"></td></tr>
</table>
</form><hr/>';



if(isset($_POST['handle']) && $_POST['handle']=="Обработать")
{
	$sum = 0;	
	$k = 0; 
	if($kolichestvoUchastnikov < 11) { $k = 10 - $kolichestvoUchastnikov; $kolichestvoUchastnikov = 10; }
	
	for($i=1;$i<$kolichestvoUchastnikov;$i++) $sum += $i;
	
	$x = (100-$premiyaBlizhaishemu)/$sum;
	
	for($j=1;$j<$kolichestvoUchastnikov;$j++) $ArrX[$j] = $j*($x/100)*($protsentVoznagrazhdeniya/100)*$summaProdazh;
	$ArrX[$j]= ($premiyaBlizhaishemu/100)*($protsentVoznagrazhdeniya/100)*$summaProdazh;
}

echo $html;
$baseSumm = 0;
for($j=$kolichestvoUchastnikov;$j>$k;$j--)
{
	$baseSumm += number_format($ArrX[$j], 2,'.','');
	echo 'Премия Участника №'.$j.' = '.number_format($ArrX[$j], 2,'.','').' ------------------ ('.$baseSumm.')<br/>';
}
 
echo '<br> Премия как '.$summaProdazh.'*'.$protsentVoznagrazhdeniya.'% = '.($summaProdazh*$protsentVoznagrazhdeniya/100);

 
?>