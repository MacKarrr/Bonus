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
	require_once($pathKRNL.'kernel/azone_ex_class.php');		

	$cDB = new cDB();
	$cDB->fDbConnect();

	if ($class && file_exists($cDB->pathMDL.$class."_class.php")) 
	{
		require($cDB->pathMDL.$class."_class.php");
		$class_name = "c".$class;
		$module = new $class_name($cDB,$null);

		require_once($cDB->pathMDL."prm_class.php");
		$prm = new cPrm($cDB, $null);
		
		if(!$prm->fCheckRights($module,PRM_SELECT)) 
			exit($prm->deniedAllItem);
	}
	else
		$class = false;
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><HTML><HEAD><title>MODULS LIST</title><meta name="author" content="Vladimir Atamanov (VA)"><meta name="document-state" content = "dynamic"><meta name="robots" content = "noindex"><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><link rel="stylesheet" type="text/css" href="styles/item_list.css"><script language="JavaScript" type="text/javascript" src="scripts/item_list.js"></script></HEAD><BODY>

<form name="ac" method="POST" action="<?=$cDB->pathADM?>action.php" target="action"><input type="hidden" name="act" value="none"><input type="hidden" name="uid" value="none"></form>

<? if ($class) {	?><div id="list"><table width="100%" cellpadding="0" cellspacing="0"><tr><td class="m"><? 
	
	if (($prm->fCheckRights($module,PRM_PRM) && $cDB->mPrmControl) || ($prm->fCheckRights($module,PRM_CONFIG) && (count($module->services) || count($module->config)))) 
	{ 	
		?><table cellpadding="0" cellspacing="0" class="serv"><? 
			if ($prm->fCheckRights($module,PRM_CONFIG))
			{
				if (count($module->services)) 
				{ 
					?><tr><td colspan="2" class="ttl"><B>сервисы:	</B></td></tr><?
					foreach($module->services as $k=>$v) 
					{
						if ($v['type'] == "form") 
							$action = "window.open('action.php?class=".$class."&moduleName=".$class."&formName=service&serviceName=".$k."','action');";
						else 
							$action = "document.forms.configure.serviceName.value='".$k."'; document.forms.configure.submit();";

						echo "<tr><td width=\"15\"><img src=\"/_azone/im/ao.gif\"></td><td>&nbsp;<a href=\"#\" onClick=\"".$action."return false;\">".$v['caption']."</a></td></tr>";
					}
				}

				if (count($module->config)) 
					echo "<tr><td width=\"15\"><img src=\"/_azone/im/ao.gif\"></td><td>&nbsp;<a href=\"#\" onClick=\"window.open('action.php?class=".$class."&moduleName=".$class."&formName=config','action');return false;\">свойства</a></td></tr>";
			}

			if ($prm->fCheckRights($module,PRM_PRM) && $cDB->mPrmControl)
			{
				echo "<tr><td width=\"15\"><img src=\"/_azone/im/ao.gif\"></td><td>&nbsp;<a href=\"#\" onClick=\"window.open('action.php?class=".$class."&moduleName=".$class."&formName=prm','action');return false;\">права доступа</a></td></tr>";
				echo "<tr><td width=\"15\"><img src=\"/_azone/im/ao.gif\"></td><td>&nbsp;<a href=\"#\" onClick=\"document.forms.configure.serviceName.value='unsetitemprm'; document.forms.configure.submit();return false;\">сбросить права позиций</a></td></tr>";
			}

?></table><? } ?><table width="100%" cellpadding="0" cellspacing="0"><tr><td class="items" id="u<?=$module->moduleNick?>_"><span class="load">загрузка...</span></td></tr></table><IFRAME name="_gen_list" src ="gen_list.php?class=<?=$class?>" style="display:none;"></IFRAME><FORM name="configure" method="POST" enctype="multipart/form-data" target="action" action="action.php"><input type="hidden" name="action" value="service"><input type="hidden" name="serviceName" value=""><input type="hidden" name="moduleName" value="<?=$class?>"><input type="hidden" name="class" value="<?=$class?>"></FORM></div></td></tr></table><? } ?></BODY></HTML><? $cDB->fDbClose(); ?>