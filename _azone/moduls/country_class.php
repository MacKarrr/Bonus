<?
class cMetro extends cModule
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

		$this->tableName = 'metro';
		$this->moduleCaption = '�����';
		$this->itemFormItems['name'] = array('type' => 'text', 'caption' => '�����');
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => '�������');
	}
}

class cCity extends cModule
{
	var $name;
	var $hour;

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

		$this->tableName = 'city';
		$this->moduleCaption = '������';

		$this->orderAzoneField = 'active, orderIndex';	
			
		$this->moduleFields['email'] = array('type' => 'VARCHAR', 'attr' => 'NOT NULL');
		$this->moduleFields['hour'] = array('type' => 'INT UNSIGNED', 'attr' => 'NOT NULL DEFAULT 0');

		$this->itemFormItems['name'] = array('type' => 'text', 'caption' => '������������ ������');
		$this->itemFormItems['email'] = array('type' => 'text', 'caption' => 'E-mail ���������');
		$this->itemFormItems['hour'] = array('type' => 'text', 'caption' => '������� ���� (� �����)');
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => '�������');
		$this->fCreateChild('metro');
	}
}

class cRegion extends cModule
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

		$this->tableName = 'region';
		$this->moduleCaption = '�������';

		$this->itemFormItems['name'] = array('type' => 'text', 'caption' => '������������ �������');
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => '�������');
		$this->fCreateChild('city');
	}
}

class cCountry extends cModule
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

		$this->tableName = 'country';
		$this->moduleCaption = '������';

		$this->itemFormItems['name'] = array('type' => 'text', 'caption' => '������������ ������');
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => '�������');
		$this->fCreateChild('region');
	}
	
	function fDisplay()
	{
		$path = array();
		$cRegion = &$this->childsClass['region'];
		
		if (isset($_REQUEST['regionId']) && (int)$_REQUEST['regionId'])
		{
			$cCity = &$cRegion->childsClass['city'];
			$cCity->queryFields = array('t1.*','t2.name as oname');
			$cCity->queryTerms = 't1, '.$cRegion->tableName.' t2 WHERE t1.ownerId=t2.id AND t2.id='.$_REQUEST['regionId'].' ORDER BY t1.orderIndex';
				if ($cCity->fList(0))
				{
					$path[0] = $cCity->moduleData[0]['oname'];
					foreach ($cCity->moduleData as $row)
						$xml .= '<item> <href>'.$this->krnl->domainImgName.'city'.$row['id'].'/</href> <name>'.$row['name'].'</name> </item>';
				}
		}
		else
		{
			$cRegion->queryFields = array('*');
			$cRegion->queryTerms = 'WHERE ownerId=3159 ORDER BY orderIndex';
				if ($cRegion->fList(0))
					foreach ($cRegion->moduleData as $row)
						$xml .= '<item> <href>'.$this->krnl->domainImgName.'region'.$row['id'].'.html</href> <name>'.$row['name'].'</name> </item>';
		}					
		return array($xml,$path);
	}	
}

?>