<?
session_start();

	$azone = false;
	if (file_exists("azone.ini")) 
	{
		$modulsList = parse_ini_file("azone.ini");
		if (count($modulsList))
			$azone = true;
	}

// --------- PRM
	  
	$pathKRNL = include(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/pathkrnl.php');	
	require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/kernel/initial_class.php');
	require_once($pathKRNL.'kernel/db_class.php');
	require_once($pathKRNL.'kernel/azone_ex_class.php');
	
	$cDB = new cDB();
	
	if ($cDB->mPrmControl)
	{
		$cDB->fDbConnect();

		require_once($cDB->pathMDL."prm_class.php");
		$prm = new cPrm($cDB, $null);
		$initialPoint = $prm->fInitialization();
		  
		if(isset($_REQUEST['prmExit']) && $_REQUEST['prmExit']=="ok") 
		{
			$_SESSION['prmClear'] = 1;
			header("Location: index.php");
		}
		else 
			$_SESSION['prmClear'] = 0;

		if($initialPoint===true)
		{
			if(!$prm->fLogin())
			{
				$prm->fDrawLoginForm();
				die();
			}
		 }
		 else
		 {
			$prm->fDrawLoginForm(false);
			die();
		 }
	}
	
// --------- END PRM

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE><?=$_SERVER['SERVER_NAME']?> - ADMINISTRATOR ZONE</TITLE>
<meta name="author" content="Vladimir Atamanov (VA)- ATIKO">
<meta name="robots" content = "noindex">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link REL="SHORTCUT ICON" HREF="/_azone/favicon.ico">
</HEAD>
<? if ($azone) { ?>

	<FRAMESET rows="75,*" BORDER="0" FRAMESPACING="0">
	  <FRAME name="mList" src="modul_list.php" noresize frameborder="0" BORDER="0" scrolling="no">
	  <FRAMESET cols="30%,*" BORDER=0 FRAMESPACING="0">
		<FRAMESET rows="*,25" BORDER="0" FRAMESPACING="0">
			<FRAME name="iList" src="item_list.php" noresize frameborder="0" BORDER="0">
			<FRAME name="copy" src="copyright.html" noresize frameborder="0" BORDER="0" scrolling="no">
		</FRAMESET>	
		<FRAME name="action" src="action.php" noresize frameborder="0" BORDER="0">
	  </FRAMESET>
	</FRAMESET>

<? } else { ?> 

	<p>Ошибка загрузки! Список модулей не найден.</p>

<? }?>
</HTML>
