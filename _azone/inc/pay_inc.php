<?
	if (!isset($cBonus)) $cBonus = $cCity->childsClass['bonus'];
	$data = $cBonus->fDisplayPay();
	return fXmlTransform('<text><![CDATA['.$cPage->pageText.']]></text>'.$data[0],$data[1]);
?>