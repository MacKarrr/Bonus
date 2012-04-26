<?
	 if (
		isset($_REQUEST['eshopId']) && $_REQUEST['eshopId']==$cDB->shopId
		&& isset($_REQUEST['orderId']) && (int)$_REQUEST['orderId']
		&& !empty($_REQUEST['serviceName'])
		&& !empty($_REQUEST['eshopAccount'])
		&& isset($_REQUEST['recipientAmount']) && (float)$_REQUEST['recipientAmount']>0
		&& $_REQUEST['recipientCurrency']=='RUR'
		&& isset($_REQUEST['paymentStatus']) && (int)$_REQUEST['paymentStatus']
		&& !empty($_REQUEST['userName'])
		&& !empty($_REQUEST['userEmail'])
		&& !empty($_REQUEST['paymentData'])
		&& !empty($_REQUEST['hash']) 
		&& preg_match('/^[0-9A-Za-z]+$/',$_REQUEST['hash']))
		{
			$hash = md5(
				$cDB->shopId.'::'.
				$_REQUEST['orderId'].'::'.
				$_REQUEST['serviceName'].'::'.
				$_REQUEST['eshopAccount'].'::'.
				$_REQUEST['recipientAmount'].'::'.
				$_REQUEST['recipientCurrency'].'::'.
				$_REQUEST['paymentStatus'].'::'.
				$_REQUEST['userName'].'::'.
				$_REQUEST['userEmail'].'::'.
				$_REQUEST['paymentData'].'::'.
				$cDB->shopKey
				);
		
			if ($_REQUEST['hash']==$hash)
			{
				if ($_REQUEST['paymentStatus']==5) // Платеж зачислен  
				{
					$cUsers = $cDB->fGetModule('users');
					
					if (isset($_REQUEST['serviceName']) && $_REQUEST['serviceName']=='Popolnenie balansa na BonusMouse.ru')
					{				
						$cDB->dbQuery = "SELECT balans, ownerId FROM ".$cDB->dbPref."usersbalans WHERE paid=0 AND id=".(int)$_REQUEST['orderId'];
						if ($cDB->fDbExecute() && $cDB->fDbNumRows())
						{
							$row = $cDB->fDbGetRow();
							
							if ((float)$_REQUEST['recipientAmount'] == $row['balans'])
							{
								$cDB->dbQuery = "UPDATE ".$cDB->dbPref."usersbalans SET paid=1, paydate='".date('Y-m-d H:i:s')."' WHERE id=".(int)$_REQUEST['orderId'];
								if ($cDB->fDbExecute()) 
								{
									$cDB->dbQuery = "UPDATE ".$cDB->dbPref."users SET balans=balans+".$row['balans'].", paydate='".date('Y-m-d H:i:s')."' WHERE id=".$row['ownerId'];
									if ($cDB->fDbExecute()) 
									{
										$ok = '<p>Вы успешно пополнили баланс на '.$cDB->domainName.'<p>При возникновении вопросов по Вашему заказу, обратитесь к <a href="'.$cDB->domainName.'backlink.html">нашим специалистам</a> используя номер Вашей транзакции: <b>#'.(int)$_REQUEST['orderId'].'</b></p> '.$cDB->suffixEmail;
										
										$cUsers->fSendMail($_REQUEST['userEmail'],'Пополнение баланса на '.$cDB->domainName,$ok);
										$xml = '<ok><![CDATA['.$ok.']]></ok>';									
									}
									else $xml = '<er2><![CDATA[Ошибка оплаты №9.'.$cDB->toAdm.']]></er2>';
								}
								else $xml = '<er2><![CDATA[Ошибка оплаты №8.'.$cDB->toAdm.']]></er2>';
							}
							else $xml = '<er2><![CDATA[Ошибка оплаты №7.'.$cDB->toAdm.']]></er2>';
						}
						else $xml = '<er2><![CDATA[Ошибка оплаты №6.'.$cDB->toAdm.']]></er2>';
					}
					else
					{
						$cDB->dbQuery = 'SELECT cost, ownerId FROM '.$cDB->dbPref.'usersoffer WHERE id='.(int)$_REQUEST['orderId'];
						if ($cDB->fDbExecute() && $cDB->fDbNumRows())
						{
							$row = $cDB->fDbGetRow();
							if ((int)$_REQUEST['recipientAmount'] == (int)$row['cost'])
							{
								$cDB->dbQuery = "UPDATE ".$cDB->dbPref."usersoffer SET paid=1, paydate='".$_REQUEST['paymentData']."' WHERE id=".(int)$_REQUEST['orderId'];
								if ($cDB->fDbExecute())
								{
									$ok = '<p>Вы успешно оплатили купон на '.$cDB->domainName.' <p>При возникновении вопросов по Вашему заказу, обратитесь к <a href="'.$cDB->domainName.'backlink.html">нашим специалистам</a> используя номер Вашего купона: <b>#'.(int)$_REQUEST['orderId'].'</b></p> '.$cDB->suffixEmail;
							
									$cUsers->fSendMail($_REQUEST['userEmail'],'Покупка купона на '.$cDB->domainName,$ok);
									$xml = '<ok><![CDATA['.$ok.']]></ok>';
									
									// MANAGE
									$users = $cUsers->fFriendPercent($row['ownerId']);
									
									$ArrX = array();
									$summaProdazh = $row['cost']; //сумма продаж
									$protsentVoznagrazhdeniya = 5;
									$premiyaBlizhaishemu = 20;
									$kolichestvoUchastnikov = 0;
									
									foreach ($users as $key=>$value) if($value != '') $kolichestvoUchastnikov ++;
									
									$sum = $k = 0; 
									if($kolichestvoUchastnikov<11) { $k = 10-$kolichestvoUchastnikov; $kolichestvoUchastnikov=10; }
									for($i=1;$i<$kolichestvoUchastnikov;$i++) $sum+=$i;
									$x=(100-$premiyaBlizhaishemu)/$sum;
									for($j=1;$j<$kolichestvoUchastnikov;$j++) $ArrX[$j]=$j*($x/100)*($protsentVoznagrazhdeniya/100)*$summaProdazh;
									$ArrX[$j]=($premiyaBlizhaishemu/100)*($protsentVoznagrazhdeniya/100)*$summaProdazh;
										
									$baseSumm = 0;
									for($j=$kolichestvoUchastnikov;$j>$k;$j--)
									{
										$baseSumm += number_format($ArrX[$j], 2,'.','');
										// echo 'Премия Участника №'.$j.', id='.$users['id'.$j].' = '.number_format($ArrX[$j], 2,'.','').' ------------------ ('.$baseSumm.')<br/>';
										// $cUsers->fFriendPercentUpdate($users['id'.$j], number_format($ArrX[$j], 2,'.',''));
										$cDB->dbQuery = 'UPDATE '.$cUsers->tableName.' SET `balans`=`balans`+'.number_format($ArrX[$j], 2,'.','').' WHERE id='.$users['id'.$j];
										$cDB->fDbExecute();
									}
									// END MANAG
								}
								else 
									$xml = '<er2><![CDATA[Ошибка оплаты №5.'.$cDB->toAdm.']]></er2>';
							}
							else
								$xml = '<er2><![CDATA[Ошибка оплаты №4.'.$cDB->toAdm.']]></er2>';
						}
						else
							$xml = '<er2><![CDATA[Ошибка оплаты №3.'.$cDB->toAdm.']]></er2>';						
					}
				}
				elseif ($_REQUEST['paymentStatus']==3)
					$xml = '<alert><![CDATA[Ваш платеж принят на обработку.]]></alert>';
				else
					$xml = '<er2><![CDATA[Ошибка оплаты №2.'.$cDB->toAdm.']]></er2>';
			}
			else
				$xml = '<er2><![CDATA[Ошибка оплаты №2.'.$cDB->toAdm.']]></er2>';
		}
		else
			$xml = '<er2><![CDATA[Ошибка оплаты №1.'.$cDB->toAdm.']]></er2>';
	 
	$txt = '';
	foreach($_REQUEST as $k=>$v) $txt .= $k.'=>'.$v.' | ';
	
	$file = $cDB->pathWWW.'rbk/'.date('Y-m-d').'.txt';
	$fl = fopen($file,'a+');
	if (fwrite($fl,date('H:i:s d/m/Y').' - '.$xml.$txt."\n"))
	fclose($fl);
	
	return fXmlTransform($xml,'formblock');
?>