<?
	header('Content-type: text/html; charset=windows-1251');
	$pathKRNL = include(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/pathkrnl.php');	
	require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/kernel/initial_class.php');
	require_once($pathKRNL.'kernel/db_class.php');
	$cDB = new cDB();	
	$html = '';		
	
	if (!empty($_POST['type']) && isset($_POST['ownerId']) && (int)$_POST['ownerId'] && eregi("^".$cDB->domainName,$_SERVER['HTTP_REFERER']))
	{
		$type = $_POST['type'];
		$ownerId = $_POST['ownerId'];
		
		if (substr($type,0,4)=='form') { $form = 'form'; $type = substr($type,4); }
		else $form = '';
		
		if ($type=='region' || $type=='city')
		{
			$cDB->fDbConnect();
				
			if ($type=='region')
			{
				$table = 'region';			
				$script = 'onChange="fCityList(\''.$form.'city\')"';
			}
			elseif ($type=='city')
			{
				$table = 'city';			
				if ($form=='form') $script = 'onChange="fCityUpForm(this.value)"';
				else $script = 'onChange="fCitySel(this.value)"';
			}

			$cDB->dbQuery = 'SELECT id, name FROM '.$cDB->dbPref.$table.' WHERE active=1 AND ownerId='.$ownerId.' ORDER BY name';
			if ($cDB->fDbExecute())
			{
				$html = '<select name="'.$form.$type.'" '.$script.'> <option value="0">- Выберите -</value>';
				while ($row = $cDB->fDbGetRow()) $html .= '<option value="'.$row['id'].'">'.$row['name'].'</value>';
				$html .= '</select>';
			}
			
			$cDB->fDbClose();
		}
	}
	
	if ($html=='') $html = '<select name="" class="error"><option value="0">Ошибка загрузки!</value></select>';
	
	echo $html;
?>