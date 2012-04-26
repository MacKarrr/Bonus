<?
class cCounter extends cModule
{
	function fInitialSettings() 
	{
		parent::fInitialSettings();
		$this->mActiveField = true;
		$this->mOrderField = true;
		return 1;
	}

	function fCreateModule() 
	{
		parent::fCreateModule();
		$this->tableName = 'counter';
		$this->moduleCaption = 'счетчики';
		$this->moduleFields['htmlcode'] = array('type' => 'TEXT', 'max' => 2048, 'attr' => 'NOT NULL','min'=>1);
		$this->itemFormItems['name'] = array('caption' => 'Название счетчика');
		$this->itemFormItems['htmlcode'] = array('type' => 'textarea', 'caption' => 'HTML код счетчика');
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => 'Активен');
	}

	function fDisplayIndex()
	{
		$xml = '';
		$this->queryFields = array('*');
		$this->queryTerms = 'WHERE active=1 ORDER BY orderIndex';

		if($this->fList(0))
			foreach($this->moduleData as $row)
				$xml .= '<htmlcode><![CDATA['.$row['htmlcode'].']]></htmlcode>';
		return $xml;
	}
}
?>
