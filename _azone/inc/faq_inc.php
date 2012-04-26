<?
	if (!isset($cFaq)) $cFaq = $cDB->fGetModule('faq');	
	return $cFaq->fDisplay();
?>