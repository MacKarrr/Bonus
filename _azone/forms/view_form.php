<? 
	$azone->data = array();

	$module->fSelect();
	$azone->data = $module->moduleData[0];

	$azone->formItems = $module->itemFormItems;
	$azone->module = &$module;
	
	foreach($azone->formItems as $k=>$v)
		$azone->formItems[$k]['view'] = 1;
		
	$azone->fCreateForm();

	if (count($azone->form))
	{ ?><table cellpadding="0" cellspacing="1" id="control" width="680" align="center">
<col width="180"></col><col width="500"></col>
<tr><th class="header" colspan="2"><h1><?=$module->viewFormTitle;?></h1></th></tr>
<? 
	foreach($azone->form as $key=>$item) echo $item;
	
?> </tr></table> <? } ?>










