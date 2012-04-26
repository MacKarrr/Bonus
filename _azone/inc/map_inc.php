<? 
	$tree = $cPage->fMap(); 
	return fXmlTransform($cPage->fOutTree($tree['page'],$tree),'text');
?>