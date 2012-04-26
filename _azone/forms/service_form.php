<? 
	
	$service = $module->services[$_REQUEST['serviceName']];
	$azone->data = array();
	$azone->formItems = $service['form'];
	$azone->module = &$module;
	$azone->fCreateForm();
?>
<FORM name="updatefrm" method="POST" action="action.php" enctype="multipart/form-data">
<input type="hidden" name="class" value="<?=$class?>">
<input type="hidden" name="action" value="service">
<input type="hidden" name="serviceName" value="<?=$_REQUEST['serviceName']?>">
<? 
	if (count($azone->hiddens)) 
		foreach($azone->hiddens as $item) 
			echo "$item\n";
?>
 <table cellpadding="0" cellspacing="1" id="control">
  <col width="180"></col><col width="500"></col>
  <tr><th class=header colspan="2"><h1><? echo ucFirst($service['caption']); ?></h1></th></tr>
<? 
	if (count($azone->form)) 
		foreach($azone->form as $fieldname=>$item) 
			echo "$item\n";
?>
<tr><td class="buttoncell" colspan="2"><input type="submit" class="submit" value="принять"></td></tr></tr>
</table>

</FORM>

