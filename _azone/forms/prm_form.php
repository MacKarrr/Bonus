<? 
	if($module->id)
	{
		$module->fSelect();
		$azone->data = $module->moduleData[0];
	}
	else
		$azone->data = $module->modulePrm;

	$azone->formItems = $module->prmFormItems;
	$azone->module = &$module;
	$azone->fCreateForm();

?>
<form name="prm" method="POST" action="action.php" enctype="multipart/form-data">
		<input type="hidden" name="moduleName" value="<?=$_REQUEST['moduleName'];?>">
		<input type="hidden" name="itemId" value="<?=$module->id;?>">
		<input type="hidden" name="moduleNameBack" value="<?=$_REQUEST['moduleNameBack'];?>">
		<input type="hidden" name="itemIdBack" value="<?=$_REQUEST['itemIdBack'];?>">
		<input type="hidden" name="class" value="<?=$class;?>">
		<input type="hidden" name="action" value="<?=$formName;?>">

<table cellpadding="0" cellspacing="1" id="control" width="680" align="center">
<col width="180"></col><col width="500"></col>
<tr><th class="header" colspan="2"><h1>Права доступа</h1></th></tr><? 

	if (count($azone->form)) 
		foreach($azone->form as $key=>$item)	
			echo $item;
			
?><tr><td class="buttoncell" colspan="2"><input type="submit" class="submit" value="сохранить"></td></tr></table></form></td></tr>