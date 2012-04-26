<?
	if (!isset($cBonus)) 
	{
		$cCountryBonus = $this->krnl->fGetModule('countrybonus');
		$cBonus = $cCountryBonus->childsClass['regionbonus']->childsClass['citybonus']->childsClass['bonus'];;
	}
	return $cBonus->fMap();	
?>