<?
	if (!isset($cSrch)) $cSrch = $cDB->fGetModule('srch');	
	return $cSrch->fSearch($_REQUEST['srch']);
?>