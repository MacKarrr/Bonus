<?	
	session_start();
	header('Content-type: text/html; charset=windows-1251');
	
	$pathKRNL = include(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/pathkrnl.php');	
	require_once($pathKRNL.'kernel/initial_class.php');
	require_once($pathKRNL.'kernel/db_class.php');

	$cDB = new cDB();		
	$cDB->fDbConnect();	
	
	if (isset($_POST['cost']) && (int)($_POST['cost'])
		&& $cDB->fCheckAuth()
		)
	{
		$date = date('Y-m-d H:i:s');
		$cDB->dbQuery = "INSERT ".$cDB->dbPref."usersbalans SET balans=".(int)$_POST["cost"].", paydate='".$date."', ownerId=".$cDB->userId;
		if ($cDB->fDbExecute()) 
		{
			$cDB->dbQuery = "SELECT id FROM ".$cDB->dbPref."usersbalans WHERE balans=".(int)$_POST["cost"]." AND paydate='".$date."' AND ownerId=".$cDB->userId;
			if ($cDB->fDbExecute() && $cDB->fDbNumRows()) 
			{
				$row = $cDB->fDbGetRow();
				if ($row['id']) echo $row['id'];
				else echo 0;
			}
			else echo 0;
		}
		else echo 0;
	}
	else echo 0;
	$cDB->fDbClose();
?>	
