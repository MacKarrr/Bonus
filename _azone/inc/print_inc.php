<?
	if (!isset($cBonus)) $cBonus = $cCity->childsClass['bonus'];
	$cBonus->city = $cCity->id;
	$cPage->pageTpl = 'print';
	$cPage->fCheckTpl();	
	return fXmlTransform($cBonus->fDisplayPrint(),'print');
?>