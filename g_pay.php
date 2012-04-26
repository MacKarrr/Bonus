<?	
	session_start();
	header('Content-type: text/html; charset=windows-1251');
	
	$pathKRNL = include(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/pathkrnl.php');	
	require_once($pathKRNL.'kernel/initial_class.php');
	require_once($pathKRNL.'kernel/db_class.php');

	$cDB = new cDB();		
	$cDB->fDbConnect();	
	
	if (
		isset($_POST['id']) && (int)$_POST['id'] 
		&& isset($_POST['cnt']) && (int)($_POST['cnt']) 
		&& isset($_POST['cost']) && (int)($_POST['cost'])
		&& $cDB->fCheckAuth()
		)
	{
		$cDB->dbQuery = 'UPDATE '.$cDB->dbPref.'usersoffer SET cnt='.(int)$_POST['cnt'].', cost='.(int)$_POST['cost'].' WHERE offerId='.(int)$_POST['id'].' AND ownerId='.$cDB->userId;
		if ($cDB->fDbExecute()) echo 1;
		else echo 0;
	}
	else echo 2;
	$cDB->fDbClose();
?>	
