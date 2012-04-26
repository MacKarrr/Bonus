<?
	session_start();
	setlocale(LC_ALL, 'ru_RU.CP1251');
	
	// INITIAL & KERNEL & XSLT
	$pathKRNL = include(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/pathkrnl.php');	
	require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/kernel/initial_class.php');
	require_once($pathKRNL.'kernel/db_class.php');
	require_once($pathKRNL.'kernel/client_ex_class.php');
	$cDB = new cDB();
	
	if (strpos($_SERVER['HTTP_HOST'],'www.')!==false 
		|| strpos($_SERVER['REQUEST_URI'],'index.html')!==false
		|| strpos($_SERVER['REQUEST_URI'],'index.php')!==false
		|| strpos($_SERVER['REQUEST_URI'],'index.php?')!==false)
	{
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: '.$cDB->domainName);
		exit(); 
	}
	elseif (isset($_REQUEST['bonusId']) && (int)$_REQUEST['bonusId'])
	{
		$cDB->fDbConnect();
		$cCountryBonus = $cDB->fGetModule('countrybonus');
		$cBonus = &$cCountryBonus->childsClass['regionbonus']->childsClass['citybonus']->childsClass['bonus'];
		$cBonus->krnl->dbQuery = 'SELECT t1.id FROM '.$cBonus->tableName.' t1, '.$cBonus->krnl->dbPref.'bonusoffer t2 WHERE t1.active=1 AND t2.ownerId=t1.id AND t2.active=1 AND t1.id='.$_REQUEST['bonusId'];
		if ($cBonus->krnl->fDbExecute())
		{
			if(!$cBonus->krnl->fDbGetRow())
			{
				header('HTTP/1.1 301 Moved Permanently');
				header('Location: '.$cDB->domainName);
				exit();
			}
		}
	}
	
	// блаблабла
	
	header("Cache-Control: max-age=0, must-revalidate" );
	header("Last-Modified: ".gmdate("D, d M Y H:i:s", time()-1)." GMT");
	header("Expires: ".gmdate("D, d M Y H:i:s", time()-1)." GMT");
	header("Content-type:text/html");
	
	if (version_compare(PHP_VERSION,'5','>=') && extension_loaded('xsl')) require_once('xslt4php.php');  
 	
	$cDB->fDbConnect();
	$xslt = xslt_create();
	
	function fXmlTransform($xml,$xsl='text',$full=1)
	{
		global $xslt,$cDB;
		if ($full) $xml = '<items> <domainName>'.$cDB->domainName.'</domainName> <auth>'.$cDB->fCheckAuth().'</auth> <fauth>'.$cDB->fCheckAuthPartner().'</fauth> '.$xml.'</items>';
		$arguments = array('/_xml' => '<?xml version="1.0" encoding="windows-1251"?><!DOCTYPE fragment [<!ENTITY nbsp "&#160;">]> '.$xml,'/_xsl' => implode("", file($cDB->pathXSL.$xsl.".xsl")));
		$result = xslt_process($xslt, 'arg:/_xml', 'arg:/_xsl', NULL, $arguments);
		if (!$result) 
		{
			// "Error in Template $transform E:".xslt_error($xslt);
			$f = fopen($cDB->pathWWW."m_page/xsl", "w"); fwrite($f, $xml); fclose($f);
		}	
		return $result;
	}
	
	$tpl = array();	
	$tpl['title'] = $tpl['keywords'] = $tpl['description'] = $tpl['path'] = $tpl['text'] = ''; 	 
	$cPage = $cDB->fGetModule('page');
	
	if (!empty($cPage->config['email'])) $cDB->email = $cPage->config['email'];
	if (!empty($cPage->config['sufemail'])) $cDB->suffixEmail = $cPage->config['sufemail'];
	$cDB->pageKeywords = $cPage->config['keywords'];
	$cDB->pageDescription = $cPage->config['description'];
	
	// USER AUTH FROM MAIL
	if (isset($_REQUEST['authkey']) && strlen($_REQUEST['authkey']) == 38)
	{
		$cUsers = $cDB->fGetModule('users');
		$authId = (int)substr($_REQUEST['authkey'], 32);
		$authHash = substr($_REQUEST['authkey'], 0, 32);
		$cUsers->fAuthFromMail($authId, $authHash);
	}
	
	// USER OFF
	if (isset($_REQUEST['off']) && $_REQUEST['off']==1) 
	{
		unset($_SESSION['User']);
		setcookie ('bmu','', time()-3600);
		setcookie ('nsh','', time()-3600);
		setcookie ('lsw','', time()-3600);
		 
		unset($_SESSION['Partner']);
		setcookie ('bmp','', time()-3600);
		setcookie ('nsp','', time()-3600);
		setcookie ('nsp2','', time()-3600);
		
		setcookie ('VK_Name','',time()-3600);
		setcookie ('VK_LastName','',time()-3600);
		setcookie ('VK_Sex','',time()-3600);
		setcookie ('VK_BDate','',time()-3600);
		setcookie ('VK_City','',time()-3600);
		setcookie ('VK_HasMobile','',time()-3600);
		
		$_REQUEST['page'] = 'bonus';
	}

	
	
	// USER BLOCK
	$tpl['reg'] = '';
	
	if(!isset($cUsers))
		$cUsers = $cDB->fGetModule('users');
	if (empty($_REQUEST['page']) || ($_REQUEST['page']=='pay' && empty($_REQUEST['offerId']))) $_REQUEST['page'] = 'bonus';
	if ($_REQUEST['page']!='activation') 
	{
		list($userBlock,$error) = $cUsers->fUserBlock();
		$tpl['user'] = $userBlock;
		
		if (!$cDB->fCheckAuth() && (in_array($_REQUEST['page'],array('my','pay','print')) || ($_REQUEST['page']=='reg' && !empty($_REQUEST['userId'])))) 
		{
			if ($_REQUEST['page']=='reg' && !empty($_REQUEST['userId'])) $_SESSION['userId'] = $_REQUEST['userId'];
			
			$_REQUEST['page'] = 'bonus'; 
			$error = 'error';			
		}
		if ($error!='') $tpl['reg'] = '<script type="text/javascript"> jQuery(function(){ fShowAuth(); }); </script> ';
	}
	
	$cCountryBonus = $cDB->fGetModule('countrybonus');
	$cCity = &$cCountryBonus->childsClass['regionbonus']->childsClass['citybonus'];
	
	// CREATE CONTENT
	if ($cPage->fInitialPage())
	{
		$tpl['text'] = $cPage->pageText;
		if (!empty($cPage->pageInc) && file_exists($cDB->pathINC.$cPage->pageInc.'_inc.php')) $tpl['text'] = include($cDB->pathINC.$cPage->pageInc.'_inc.php');

		if (!empty($cDB->pageH1)) { array_pop($cPage->pagePath); $cPage->pagePath[] = $cDB->pageH1; }				
		if (empty($cDB->pageTitle)) $tpl['title'] = implode(' - ',array_reverse($cPage->pagePath)).' - '.$cPage->config['sitename'];
		else $tpl['title'] = $cDB->pageTitle;
		$tpl['keywords'] = $cDB->pageKeywords;
		$tpl['description'] = $cDB->pageDescription;				
		$tpl['path'] = fXmlTransform($cPage->fPathXML(),'path');
	}
	
	if (trim(strip_tags($tpl['text'],'<img>'))=='')
	{
		if ($cPage->id) $tpl['text'] = '<div class="alert">По данному разделу информация находится на стадии наполнения.</div>';
		else $cDB->page404 = 1;
	}
	

	
	if (isset($cDB->page404) && $cDB->page404) $tpl = array_merge($tpl,$cPage->fPageNotFound());

	$xmlMenu = $cPage->fMenuXml();
	$tpl['menu'] = fXmlTransform($xmlMenu,'menu');
	
	$arIndexModule = array('counter','offer');
	
	foreach($arIndexModule as $k=>$module)
	{
		$class = 'c'.ucfirst($module);
		if (!isset($$class)) $$class = $cDB->fGetModule($module);
		if ($$class) $tpl['i'.$module] = fXmlTransform($$class->fDisplayIndex(),'i'.$module);
	}
	
	$tpl['phone'] = '<strong>'.$cPage->config['phone'].'</strong>';
	$tpl['sitename'] = $cPage->config['sitename'];
	$tpl['sitedescr'] = $cPage->config['sitedescr'];
	$tpl['copyright'] = $cPage->config['copyright'];
	$tpl['description'] = $cPage->config['description'];
	$tpl['domainName'] = $cDB->domainName;
	$tpl['yandexmap'] = '';
	if($cPage->config['yandexmap'] != '')
		$tpl['yandexmap'] = '<script src="http://api-maps.yandex.ru/1.1/index.xml?key='.$cPage->config['yandexmap'].'" type="text/javascript"></script>';
	
	/* ie6-7 */
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !==false && substr($_SERVER['HTTP_USER_AGENT'],strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')+5,1) < 8) 
		$tpl['ie6'] = '<div class="ie6"> Вы используете устаревший браузер. <br/> Для корректной работы и отображения сайта, загрузите и установите один из этих браузеров: <div> <a href="http://www.google.com/chrome/" target="_blank" class="chrome">Google Chrome</a><a href="http://www.opera.com/" target="_blank"  class="opera">Opera</a><a href="http://www.mozilla-europe.org/" target="_blank"  class="firefox">Mozilla Firefox</a><a href="http://www.apple.com/safari/" target="_blank" class="safari">Safari</a> </div> </div>';
	else $tpl['ie6'] = '';		

	// BOTTOM
	
	if ($_REQUEST['page']=='activation' || $_REQUEST['page']=='reg')
	{
		list($userBlock,$error) = $cUsers->fUserBlock();
		$tpl['user'] = $userBlock;
		if ($error!='') $tpl['reg'] = '<script type="text/javascript"> jQuery(function(){ fShowAuth(); }); </script> ';
	}
	$tpl['city'] = fXmlTransform($cCity->fDisplayList(),'city'); 
	
	$cBann = $cDB->fGetModule('bann');
	$bannXml = $cBann->fDisplay($cPage->id);
	$tpl['bann'] = fXmlTransform($bannXml,'bann');
	$tpl['bann2'] = fXmlTransform($bannXml,'bann2');
	$tpl['bann3'] = fXmlTransform($bannXml,'bann3');
	$tpl['bann4'] = fXmlTransform($bannXml,'bann4');
	$tpl['bann5'] = fXmlTransform($bannXml,'bann5');
	$tpl['bann6'] = fXmlTransform($bannXml,'bann6');
	$tpl['bann7'] = fXmlTransform($bannXml,'bann7');
	$tpl['bann8'] = fXmlTransform($bannXml,'bann8');
	$tpl['bann9'] = fXmlTransform($bannXml,'bann9');
	$tpl['bann10'] = fXmlTransform($bannXml,'bann10');
	
	$tpl['bannTop'] = '<ul class="bannslider top">'.$tpl['bann'].$tpl['bann2'].$tpl['bann3'].$tpl['bann4'].$tpl['bann5'].'<div class="clear"></div></ul>';
	if (isset($_REQUEST['bonusId']) && (int)$_REQUEST['bonusId'])
		$tpl['bannTop'] = '';
	$tpl['bannBot'] = '<ul class="bannslider bottom">'.$tpl['bann6'].$tpl['bann7'].$tpl['bann8'].$tpl['bann9'].$tpl['bann10'].'<div class="clear"></div></ul>';
	
	$menu2 = fXmlTransform($xmlMenu,'menu2');
	$social = '<div class="social"> <a title="Twitter" href="https://twitter.com/#!/BonusMous" class="twitter" target="blank"></a> <a title="Facebook" href="http://www.facebook.com/profile.php?id=100003256087823" class="facebook" target="blank"></a> <!-- <a title="RSS акций" href="http://feeds.feedburner.com/bonusmouse" class="rss" target="blank"></a> --> <a title="ВКонтакте" href="http://vkontakte.ru/club32916342" class="vk" target="blank"></a> </div>';
	$srch = '<div class="srch"> <span>Быстрый поиск акций</span> <form id="srch" method="get" action="srch.html"> <input type="text" onclick="this.value=\'\'" value="" name="srch"/> <div class="go" onClick="$(\'#srch\').submit();"></div> </form> </div>';
	
	/* if ($cDB->fCheckAuth()) $tpl['bottom'] = '<div class="cntr">'.$menu2.'<div class="inf">'.$social.'</div> <div class="clear"></div> </div>';
	else $tpl['bottom'] = '<div class="cntr"> <div class="block1 left"><a href="'.$cDB->domainName.'oferta.html" class="p1"> <span>Публичная Оферта</span> на приобретение Товаров и Услуг </a> <a href="'.$cDB->domainName.'partners.html" class="p2"> <span>Партнерам</span> разместите себя на BonusMouse </a> </div>'.$menu2.$social.' <div class="clear"></div> </div>'; */
	$tpl['bottom'] = '<div class="cntr"> <div class="block1 left"><a href="'.$cDB->domainName.'docs.html" class="p1"> <span>Публичная Оферта</span> на приобретение Товаров и Услуг </a> <a href="'.$cDB->domainName.'partners.html" class="p2"> <span>Партнерам</span> разместите себя на BonusMouse </a> </div>'.$menu2.$social.' <div class="clear"></div> </div>';
	
	//echo $cPage->pageH1;
	
	if (!in_array($_REQUEST['page'],array('bonus','my','partnerpage', 'pay', 'xml')))
		$tpl['text'] = '<div class="text"><div class="path"><h1>'.(empty($cDB->pageH1)?$cPage->name:$cDB->pageH1).'</h1></div>'.$tpl['text'].'</div>';
	
	
	// END  BLOCK
	$html = file_get_contents($cPage->pagePathTpl);
	$html = str_replace('"', '\"', $html);
	eval('$html = "'.$html.'";');
	echo $html;

	// CLOSE KERNEL & XSLT
	xslt_free($xslt);
	$cDB->fDbClose();
	
	function fUtf8ToWin1251($str) 
	{
		$chars = array( 
		/* upper case letters */ 
		'208144' => chr(192), '208145' => chr(193), '208146' => chr(194), '208147' => chr(195), '208148' => chr(196), 
		'208149' => chr(197), '208129' => chr(168), '208150' => chr(198), '208151' => chr(199), '208152' => chr(200), 
		'208153' => chr(201), '208154' => chr(202), '208155' => chr(203), '208156' => chr(204), '208157' => chr(205), 
		'208158' => chr(206), '208159' => chr(207), '208160' => chr(208), '208161' => chr(209), '208162' => chr(210), 
		'208163' => chr(211), '208164' => chr(212), '208165' => chr(213), '208166' => chr(214), '208167' => chr(215), 
		'208168' => chr(216), '208169' => chr(217), '208170' => chr(218), '208171' => chr(219), '208172' => chr(220), 
		'208173' => chr(221), '208174' => chr(222), '208175' => chr(223),
		/* lower case letters */ '208176' => chr(224), '208177' => chr(225), '208178' => chr(226), '208179' => chr(227), 
		'208180' => chr(228), '208181' => chr(229), '209145' => chr(184), '208182' => chr(230), '208183' => chr(231), 
		'208184' => chr(232), '208185' => chr(233), '208186' => chr(234), '208187' => chr(235), '208188' => chr(236), 
		'208189' => chr(237), '208190' => chr(238), '208191' => chr(239), '209128' => chr(240), '209129' => chr(241), 
		'209130' => chr(242), '209131' => chr(243), '209132' => chr(244), '209133' => chr(245), '209134' => chr(246), 
		'209135' => chr(247), '209136' => chr(248), '209137' => chr(249), '209138' => chr(250), '209139' => chr(251), 
		'209140' => chr(252), '209141' => chr(253), '209142' => chr(254), '209143' => chr(255)); 
		
		if (is_array($str)) 
		{ 
			foreach($str as $k=>$v)	$str[$k] = fUtf8ToWin1251($v); 				
			return $str; 
		} 
		else
		{ 
			$len = strlen($str); 
			$temp = ''; 
			for($i=0;$i<$len;$i++) 
			{ 
				$chcode = ord($str[$i]); 
				while($i<$len-1 && $chcode!=208 && $chcode!=209) 
				{ 
					$temp.=$str[$i]; 
					$chcode = ord($str[++$i]); 
				} 
				
				if($i<$len-1) 
				{ 
					$key = (string) $chcode.ord($str[++$i]); 
					if(isset($chars[$key])) $temp.= $chars[$key]; 
					else $temp.=$str[$i]; 
				} 
				else $temp.=$str[$i];
			} 
			return($temp); 
		} 
	}
?>
