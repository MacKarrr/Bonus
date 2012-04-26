<?
	session_start();

	header("Cache-Control: max-age=0, must-revalidate" );
	header("Last-Modified: ".gmdate("D, d M Y H:i:s", time()-1)." GMT");
	header("Expires: ".gmdate("D, d M Y H:i:s", time()-1)." GMT");
	header("Content-type:text/html");

	if (isset($_REQUEST["class"])) 
		$class = $_REQUEST["class"];
	else 
	{
		$class = false;
		exit();
	}
	
	$pathKRNL = include(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/pathkrnl.php');	
	require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/kernel/initial_class.php');
	require_once($pathKRNL.'kernel/db_class.php');
	require_once($pathKRNL.'kernel/azone_class.php');
	require_once($pathKRNL.'kernel/azone_ex_class.php');

	$cDB = new cDB();
	$azone = new cAzone($cDB);
	$cDB->fDbConnect();

	if (isset($_REQUEST["page"]) && (int)$_REQUEST["page"])
		$page = (int)$_REQUEST["page"];
	else
		$page = 0;

	if ($class && file_exists($cDB->pathMDL.$class."_class.php")) 
	{
		require($cDB->pathMDL.$class."_class.php");
		$class_name = "c".$class;
		$module = new $class_name($cDB,$null);

// --------- PRM

		require_once($cDB->pathMDL."prm_class.php");
		$prm = new cPrm($cDB, $null);
		$azone->prmModule = $prm;

		if(!$prm->fCheckRights($module,PRM_SELECT)) 

		if(!$prm->fCheckRights($module,PRM_ORDER))
			$module->mOrderField = false;

		if(!$prm->fCheckRights($module,PRM_ADD))
			$module->mAdd = false;

		if(!$prm->fCheckRights($module,PRM_DELETE))
			$module->mDelete = false;

// -------- END PRM

		if (isset($_REQUEST["moduleName"])) {
			$moduleName = $_REQUEST["moduleName"];
			$module = $module->fGetByModuleNick($moduleName);
		}
		else 
			$moduleName = $module->moduleNick;

		if (isset($_REQUEST["itemId"])) 
			$itemId = $_REQUEST["itemId"];
		else 
			$itemId = NULL;
		
		$azone->parentUd = $moduleName."_".$itemId;
		$azone->moduleNameBack = $moduleName;
		$azone->itemIdBack = $itemId;
	}
	else
	{
		$class = false;
		exit();
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><HTML><HEAD><title>MODULS LIST</title><meta name="author" content="Vladimir Atamanov (VA)"><meta name="document-state" content = "dynamic"><meta name="robots" content = "noindex"><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><script language="JavaScript" src="scripts/gen_list.js" type="text/javascript"></script></HEAD><BODY onLoad='fLoad("<?=$azone->parentUd?>");'><DIV id="content"><?
		$list = "<table width=\"100%\" height=\"20\" cellpadding=\"0\" cellspacing=\"0\"><col width=10></col><col></col><col></col>";
		$azone->mainModule = &$module;
		if (!$itemId || ($module->mIsTree && $itemId)) 
		{
			$module->parentId = $itemId; 
			$azone->cid = $itemId;
			$azone->module = &$module;
			$azone->module->listPage = $page;
			$azone->isChildList = false;
			$azone->fCreateList($class);
			$list .= $azone->itemList;
		}

		if (count($module->childsClass) && $itemId) 
			foreach($module->childsClass as $key => $child) 
			{
				$module->childsClass[$key]->ownerId = $itemId; 
				$module->childsClass[$key]->parentId = NULL;
				$azone->cid = $itemId;
				$azone->module = &$module->childsClass[$key];
				$azone->module->listPage = $page;
				$azone->isChildList = true;
				$azone->fCreateList($class);
				$list .= $azone->itemList;
			}

		if ($list!= "") 
			echo $list."</table>"; 
		else 
			echo "<b>нет объектов</b>";

		unset($list);
	?></DIV></BODY></HTML><? $cDB->fDbClose(); ?>	
