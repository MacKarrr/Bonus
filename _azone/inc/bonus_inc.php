<?
	if (!isset($cBonus)) $cBonus = $cCity->childsClass['bonus'];
	$cBonus->city = $cCity->id;
	if($_REQUEST['cat'] && (int)$_REQUEST['cat'])
	{
		
		$catId = $_REQUEST['cat'];
		
		if (!isset($_REQUEST['bonusId']) && !(int)$_REQUEST['bonusId'] && !$_REQUEST['bonusId']=='arch')
		{
			$cBonus->krnl->dbQuery = "SELECT count(t1.id) as cnt, t2.name FROM ".$cBonus->tableName." t1 LEFT JOIN ".$cBonus->krnl->dbPref."cat t2 ON t2.id = t1.catid WHERE t1.catId=".$catId." AND t1.active=1 AND DATE_FORMAT(t1.edate,'%Y-%m-%d')>='".date('Y-m-d')."' AND DATE_FORMAT(t1.bdate,'%Y-%m-%d')<='".date('Y-m-d')."' AND t2.active=1";
			
			if ($cBonus->krnl->fDbExecute() && $cBonus->krnl->fDbNumRows())
			{
				$row = $cBonus->krnl->fDbGetRow();

				if($row['cnt']!=0)
				{
					$cat = 't1.catId ='.$catId.' AND ';
					$catName = '<h1>'.$row['name'].'</h1>';
				}
			} else $cat = '';
		}
		else
		{
			$cat = $_REQUEST['cat'];
		}
	}
	
	$data = $cBonus->fDisplay($cat);
	return $catName.fXmlTransform($data[0],$data[1]);
?>