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
		&& isset($_POST['cnt']) && (int)$_POST['cnt'] 
		&& isset($_POST['cost']) && (int)$_POST['cost']
		&& $cDB->fCheckAuth()
		)
	{		
		if ($cDB->userBalans >= (int)$_POST['cost'])
		{			
			$cDB->dbQuery = "UPDATE ".$cDB->dbPref."users SET balans=balans-".$_POST["cost"].", paydate='".date("Y-m-d H:i:s")."' WHERE id=".$cDB->userId;
			if ($cDB->fDbExecute()) 
			{
				$cDB->dbQuery = "UPDATE ".$cDB->dbPref."usersoffer SET paid=1, paydate='".date('Y-m-d H:i:s')."'  WHERE id=".(int)$_POST['id']." AND ownerId=".$cDB->userId;
				if ($cDB->fDbExecute()) echo 5; // ok
				else 
				{
					echo 4; 
					$cDB->dbQuery = 'UPDATE '.$cDB->dbPref.'users SET balans=balans+'.$_POST['cost'].' WHERE id='.$cDB->userId;
					$cDB->fDbExecute();
				}
			}
			else echo 3;
		}
		else echo 2; // нет средств
	}
	else echo 1;
	
	$cDB->fDbClose();
?>	
