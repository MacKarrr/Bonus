<? 
	$azone->data = array();
	if ($formName == "addp") 
	{
		$azone->data['parentId'] = $module->id;
		$azone->data['ownerId'] ='';
		if ($module->mActiveField) $azone->data['active'] = 1;
	}
	elseif ($formName == "addc") 
	{
		$azone->data['parentId'] = '';
		$azone->data['ownerId'] = $module->id;
		if ($module->mActiveField) $azone->data['active'] = 1;
	}
	else 
	{
		$module->fSelect();
		$azone->data = $module->moduleData[0];
	}

	$azone->formItems = $module->itemFormItems;
	$azone->module = &$module;
	$azone->fCreateForm();
	
	if (isset($azone->form) && count($azone->form))
	{ ?><form name="updatefrm" method="POST" action="action.php" enctype="multipart/form-data">
		<input type="hidden" name="moduleName" value="<?=$_REQUEST['moduleName'];?>">
		<input type="hidden" name="itemId" value="<?=$_REQUEST['itemId'];?>">
		<input type="hidden" name="moduleNameBack" value="<?=$_REQUEST['moduleNameBack'];?>">
		<input type="hidden" name="itemIdBack" value="<?=$_REQUEST['itemIdBack'];?>">
		<input type="hidden" name="class" value="<?=$class;?>">
		<input type="hidden" name="action" value="<?=$formName;?>">

<? if ($formName == "addp" || $formName == "addc") { ?>
		<input type="hidden" name="parentId" value="<?=$azone->data['parentId'];?>">
		<input type="hidden" name="ownerId" value="<?=$azone->data['ownerId'];?>">
<? } ?>
<table cellpadding="0" cellspacing="1" id="control" width="680" align="center">
<col width="180"></col><col width="500"></col>
<tr><th class="header" colspan="2"><h1><?=$formName=="edit"?$module->editFormTitle:$module->addFormTitle; ?></h1></th></tr>
<? 
	
		foreach($azone->form as $key=>$item) echo $item;

?><tr><td class="buttoncell" colspan="2"><input type="submit" class="submit" value="сохранить"></td></tr></table></form><? } ?>	