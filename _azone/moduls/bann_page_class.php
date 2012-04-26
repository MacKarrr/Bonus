<?
class cBann_Page extends cModule
{
	function fInitialSettings() 
	{
		parent::fInitialSettings();
		return 1;
	}

	function fCreateModule() 
	{
		parent::fCreateModule();
		$this->tableName = 'bann_page';
		$this->moduleFields['bannId'] = array('type' => 'INT UNSIGNED', 'attr' => 'NOT NULL', 'key'=>1);
		$this->moduleFields['pageId'] = array('type'=>'VARCHAR','width' =>63,'attr'=>'NOT NULL','key'=>1);
	}
}
?>