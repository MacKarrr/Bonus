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
	
	$arData = $arUsers = $arUsersData = $arIns = array();
	
	// Получаем нужные акции
	$cBonus->queryFields = array('t1.id','t1.name',"DATE_FORMAT(t1.edate,'%Y') as y","DATE_FORMAT(t1.edate,'%c') as c","DATE_FORMAT(t1.edate,'%m') as m","DATE_FORMAT(t1.edate,'%d') as d",'t2.id as offerId','t2.bprice','t2.eprice');
	$cBonus->queryTerms = "t1, ".$cBonus->childsClass['bonusoffer']->tableName." t2 WHERE t1.active=1 AND t2.ownerId=t1.id AND t2.active=1 AND DATE_FORMAT(t1.edate,'%Y-%m-%d')>='".date('Y-m-d')."' AND DATE_FORMAT(t1.bdate,'%Y-%m-%d')<='".date('Y-m-d')."' ORDER BY t1.orderIndex DESC, t1.id, t2.orderIndex";
	// $cBonus->queryTerms = "t1, ".$cBonus->childsClass['bonusoffer']->tableName." t2 WHERE t1.active=1 AND t2.ownerId=t1.id AND t2.active=1 ORDER BY t1.orderIndex, t1.id, t2.orderIndex";

	if ($cBonus->fList(0)) 
	{
		$cBonus->fGetFoto(); 
		foreach($cBonus->moduleData as $row) $arData[$row['id']] = $row;
		
		$cDB->dbQuery = 'SELECT t1.id, t1.email, t2.bonusId as bonusId FROM '.$cDB->dbPref.'users t1 LEFT JOIN '.$cDB->dbPref.'userssend t2 ON t2.ownerId=t1.id ORDER BY t1.id';		
		
		if ($cDB->fDbExecute())
			while ($row = $cDB->fDbGetRow())
			{
				$arUsers[$row['id']] = $row['email'];
				$arUsersData[$row['id']] = $arData;
				
				if (isset($arUsersData[$row['id']][$row['bonusId']]))
				{
					unset($arUsersData[$row['id']][$row['bonusId']]);
				}
			}
		// $cBonus->fText4Script();
		
		$limit = 0;
		$title = '';
		
		foreach($arUsersData as $id=>$data)
		{
			if ($limit==10) break;
			if (count($data))
			{
				$i = 0;
				$cBonus->moduleData = array();			
				foreach ($data as $k=>$v) 
					if ($v!==0)
					{
						$v['name'] = $cBonus->fText4Script($v['name']);
						$phrase  = "You should eat fruits, vegetables, and fiber every day.";
						$symbol = array('«', '»');
						$v['name'] = str_replace($symbol, '"', $v['name']);
						
						$arIns[] = '('.$id.','.$k.')';
						$cBonus->moduleData[] = $v;
						if ($i==0)
						{
							$title = $v['name'];
						}
						$i++;
					}
				
				$html = fXmlTransform($cBonus->fGatherData(0, 1),'subscribe'); 
				
				// if ($arUsers[$id]=='va@qb-art.local')
				$cBonus->fSendMail(
					$arUsers[$id],
					$title.' и множество других выгодных акций от BonusMouse.ru',
					$html);
				sleep(1);
				$limit++;
			}
		}
		if (count($arIns))
		{
			$cDB->dbQuery = 'INSERT '.$cDB->dbPref.'userssend (ownerId,bonusId) VALUES '.implode(',',$arIns);
			$cDB->fDbExecute();
		}
	}
	
	function fXmlTransform($xml,$xsl='text',$full=1)
	{
		global $xslt,$cDB;
		if ($full) $xml = '<items> <domainName>'.$cDB->domainName.'</domainName> <auth>'.$cDB->fCheckAuth().'</auth> '.$xml.'</items>';
		$arguments = array('/_xml' => '<?xml version="1.0" encoding="windows-1251"?><!DOCTYPE fragment [<!ENTITY nbsp "&#160;">]> '.$xml,'/_xsl' => implode("", file($cDB->pathXSL.$xsl.".xsl")));
		$result = xslt_process($xslt, 'arg:/_xml', 'arg:/_xsl', NULL, $arguments);
		if (!$result)
		{
			// "Error in Template $transform E:".xslt_error($xslt);
			$f = fopen($cDB->pathWWW."m_page/xsl", "w"); fwrite($f, $xml); fclose($f);
		}
		return $result;
	}
	
	// CLOSE KERNEL & XSLT
	xslt_free($xslt);
	$cDB->fDbClose();	
	
?>