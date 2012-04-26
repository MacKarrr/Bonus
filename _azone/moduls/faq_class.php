<?

class cFaq extends cModule
{

	function fInitialSettings() 
	{
		parent::fInitialSettings();
		$this->mActiveField = true;
		$this->mOrderField = true;
		$this->mOnSearch = true;
		return 1;
	}

	function fCreateModule() 
	{
		parent::fCreateModule();

		$this->tableName = 'faq';
		$this->moduleCaption = 'FAQ';

		$this->searchFeatures = array('fields'=>array('name', 'descr'), 'description'=>'descr', 'name'=>'name', 'pref'=>'faq.html#', 'suff'=>'');

		$this->moduleFields['descr'] = array('type' => 'TEXT', 'max' => 2048, 'attr' => 'NOT NULL');

		$this->itemFormItems['name'] = array('type' => 'text', 'caption' => 'Наименование');
		$this->itemFormItems['descr'] = array('type' => 'dbmemo', 'editor'=>'Small', 'width'=>480, 'height'=>250, 'caption' => 'Требования');
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => 'Активна');
	}

	function fDisplay()
	{
		$xml = '';
		$this->queryFields = array('*');
		$this->queryTerms = 'WHERE active=1 ORDER BY orderIndex';
			if($this->fList())
				foreach($this->moduleData as $row)
					$xml .= '<item id="'.$row['id'].'"> <name><![CDATA['.$row['name'].']]></name> <descr><![CDATA['.$row['descr'].']]></descr> </item>';
		return fXmlTransform($xml,'faq');
	}

}

?>