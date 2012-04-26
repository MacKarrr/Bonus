<?
	if($_REQUEST['page'] == 'xml')
	{
		if (!isset($cBonus)) $cBonus = $cDB->fGetModule('countrybonus')->childsClass['regionbonus']->childsClass['citybonus']->childsClass['bonus'];
		// $cBonus->city = $cCity->id;
		return $cBonus->fDisplayXml();
	}
	return false;
?>