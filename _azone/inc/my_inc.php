<?
	if (!isset($cBonus)) $cBonus = $cCity->childsClass['bonus'];
	$cBonus->city = $cCity->id;
	$cUsers->id = $cDB->userId;
	
	return fXmlTransform($cUsers->fDisplay().$cBonus->fDisplayOffer().$cBonus->fDisplayInterest(),'profile');

?>