<?
	if (!isset($cDocs)) $cDocs = $cDB->fGetModule('docs');
	return $cDocs->fDisplay();
?>