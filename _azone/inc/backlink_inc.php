<?
	if (!isset($cBackLink)) $cBackLink = $cDB->fGetModule('backlink');	
	return '<div class="formb">'.$cBackLink->fDisplay().'</div> '.$cPage->pageText.'<div class="clear"></div>';
?>