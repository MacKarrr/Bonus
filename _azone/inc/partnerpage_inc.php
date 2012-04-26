<?
	if (!isset($cBonus)) $cBonus = $cCity->childsClass['bonus'];
	$cBonus->city = $cCity->id;
	
	return fXmlTransform($cBonus->fDisplayPartner(),'partner');

?>