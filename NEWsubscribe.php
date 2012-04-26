<?

	// INITIAL & KERNEL & XSLT
	//$pathKRNL = include(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/pathkrnl.php');	
	$pathKRNL = '_azone/';
	require_once($pathKRNL.'kernel/initial_class.php');
	require_once($pathKRNL.'kernel/db_class.php');
	require_once($pathKRNL.'kernel/client_ex_class.php');
	if (version_compare(PHP_VERSION,'5','>=') && extension_loaded('xsl')) require_once('xslt4php.php');  
	
	$cDB = new cDB();
	$cDB->fDbConnect();
	$xslt = xslt_create();	
	
	$cCountryBonus = $cDB->fGetModule('countrybonus');
	$cBonus = $cCountryBonus->childsClass['regionbonus']->childsClass['citybonus']->childsClass['bonus'];
	echo $domainName = $cBonus->krnl->domainName;
	
	$arData = $arUsers = $arUsersData = $arIns = array();
	
	// Выбор городов по которым вести рассылку
	$cDB->dbQuery = "SELECT DISTINCT ownerId FROM ".$cDB->dbPref."bonus WHERE active=1 AND DATE_FORMAT(edate,'%Y-%m-%d')>='".date('Y-m-d')."' AND DATE_FORMAT(bdate,'%Y-%m-%d')<='".date('Y-m-d')."' ";
	
	set_time_limit(0);
	$update = '';
	
	if ($cDB->fDbExecute())
	{
		$i = 0;
		while ($row2 = $cDB->fDbGetRow())
		{
			$ArrCity[$i] = $row2['ownerId'];
			$i++;
		}
		foreach($ArrCity as $key=>$value)
		{
			$cDB->dbQuery = 'SELECT id, email, password, regtime FROM '.$cDB->dbPref.'users WHERE sending=1 AND active=1 AND cityId="'.$value.'" AND delivery<"'.date('Y-m-d').'" ORDER BY id';
			
			$ArrHash = array();
			
			if ($cDB->fDbExecute())
			{
				while ($row3 = $cDB->fDbGetRow())
				{
					$ArrEmail[$row3['id']] = $row3['email'];
					
					$hash = md5($row3['password'].$row3['regtime']).str_pad($row3['id'], 6, "0", STR_PAD_LEFT);
					$ArrHash[$row3['id']] = $hash;
				}
				
				/* echo '<pre>';
				print_r($ArrHash);
				echo '</pre>'; */
				
				foreach ($ArrHash as $key1=>$value1)
				{
					$authkey = '?authkey='.$value1;
					// Акции в зависимости от города
					$cBonus->queryFields = array('DISTINCT t1.id','t1.name','t3.name as city','t2.percent','t2.eprice','t2.bprice','(@cnt:=(SELECT COUNT(id) FROM '.$cBonus->childsClass['bonusoffer']->tableName.' tcount WHERE tcount.ownerId=t1.id)) as cnt','(@max:=(SELECT MAX(bprice) FROM '.$cBonus->childsClass['bonusoffer']->tableName.' tcount WHERE tcount.ownerId=t1.id)) as max');
					$cBonus->queryTerms = " t1, ".$cBonus->childsClass['bonusoffer']->tableName." t2, ".$cDB->dbPref."city t3 WHERE t1.active=1 AND t2.ownerId=t1.id AND t2.eprice=(SELECT MIN(tmin.eprice) FROM ".$cBonus->childsClass['bonusoffer']->tableName." tmin WHERE tmin.ownerId=t1.id) AND t2.active=1 AND DATE_FORMAT(t1.edate,'%Y-%m-%d')>='".date('Y-m-d')."' AND DATE_FORMAT(t1.bdate,'%Y-%m-%d')<='".date('Y-m-d')."' AND t1.ownerId='".$value."' AND t3.id=t1.ownerId ORDER BY t1.orderIndex DESC LIMIT 0, 20";
					
					if ($cBonus->fList(0))
					{
						$cBonus->fGetFoto();
						$cBonusFoto = &$cBonus->childsClass['bonusfoto'];
						
						$i = 0;
						$BonusesFour = $BonusesSixteen = $BonusesLast = $update = '';
						//$title = str_replace(array('«','»','“','”'),'"',$cBonus->moduleData[0]['name']).' и множество других не менее интересных акций от BonusMouse.ru';
						
						if($cBonus->moduleData[0]['city'] == 'Уфа')
							$title = 'Баня на колесах / Китайский массаж / Обучение в студии танца / Гелевое наращивание ногтей';
						elseif($cBonus->moduleData[0]['city'] == 'Стерлитамак')
							$title = 'Моторные масла / Ночной клуб IKRA / Бамбуковые одеяла, подушки и полотенца / Загар в турбо-солярии';
						else $title = 'Интересные акции от BonusMouse.ru';
						
						foreach($cBonus->moduleData as $row)
						{
							
							$row['name'] = str_replace(array('«','»','“','”'),'"',$row['name']);
							$fotoPath = $cBonusFoto->fGetFile($cBonusFoto->moduleData[$row['id']][0][0],'i_bonus',$cBonusFoto->moduleData[$row['id']][0][1]);
							
							$i++;
							$maxDiscount='';
							if($row['bprice']!=0)
								$maxDiscount = 100-ceil($row['eprice']/$row['bprice']*100);
							
							$htmlHead = '<a href="'.$domainName.$authkey.'" title="BonuseMouse.ru" align="center"><img src="'.$domainName.'image/metro/logo.png" alt="BonusMouse.ru"/></a>';
							$bottomBttn = '<a style="display:block;text-align:left;margin:8px;" href="'.$domainName.$authkey.'"><img src="'.$domainName.'image/metro/prev.png" alt="К списку акций" title="К списку акций"/></a>';
							if($i<=4)
							{
								$BonusesFour .= ' <div style="margin:0 0 8px;border:1px solid #666;"> <table width="100%" cellspacing="0" cellpadding="0" border="0"> <col width="220"/><col width=""/> <tr> <td valign="top" bgcolor="#FFF"> <a href="'.$domainName.'bonus'.$row['id'].'.html'.$authkey.'"><img src="'.$domainName.$cBonus->fPrefixImage($fotoPath,'').'" width="395" height="198"/></a> </td> <td valign="top" align="center" bgcolor="#FFF" style="line-height:100%;"> <a href="'.$domainName.'bonus'.$row['id'].'.html'.$authkey.'" style="text-decoration:none;color:#333;display:block;text-align:center;margin:20px 5px;height:80px;">'.$row['name'].'</a>
								<table width="250" cellspacing="0" cellpadding="2" border="0"> <col width="140"/><col width="100"/> <tr> <td colspan="2" style="font-size:11px;color:#666;"> <br/> '.(($row['percent']=='')?('Цена без скидки: '.(($row['cnt']==1)?'':'до ').' '.$row['max'].' руб.'):'').'</td> </tr>
								<tr> <td style="font-size:14px;line-height:100%;"> '.(($row['cnt']==1)?'':'от&nbsp;').'<span style="font-size:18px;">'.(int)$row['eprice'].'\'</span>'.substr($row['eprice'],strpos($row['eprice'],'.')+1).'&nbsp;руб.</td> <td rowspan="2" align="center"><a href="'.$domainName.'bonus'.$row['id'].'.html'.$authkey.'"><img src="'.$domainName.'image/metro/href.png" alt="подробнее"/></a></td> </tr>
								<tr> <td> <span style="color:#d61000;font-weight:normal;font-size:14px;"> '.(empty($row['percent'])?'Скидка '.(($row['cnt']==1)?'':'до ').$maxDiscount.'%':$row['percent']).' </span> </td> </tr> </table> </td> </tr> </table> </div>';
								// if($i!=4)
									$BonusesFour .= ' ';
							} elseif($i<=16) {
								$result = $i % 4;
								if($result == 1)
								{
									$BonusesSixteen .= ' <tr> <td align="left" valign="top"> <a href="'.$domainName.'bonus'.$row['id'].'.html'.$authkey.'" style="text-decoration:none;font-size:12px;color:#000;display:block;"> <img src="'.$domainName.$cBonus->fPrefixImage($fotoPath,'m_').'" width="158" height="82"/> <br/> '.$row['name'].' <span style="color:#d61000;">'.(empty($row['percent'])?'Скидка '.(($row['cnt']==1)?'':'до ').$maxDiscount.'%':$row['percent']).'</span> </a> </td> <td> </td> ';
								} elseif ($result == 2) {
									$BonusesSixteen .= ' <td align="left" valign="top"> <a href="'.$domainName.'bonus'.$row['id'].'.html'.$authkey.'" style="text-decoration:none;font-size:12px;color:#000;display:block;"> <img src="'.$domainName.$cBonus->fPrefixImage($fotoPath,'m_').'" width="158" height="82"/> <br/> '.$row['name'].' <span style="color:#d61000;">'.(empty($row['percent'])?'Скидка '.(($row['cnt']==1)?'':'до ').$maxDiscount.'%':$row['percent']).'</span> </a> </td> <td> </td> ';
								} elseif ($result == 3) {
									$BonusesSixteen .= ' <td align="left" valign="top"> <a href="'.$domainName.'bonus'.$row['id'].'.html'.$authkey.'" style="text-decoration:none;font-size:12px;color:#000;display:block;"> <img src="'.$domainName.$cBonus->fPrefixImage($fotoPath,'m_').'" width="158" height="82"/> <br/> '.$row['name'].' <span style="color:#d61000;">'.(empty($row['percent'])?'Скидка '.(($row['cnt']==1)?'':'до ').$maxDiscount.'%':$row['percent']).'</span> </a> </td> <td> </td> ';
								} elseif ($result == 0) {
									$BonusesSixteen .= ' <td align="left" valign="top"> <a href="'.$domainName.'bonus'.$row['id'].'.html'.$authkey.'" style="text-decoration:none;font-size:12px;color:#000;display:block;"> <img src="'.$domainName.$cBonus->fPrefixImage($fotoPath,'m_').'" width="158" height="82"/> <br/> '.$row['name'].' <span style="color:#d61000;">'.(empty($row['percent'])?'Скидка '.(($row['cnt']==1)?'':'до ').$maxDiscount.'%':$row['percent']).'</span> </a> </td> </tr> ';
									if($result != 16) $BonusesSixteen .= ' <tr> <td colspan="7"> &nbsp; </td> </tr> ';
								}
							} elseif ($i>16) {
								if ($i == 17)
									$BonusesLast = '<h4 style="margin:10px 0 0 8px;text-align:left;">Еще акции:</h4> <ul style="margin:5px 0 10px;padding:0 0 0 8px;line-height:130%;text-align:left;">';
								$BonusesLast .= '<li style="list-style:none;"><a href="'.$domainName.'bonus'.$row['id'].'.html'.$authkey.'" style="color:#000;font-size:12px;text-decoration:none;line-height:100%;"> '.$row['name'].' <span style="color:#d61000;">'.(empty($row['percent'])?'Скидка '.(($row['cnt']==1)?'':'до ').$maxDiscount.'%':$row['percent']).'</span> </a></li>';
							}
						}
						if($BonusesLast!='')
							$BonusesLast .= '</ul>';
						// echo htmlspecialchars($BonusesSixteen);
					}
					$html = ' <table width="100%" cellspacing="0" cellpadding="5" border="0" style="font:14px Segoe UI,Tahoma,Arial,Verdana,sans-serif;" bgcolor="#FFF"> <tr> <td align="center" valign="middle"> <table width="678" cellspacing="0" cellpadding="0" border="0" bgcolor="#EDF3F5"> <tr> <td align="center" valign="middle" bgcolor="#EDF3F5" height="116"> <table width="662" cellspacing="0" cellpadding="0" bgcolor="#FFF"> <col width="35"/><col width="307"/><col width="285"/><col width="35"/> <tr> <td height="100"></td> <td valign="middle"> <h1 style="color:#333;font-weight:normal;font-size:18px;line-height:100%;">Предложение в городе <strong style="display:block;font-size:28px;line-height:100%;">'.$row['city'].'</strong></h1> </td> <td align="right"> '.$htmlHead.' </td> <td></td> </tr> 
					</table> </td> </tr>
					<tr> <td align="center" valign="top"> <table width="662" cellspacing="0" cellpadding="0" border="0"> <tr> <td valign="top"> '.$BonusesFour.' </td> </tr> </table> <table width="662" cellspacing="0" cellpadding="0" border="0"> <col width="158"/><col width="8"/><col width="158"/><col width="8"/><col width="158"/><col width="8"/><col width="158"/> '.$BonusesSixteen.' </table> '.$BonusesLast.$bottomBttn.' </td> <td> </td> </tr> </table> </td> </tr> <tr> <td height="30"> </td> </tr> </table> </td> </tr> </table>';
					
					if ($cBonus->fSendMail($ArrEmail[$key1],$title,$html))
					set_time_limit(0);
					sleep(1);
					echo '<hr>'.htmlspecialchars($key1);
					echo '<hr>'.$ArrEmail[$key1].$title.$html;
					$cDB->dbQuery = 'UPDATE '.$cDB->dbPref.'users SET delivery="'.date('Y-m-d').'" WHERE id="'.$key1.'";';
					if($cDB->fDbExecute())
						echo $cDB->dbQuery;
				}
			}
		}
	}
	die;

?>