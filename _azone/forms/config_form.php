<? 
	$azone->data = $module->config;
	$azone->formItems = $module->configFormItems;
	$azone->module = &$module;
	$azone->fCreateForm();
?>
<form name="updatefrm" method="POST" action="action.php" enctype="multipart/form-data">
		<input type=hidden name='moduleName' value='<?=$_REQUEST['moduleName']; ?>'>
		<input type=hidden name='itemId' value='<?=$_REQUEST['itemId']; ?>'>
		<input type=hidden name='moduleNameBack' value='<?=$_REQUEST['moduleNameBack']; ?>'>
		<input type=hidden name='itemIdBack' value='<?=$_REQUEST['itemIdBack']; ?>'>
		<input type=hidden name='class' value='<?=$class;?>'>
		<input type=hidden name='action' value='config'>
<table cellpadding="0" cellspacing="1" id="control" width="470" align="center"><col width="180"></col><col width="290"></col>
<tr><th class="header" colspan="2"><h1>Конфигурация</h1></th></tr>
<? if (count($azone->form)) foreach($azone->form as $key=>$item) echo $item; ?>
<tr><td class="buttoncell" colspan="2"><input type="submit" class="submit" value="сохранить"></td></tr></table></form>