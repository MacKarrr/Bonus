<?
class cCat extends cModule
{
function fInitialSettings()
	{
		parent::fInitialSettings();
		$this->mActiveField = true;
		return 1;
	}

	function fCreateModule()
	{
		parent::fCreateModule();

		$this->tableName = 'cat';
		$this->moduleCaption = '���������';

		$this->itemFormItems['name'] = array('type' => 'text', 'caption' => '���������');
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => '�������');
	}
}
?>