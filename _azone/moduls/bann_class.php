<?
class cBannIm extends cModule
{
	function fInitialSettings() 
	{
		parent::fInitialSettings();
		$this->mOrderField = true;
		$this->mOrderFieldHide = true;
		$this->mActiveField = true;
		return 1;
	}
	
	function fCreateModule() 
	{
		parent::fCreateModule();

		$this->tableName = 'bannim';
		$this->moduleCaption = '������';
			
		$this->moduleFields['dateon'] = array('type' => 'DATE', 'attr' => 'NOT NULL');
		$this->moduleFields['dateoff'] = array('type' => 'DATE', 'attr' => 'NOT NULL');
		$this->moduleFields['htmlcode'] = array('type' => 'TEXT', 'max' => 15000, 'attr' => "NOT NULL");
		
		$this->moduleAttaches['i_bann'] = $this->krnl->imageAttaches;
		$this->moduleAttaches['i_bann']['mod'] = array();
		$this->moduleAttaches['i_bann']['max'] = 102; // �� 100 ��

		$this->moduleFields['fw'] = array('type' => 'INT', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['fh'] = array('type' => 'INT', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['showmax'] = array('type' => 'INT', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['showcur'] = array('type' => 'INT', 'attr' => 'NOT NULL DEFAULT 0');
		
		$this->orderAzoneField = 'id';		
		$this->itemFormItems['name'] = array('caption' => '�������� �������');		
		$this->itemFormItems['href'] = array('caption' => '����� �������', 'comment'=>'��������: http://www.qb-art.ru');
		$this->itemFormItems['page'] = array('type' => 'multilist', 'linkclass'=>'bann_page', 'nameclass'=>'page', 'queryFields'=>array('id'=>'pageId','sel'=>'bannId'), 'caption' => '������� �����', 'comment'=>"��� ������ ���������� ��������, ��������� ������ ������� 'CTRL' � �������� ����� �������.");			
		$this->itemFormItems['dateon'] = array('type' => 'date', 'caption' => '������ ������');
		$this->itemFormItems['dateoff'] = array('type' => 'date', 'caption' => '��������� ������','end'=>1);
		$this->itemFormItems['showmax'] = array('caption' => '���������� �������', 'comment'=>'"0" - �� ����������');
		$this->itemFormItems['showcur'] = array('caption' => '���������� ������� (�������)', 'view'=>1);
		$this->itemFormItems['i_bann'] = array('type' => 'attach', 'caption' => '����������� (Flash)', 'att_type' => 'image');
		$this->itemFormItems['i1'] = array('type' => 'viewtext', 'caption' => '<div align="center"><strong>�������������� FLASH-�������</strong></div>');	
		$this->itemFormItems['fw'] = array('caption' => '������ FLASH-�������','comment'=>'���� ������ ���� ������, ���� ������ - ��������. ������������ ������ 200px');
		$this->itemFormItems['fh'] = array('caption' => '������ FLASH-�������','comment'=>'���� ������ ���� ������, ���� ������ - ��������.');
		$this->itemFormItems['i2'] = array('type' => 'viewtext', 'caption' => '<div align="center"><strong>�������������� ������� � �������� �����</strong></div>');	
		$this->itemFormItems['htmlcode'] = array('type' => 'textarea', 'rows'=>5,'caption' => 'HTML ��� �������','comment'=>'���� ������ ���� ������, ���� ������ - ��������.');
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => '�������');
	}
	
	function fNextItem($type='up') 
	{	
		$this->krnl->dbQuery = 'SELECT orderIndex, ownerId FROM '.$this->tableName.' WHERE id = '.$this->id;
		$this->krnl->fDbExecute();
		if(!($currentRow = $this->krnl->fDbGetRow())) return 1;	
			
		if($type=='up')
		{
			$type = 'down';
			$equalSign = '<=';
			$orderType = 'DESC';
		}
		else
		{
			$type = 'up';
			$equalSign = '>=';
			$orderType = 'ASC';
		}
		
		$d = date('Y-m-d');		
		$this->krnl->dbQuery = "SELECT id, orderIndex FROM ".$this->tableName." WHERE orderIndex".$equalSign.$currentRow['orderIndex']." AND id<>".$this->id." AND ownerId = ".$currentRow['ownerId']." AND dateon<='".$d."' AND '".$d."'<=dateoff AND active=1 ORDER BY orderIndex ".$orderType." LIMIT 1";
		
		$this->krnl->fDbExecute();
		
			if($nextRow = $this->krnl->fDbGetRow())
			{
				$this->krnl->dbQuery = 'UPDATE '.$this->tableName.' SET orderIndex='.$nextRow['orderIndex'].' WHERE id='.$this->id;
				$this->krnl->fDbExecute();
				
				$this->krnl->dbQuery = 'UPDATE '.$this->tableName.' SET orderIndex='.$currentRow['orderIndex'].' WHERE id='.$nextRow['id'];
				$this->krnl->fDbExecute();
			}
			else
			{
				$this->krnl->dbQuery = "SELECT count(id) as cnt FROM ".$this->tableName." WHERE id<>".$this->id." AND ownerId=".$currentRow['ownerId']." AND dateon<='".$d."' AND '".$d."'<=dateoff AND active=1";
				$this->krnl->fDbExecute();	
				list($cnt) = $this->krnl->fDbGetRow(MYSQL_NUM);
				for($i=0;$i<$cnt;$i++) $this->fNextItem($type);
			}
			
		return 1;
	}
}

class cBann extends cModule
{
	function fInitialSettings() 
	{
		parent::fInitialSettings();
		$this->mActiveField = true;
		$this->mAdd = true;
		$this->mDelete = false;
		return 1;
	}
	
	function fCreateModule() 
	{
		parent::fCreateModule();

		$this->tableName = 'bann';
		$this->moduleCaption = '�����';

		$this->enumerate['banntype'] = array(
			'ban1'=>'����� 1 (940�95)',
			'ban2'=>'����� 2 (940�95)',
			'ban3'=>'����� 3 (940�95)',
			'ban4'=>'����� 4 (940�95)',
			'ban5'=>'����� 5 (940�95)',
			'ban6'=>'����� 6 (940�95)',
			'ban7'=>'����� 7 (940�95)',
			'ban8'=>'����� 8 (940�95)',
			'ban9'=>'����� 9 (940�95)',
			'ban10'=>'����� 10 (940�95)'
			/*
			'ban11'=>'����� 11 (200��)',
			'ban12'=>'����� 12 (200��)'
			*/
			);
			
		$this->moduleFields['banntype'] = array('type' => 'VARCHAR', 'width'=>'15', 'attr' => 'NOT NULL');
		
		$this->orderAzoneField = 'id';		
		// $this->itemFormItems['name'] = array('caption' => '������������ ������');
		// $this->itemFormItems['banntype'] = array('type' => 'list','listname'=>'banntype','caption'=>'��� �������');
		// $this->itemFormItems['active'] = array('type' => 'bool', 'caption' => '�������');
		$this->fCreateChild('bannim');
	}

	function fDisplay($pageId)
	{
		$xml = '';
		$d = date('Y-m-d');
		
		$cBannIm = &$this->childsClass['bannim'];
		$noBannId = 0;
		$this->krnl->dbQuery = 'SELECT bannId FROM '.$this->krnl->dbPref.'bann_page GROUP BY bannId';
		if ($this->krnl->fDbExecute()) while($row = $this->krnl->fDbGetRow()) $noBannId .= ','.$row['bannId'];
		$bannId = 0;
		$this->krnl->dbQuery = 'SELECT id, showmax, showcur FROM '.$cBannIm->tableName;
		if ($this->krnl->fDbExecute()) while($row = $this->krnl->fDbGetRow()) {	if (!$row['showmax'] || $row['showcur']<$row['showmax']) $bannId .= ','.$row['id']; }
		
		$this->queryFields = array('*');
		$this->queryTerms = 'ORDER BY banntype';			
		
			if ($this->fList(0))
				foreach($this->moduleData as $rowp)
				{
					$cBannIm->queryFields = array('t1.*','t3.banntype');					
					$cBannIm->queryTerms = " t1, ".$this->krnl->dbPref."bann_page t2, ".$this->tableName." t3 WHERE t3.id=t1.ownerId AND t1.id=t2.bannId AND t2.pageId='".$pageId."' AND t1.ownerId=".$rowp['id']." AND t1.active>0 AND t1.dateon<='".$d."' AND '".$d."'<=t1.dateoff AND t1.id IN (".$bannId.") UNION SELECT t1.*, t3.banntype FROM ".$cBannIm->tableName." t1, ".$this->tableName." t3 WHERE t3.id=t1.ownerId AND t1.id NOT IN (".$noBannId.") AND t1.ownerId=".$rowp['id']." AND t1.active>0 AND t1.dateon<='".$d."' AND '".$d."'<=t1.dateoff AND t1.id IN (".$bannId.") ORDER BY orderIndex LIMIT 1";

						if($cBannIm->fList())
						{
							$row = $cBannIm->moduleData[0];
							$cBannIm->id = $row['id'];
							$cBannIm->fieldsData['showcur'] = $row['showcur']+1;
							$cBannIm->fUpdateItem();														
							$cBannIm->fNextItem('up');							
							list($blank,$href) = $this->fGetBlankLink($row['href']);
							$xml .= '<bann type="'.$row['banntype'].'" blank="'.$blank.'" id="'.$row['id'].'"> <href><![CDATA['.$href.']]></href> <name><![CDATA['.$this->fText4Script($row['name']).']]></name> <htmlcode><![CDATA['.trim($row['htmlcode']).']]></htmlcode>  <img>'.$row['i_bann'].'</img> <ext>'.substr($row['i_bann'],-3).'</ext> <fw>'.$row['fw'].'</fw> <fh>'.$row['fh'].'</fh> </bann>';
						}
				}		
		return $xml;
	}	
}

?>
