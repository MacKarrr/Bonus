<?
	if (!isset($cBackLink)) { include_once($cDB->pathMDL.'backlink_class.php'); $cBackLink = new cBackLink($cDB, $null); }
	$email = $cPage->config['email'];
	if (isset($_POST) && isset($_POST['send']) && $_POST['send']=='Отправить') $data = $cBackLink->fStripSlashes($_POST); elseif(isset($_SESSION['goOrder'])) $data = $_SESSION['goOrder'];
	if (!isset($data['name'])) $data['name'] = '';
	if (!isset($data['email'])) $data['email'] = '';    
	if (!isset($data['phone'])) $data['phone'] = ''; 
	if (!isset($data['txt'])) $data['txt'] = '';

	$cBackLink->form = array();
	$cBackLink->form['_*features*_'] = array('name'=>'send','action'=>$cDB->domainName.'backlink.html#form');
	$cBackLink->form['i1'] = array('type'=>'info','value'=>'Отправка письма для <strong>'.$cPage->config['sitename'].'</strong>');
	$cBackLink->form['name'] = array('claim'=>1,'type'=>'text','caption'=>'Ваше имя','value'=>$data['name'],'mask'=>array('name'=>'text','max'=>127));
	$cBackLink->form['email'] = array('claim'=>1,'type'=>'text','caption'=>'Email','value'=>$data['email'],'mask'=>array('name'=>'email'));
	$cBackLink->form['phone'] = array('type'=>'text','caption'=>'Телефон','value'=>$data['phone'],'mask'=>array('name'=>'phone'));
	$cBackLink->form['txt'] = array('claim'=>1,'type'=>'textarea','rows'=>7,'caption'=>'Текст письма','value'=>$data['txt'],'mask'=>array('name'=>'textarea','max'=>512));
	$cBackLink->form['secret_code'] = array('claim'=>1,'type'=>'secret','caption'=>'Введите код:','mask'=>array('name'=>'secret','code'=>$_SESSION['secret_code']));    
	$cBackLink->form['send'] = array('type'=>'submit','value'=>'Отправить');  
	// ----------------

	if (count($_POST) && $email!='')
	{
		$Arr = $cBackLink->fFormCheck($data);
		if(trim($Arr[0])=='')
		{

		$txt = '<p>Cо страницы  обратной связи (<a href=\''.$cDB->domainName.'backlink.html\'>'.$cDB->domainName.'backlink.html</a>) отправлено письмо для Администрации сайта.</p> <p><b>Контактные данные отправителя</b></p><blockquote>Имя : '.$data['name']./* '<br>Организация : '.$data['org']. */'<br>E-mail : '.$data['email'].'<br>Телефон : '.$data['phone'].'<br> </blockquote><p><b>Текст письма</b></p><blockquote>'.$data['txt'].'</blockquote>';
		$ttl = 'Вам письмо с '.$cDB->domainName;        
			if($cBackLink->fSendMail($email,$ttl,$txt)) $xml = '<ok><![CDATA[Спасибо! Ваше письмо для <strong>'.$cPage->config['sitename'].'</strong> успешно отправлено. <a href="'.$cDB->domainName.'backlink.html">Отправить еще одно письмо.</a>]]></ok>';
			else $xml = '<er2><![CDATA[Ошибка отправки письма. Попробуте повторить попытку.<br> В случае, если вы не можете решить проблему самостоятельно – <a href="mailto:'.$email.'">напишите о ней нам на "'.$email.'"</a>.]]></er2>';
		}
		else $xml = $cBackLink->fForm2xml();
	}
	elseif ($email!='') $xml = $cBackLink->fForm2xml();
	else $xml = '<er2>Ошибка передачи данных</er2>';
	$_SESSION['secret_code'] = rand(10000,99999);
	return fXmlTransform($xml,'formblock');
?>