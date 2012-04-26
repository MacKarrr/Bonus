<?
session_start();

	header("Cache-Control: max-age=0, must-revalidate" );
	header("Last-Modified: ".gmdate("D, d M Y H:i:s", time()-1)." GMT");
	header("Expires: ".gmdate("D, d M Y H:i:s", time()-1)." GMT");
	header("Content-type:text/html");

	if (isset($_REQUEST["class"])) 
		$class = $_REQUEST["class"];
	else 
		$class = false;
	
	$pathKRNL = include(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/pathkrnl.php');	
	require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/kernel/initial_class.php');
	require_once($pathKRNL.'kernel/db_class.php');
	require_once($pathKRNL.'kernel/azone_class.php');
	require_once($pathKRNL.'kernel/azone_ex_class.php');

	
	$cDB = new cDB();
	$azone = new cAzone($cDB);
	$cDB->fDbConnect();

	$arActionName = array(
		"delete"	=> "удаление данных", 
		"addp"		=> "добавление данных",	
		"addc"		=> "добавление данных", 
		"up"		=> "изменение порядка", 
		"down"		=> "изменение порядка", 
		"edit"		=> "изменение данных",
		"service"	=> "выполнение сервиса",
		"config"	=> "конфигурирование модуля",
		"prm"		=>  "конфигурирование прав доступа",
		"unsetitemprm"	=>	"сброс прав доступа позиций");

	$arActionResult = array(
		0 => "<span style='color:red'><b>ошибка выполнения</b></span>",
		1 => "<span style='color:green'><b>выполнено</b></span>",
		2 => "<span style='color:red'><b>записи не найдены</b></span>");

	$formName = NULL;
	$backFormName = NULL;
	$action = NULL;
	$imgLoad = 0;
	
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
			exit($prm->deniedAllAction);

// -------- END PRM

		$mainNick = $module->moduleNick;
		$mainCaption = $module->moduleCaption;

		if (isset($_REQUEST["moduleName"])) 
		{
			$moduleName = $_REQUEST["moduleName"];
			$module = $module->fGetByModuleNick($moduleName);
		}
		else 
			$moduleName = $module->moduleNick;
		
		if (isset($_REQUEST["itemId"])) 
			$module->id = $_REQUEST["itemId"];
		else 
			$module->id = NULL;

		if (isset($_REQUEST["formName"])) 
			$formName = $_REQUEST["formName"];

		if (isset($_REQUEST["action"])) 
			$action = $_REQUEST["action"];
	}
	else
		$class = false;
	
	if (isset($action)) 
	{
		if ($action == 'delete') 
		{
			if(!$prm->fCheckRights($module,PRM_DELETE,$module->id)) 
				exit($prm->denied);

			$result = $module->fDeleteItem();
		} 
		elseif ($action == "config") 
		{
			if(!$prm->fCheckRights($module,PRM_CONFIG)) 
				exit($prm->denied);

			$module->fVarsToData("config");
			$module->config = array_merge($module->fieldsData,$module->memosData);
			$result = $module->fSaveConfig();
				if(!$result)
					$formName = "config";
		} 
		if ($action == "prm") 
		{
			if(!$prm->fCheckRights($module,PRM_PRM,$module->id)) 
				exit($prm->denied);
			
			$module->fVarsToData("prm");
			$result = $module->fSavePrm();
				if(!$result)
					$formName = "prm";
		}
		elseif ($action == "addp") 
		{
			if(!$prm->fCheckRights($module,PRM_ADD)) 
				exit($prm->denied);

			$module->fVarsToData("item");
			$result = $module->fAddItem();
				if(!$result)
					$formName = "addp";
				elseif ($cDB->imagick!="" && count($module->attachesData))
					foreach($module->attachesData as $k=>$v)
						if ($v['name']!="" && $module->itemFormItems[$k]["att_type"]=="image")
							$imgLoad = 1;					
		} 
		elseif ($action == "addc") 
		{
			if(!$prm->fCheckRights($module,PRM_ADD)) 
				exit($prm->denied);

			$module->fVarsToData("item");
			
			$result = $module->fAddItem();
				if(!$result)
					$formName = "addc";
				elseif ($cDB->imagick!="" && count($module->attachesData))
					foreach($module->attachesData as $k=>$v)
						if ($v['name']!="" && $module->itemFormItems[$k]["att_type"]=="image")
							$imgLoad = 1;
		} 
		elseif ($action == "edit") 
		{
			if(!$prm->fCheckRights($module,PRM_UPDATE,$module->id)) 
				exit($prm->denied);

			$module->fVarsToData("item");
			$result = $module->fUpdateItem();
				if(!$result)
					$formName = "edit";
				elseif ($cDB->imagick!="" && count($module->attachesData))
					foreach($module->attachesData as $k=>$v)
						if ($v['name']!="" && $module->itemFormItems[$k]["att_type"]=="image")
							$imgLoad = 1;					
		} 
		elseif ($action == "up" || $action == "down") 
		{
			if(!$prm->fCheckRights($module,PRM_ORDER,$module->id)) 
				exit($prm->denied);

			$result = $module->fUpDownItem($action);
		} 
		elseif ($action == "service" && $_REQUEST['serviceName']=='unsetitemprm')
		{
			$action = "unsetitemprm";
			$result = $module->fUnsetItemPrm();
		}
		elseif ($action == "service" && $_REQUEST['serviceName']!='' && $_REQUEST['serviceName']!='unsetitemprm') 
		{
			if(!$prm->fCheckRights($module,PRM_CONFIG)) 
				exit($prm->denied);
		
			$service = $module->services[$_REQUEST['serviceName']];
			$result = $module->$service['function']();

				if ($service['type'] == "form" && !$result)
					$formName = "service";
		}

		$actionName = $arActionName[$action];
	} 

	$pagePath = "";

	if ($class && $formName!="") 
	{
		/*
		$module->id = $itemId;
		$module->fGetPath();
		$modulsList = parse_ini_file("azone.ini");
		$module->path[] = ucfirst($modulsList[$class]);
		$module->path[0] = "<h1>".$module->path[0]."</h1>";
		$module->path = array_reverse($module->path);
			foreach($module->path as $k=>$v) 
				$pagePath .= $v." &rarr; ";
		$pagePath = substr($pagePath,0,-7);
		*/
		$modulsList = parse_ini_file("azone.ini");
		$pagePath = "<h1>".ucfirst($modulsList[$class])."</h1>";
	}
	
	$msg = "";
	if (count($cDB->messages))
		foreach($cDB->messages as $k=>$v) 
			$msg .= "<b class=\"red\">Ошибка:</b> ".$v."<br/>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><HTML><HEAD><title>ACTION PAGE</title><meta name="author" content="Vladimir Atamanov (VA) - ATIKO"><meta name="document-state" content = "dynamic"><meta name="robots" content = "noindex"><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><link rel="stylesheet" type="text/css" href="styles/action.css"><script language="JavaScript" src="scripts/jquery.js" type="text/javascript"></script><script language="JavaScript" src="scripts/action.js" type="text/javascript"></script></HEAD><BODY<? 
	
	if (isset($action)) 
	{
		if(isset($_REQUEST['moduleNameBack']))
			$moduleNameBack = $_REQUEST['moduleNameBack'];
		else
			$moduleNameBack = "";

		if(isset($_REQUEST['itemIdBack']))
			$itemIdBack = $_REQUEST['itemIdBack'];
		else
			$itemIdBack = "";
		
		if ($cDB->imagick!="")
			$cDB->imagick = "fiMagick('".$cDB->imagick."');";

		echo " onLoad=\"fList('".$class."','".$moduleNameBack."','".$itemIdBack."');".$cDB->imagick."\"";
	}
?>>
<table cellpadding="0" cellspacing="0" class="main"><? if ($class) { ?><tr><td class="dyna"><?=$pagePath;?></td></tr><tr><td class="log"><?=$msg;?></td></tr><tr><td class="mm" align="center"><? 
	if (isset($action) && $formName=="")
	{
		if (strlen($result)>1)
			echo $result;
		else
		{
			echo "<table class=\"info\" align=\"center\"><tr class=\"f\"><td class=\"c1\">действие:</td><td class=\"c2\"><B>".$actionName."</B></td></tr><tr class=\"s\"><td class=\"c1\">результат:<br></td><td class=\"c2\"><B>".$arActionResult[$result]."</B></td></tr>";
			if ($imgLoad) echo "<tr class=\"s\"><td colspan=\"2\" id=\"imgload\"><img src=\"im/addload.gif\" alt=\"Загрузка\"></td></tr>";
			echo "</table>";
		}
		
	} 
	if (isset($formName)) 
	{
		if ($formName == "addp" || $formName == "addc")	
		{
			if(!$prm->fCheckRights($module,PRM_ADD)) 
				exit($prm->denied);

			include($cDB->pathADM."forms/edit_form.php");
		}
		elseif ($formName == "edit")
		{
			if(!$prm->fCheckRights($module,PRM_UPDATE,$module->id)) 
				exit($prm->denied);

			include($cDB->pathADM."forms/edit_form.php");
		}
		elseif ($formName == "prm" && $cDB->mPrmControl)
		{
			if(!$prm->fCheckRights($module,PRM_PRM,$module->id)) 
				exit($prm->denied);

			include($cDB->pathADM."forms/prm_form.php");
		}
		elseif ($formName == "view")
		{
			if(!$prm->fCheckRights($module,PRM_SELECT,$module->id)) 
				exit($prm->denied);

			include($cDB->pathADM."forms/view_form.php");
		}
		else
		{
			if(!$prm->fCheckRights($module,PRM_CONFIG)) 
				exit($prm->denied);

			include($cDB->pathADM."forms/".$formName."_form.php");	
		}
	} 
?></td></tr><? } else { ?><tr><td>&nbsp;</td></tr><? } ?></table> <IFRAME name="_imagick" style="display:none"></IFRAME> </BODY></HTML><? $cDB->fDBClose(); ?>