<? 
session_start();

	$modulsList = parse_ini_file("azone.ini");
	$arData = array();
	$content = "";
	$arContent = array();

	$pathKRNL = include(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/pathkrnl.php');	
	require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/kernel/initial_class.php');
	require_once($pathKRNL.'kernel/db_class.php');
	require_once($pathKRNL.'kernel/azone_ex_class.php');	
	
	$cDB = new cDB();
	$cDB->fDbConnect();

	require_once($cDB->pathMDL."prm_class.php");
	$prm = new cPrm($cDB, $null);

	$content = '<table width="725"><tr>';
	$i = $countModule =0;

	foreach($modulsList as $class=>$className)
	{
		if (file_exists($cDB->pathMDL.$class."_class.php"))
		{
			if ($cDB->mPrmControl)
			{
				require_once($cDB->pathMDL.$class."_class.php");
				$class_name = "c".$class;
				$module = new $class_name($cDB,$null);
					
				if ($cDB->mPrmControl)
				{
					if($prm->fCheckRights($module,PRM_SELECT)) 
						$content .= "<td><a href=\"#\" onClick=\"fOpenGlobal1('".$class."');return false;\">".$className."</a></td>";
				}
				else
					$content .= "<td><a href=\"#\" onClick=\"fOpenGlobal2('".$class."');return false;\">".$className."</a></td>";

				++$i;
				++$countModule;
			}
			else
			{
				$content .= "<td><a href=\"#\" onClick=\"fOpenGlobal2('".$class."');return false;\">".$className."</a></td>";
				++$i;
			}	
		}

		if($i==5) 
		{ 
			$i = 0; 
			$content .= "<tr>"; 
		}
	}

	$content .= "</table>";
	$Auth = "";

	if ($cDB->mPrmControl)
	{
		
		$Auth = '<div class="us"><strong class="user">'.$_SESSION['prmLogin'].'</strong><a href="/_azone/index.php?prmExit=ok" target="_top" class="exit">бШИРХ</a></div>';

		if(!$countModule)
			$content = '<table class="denied"><tr><td>яохянй лндскеи осяр, кхан с бюя мер опюб мю ху опнялнрп</td></tr></table>';	
	}


?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><HTML><HEAD><title>MODULS LIST</title>
<meta name="author" content="Vladimir Atamanov (VA) - ATIKO"><meta name="document-state" content = "dynamic"><meta name="robots" content = "noindex"><meta http-equiv = "cache-control" content = "no-cache"><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><link rel="stylesheet" type="text/css" href="styles/modul_list.css"><script language="JavaScript" src="scripts/modul_list.js" type="text/javascript"></script></HEAD><BODY>
<table width="100%" cellpadding="0" cellspacing="0" class="menu"><tr><td class="logo"><a href="http://www.qb-art.ru" target="_blank"><img src="/_azone/im/logo.gif" alt="ATIKO"></a><?=$Auth;?></td><td class="menu2"><?=$content?></td></tr></table></BODY></HTML>