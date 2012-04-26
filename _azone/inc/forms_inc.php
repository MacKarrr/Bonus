<?
	if (!isset($cForms)) $cForms = $cDB->fGetModule('forms');		
	$data = $cForms->fDisplay();	
	if (count($cForms->pagePath)) $cPage->pagePath = array_merge($cPage->pagePath,$cForms->pagePath);
	return fXmlTransform('<text><![CDATA['.$cPage->pageText.']]></text>'.$data[0],$data[1]);
?>