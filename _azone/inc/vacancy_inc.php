<?
	if (!isset($cVacancy)) $cVacancy = $cDB->fGetModule('vacancy');	
	return $cPage->pageText.$cVacancy->fDisplay();
?>