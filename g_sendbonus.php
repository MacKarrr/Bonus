<?	
	session_start();
	header('Content-type: text/html; charset=windows-1251');
	
	$pathKRNL = include(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/pathkrnl.php');	
	require_once($pathKRNL.'kernel/initial_class.php');	
	require_once($pathKRNL.'kernel/db_class.php');
	
	$cDB = new cDB();
	$cDB->fDbConnect();		
	
	if (isset($_POST['id']) && (int)$_POST['id'] && $cDB->fCheckAuth())
	{
		$cDB->fDbConnect();	
		require_once($pathKRNL.'kernel/client_ex_class.php');
		$cPage = $cDB->fGetModule('page');
		
		$friendEmail = '';
		
		$cDB->dbQuery = 'SELECT t1.name, t1.ownerId  FROM '.$cDB->dbPref.'bonusoffer t1, '.$cDB->dbPref.'usersoffer t2 WHERE t2.offerId=t1.id AND t2.id='.$_POST['id'];
		if ($cDB->fDbExecute()) list($bonusName, $BonusId) = $cDB->fDbGetRow(MYSQL_NUM);
		
		$emal = '';
		$name = 'Ваш друг';
		$bonusName = str_replace(array('«','»'),'"',$bonusName);
		if ($cDB->userEmail!='') $emal = '('.$cDB->userEmail.')';
		if ($cDB->userName!='') $name = $cDB->userName;
		
		if (isset($_POST['friendId']) && preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $_POST['friendId']))
		{
			$cDB->dbQuery = 'UPDATE '.$cDB->dbPref.'usersoffer SET favourfriend="'.$_POST['friendId'].'" WHERE id="'.$_POST['id'].'"';
			if ($cDB->fDbExecute())
			{
				$friendEmail = $_POST['friendId'];
				$title = $name.' дарит Вам купон на акцию "'.$bonusName.'" на BonusMouse.ru';
				$inner = '<table cellspacing="0" cellpadding="0" border="0" width="100%" style="background:#FFF; color:#474747; font-family:Tahoma, sans-serif;">
	<tr>
		<td align="center" valign="middle">
			<table cellspacing="0" cellpadding="0" border="0" width="700px" style="color:#474747;">
				<tr>
					<td style="text-align:left;padding:55px 80px 0;background:url('.$cDB->domainName.'image/bg-xbn-01.jpg) no-repeat #efcc09;height:69px;min-height:69px;max-height:69px;">
						<a  href="'.$cDB->domainName.'" title="BonuseMouse.ru" style="display:block;height:69px;min-height:69px;max-height:69px;"><img src="'.$cDB->domainName.'image/logo-xbn.png" alt="BonusMouse.ru"/></a>
					</td>
				</tr>
				<tr>
					<td style="background:url('.$cDB->domainName.'image/bg-xbn-02.jpg) no-repeat #efcc09;height:155px;min-height:155px;line-height:155px;padding:0;">&nbsp;</td>
				</tr>
				<tr>
					<td style="background:url('.$cDB->domainName.'image/bg-xbn-05.png) 100% 100% repeat-y #efcc09;padding:0;color:#333;">
						<table width="100%" style="background:url('.$cDB->domainName.'image/bg-xbn-03.jpg) no-repeat;height:402px;font-size:20px;">
							<tr>
								<td align="justify" valign="top" style="padding:0 50px;">
									<h1 align="center" style="font-weight:normal;font-size:32px;">Здравствуйте</h1>
									<p>'.$name.' '.$emal.' дарит Вам купон на специальное предложение "<a href="'.$cDB->domainName.'bonus'.$BonusId.'.html" title="'.$bonusName.'" style="color:#64a5bf;">'.$bonusName.'</a>". Вы можете воспользоваться купоном просто <a href="'.$cDB->domainName.'print'.$_POST['id'].'.html" style="color:#64a5bf;">распечатав</a> его. Если купон отображается некорректно в Вашей почтовой программе или в веб-почте, то предварительно сохраните его на диск и откройте с диска.</p>
									<p>Также Вы можете ознакомиться с другими специальными предложениями на сайте <a href="'.$cDB->domainName.'" style="color:#64a5bf;">www.bonusmouse.ru</a>.</p>
									<p style="width:300px;text-align:left;">С наилучшими пожеланиями, команда <a href="'.$cDB->domainName.'" style="color:#64a5bf;">BonusMouse.ru</a></p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="background:url('.$cDB->domainName.'image/bg-xbn-04.jpg) no-repeat #efcc09;height:19px;padding:0;">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
			}
		}
		elseif (isset($_POST['friendId']) & $_POST['friendId'] == 'SendSelf')
		{
			$title = 'Акция "'.$bonusName.'" от BonusMouse.ru';
			$inner = '<a href="'.$cDB->domainName.'print'.$_POST['id'].'.html">Распечатать</a>';
			$friendEmail = $cDB->userEmail;
		}
		if ($cPage->fSendMail($friendEmail, $title, $inner)
			) echo 1;
		else echo 0;
	}
	else echo 2;
	$cDB->fDbClose();
?>	
