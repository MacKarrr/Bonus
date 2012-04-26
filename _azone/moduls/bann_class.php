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
		$this->moduleCaption = 'баннер';
			
		$this->moduleFields['dateon'] = array('type' => 'DATE', 'attr' => 'NOT NULL');
		$this->moduleFields['dateoff'] = array('type' => 'DATE', 'attr' => 'NOT NULL');
		$this->moduleFields['htmlcode'] = array('type' => 'TEXT', 'max' => 15000, 'attr' => "NOT NULL");
		
		$this->moduleAttaches['i_bann'] = $this->krnl->imageAttaches;
		$this->moduleAttaches['i_bann']['mod'] = array();
		$this->moduleAttaches['i_bann']['max'] = 102; // до 100 кБ

		$this->moduleFields['fw'] = array('type' => 'INT', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['fh'] = array('type' => 'INT', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['showmax'] = array('type' => 'INT', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['showcur'] = array('type' => 'INT', 'attr' => 'NOT NULL DEFAULT 0');
		
		$this->orderAzoneField = 'id';		
		$this->itemFormItems['name'] = array('caption' => 'Название баннера');		
		$this->itemFormItems['href'] = array('caption' => 'Адрес баннера', 'comment'=>'Например: http://www.qb-art.ru');
		$this->itemFormItems['page'] = array('type' => 'multilist', 'linkclass'=>'bann_page', 'nameclass'=>'page', 'queryFields'=>array('id'=>'pageId','sel'=>'bannId'), 'caption' => 'Разделы сайта', 'comment'=>"Для выбора нескольких разделов, требуется нажать клавишу 'CTRL' и выбирать мышью позиции.");			
		$this->itemFormItems['dateon'] = array('type' => 'date', 'caption' => 'Начало показа');
		$this->itemFormItems['dateoff'] = array('type' => 'date', 'caption' => 'Окончание показа','end'=>1);
		$this->itemFormItems['showmax'] = array('caption' => 'Количество показов', 'comment'=>'"0" - не ограничено');
		$this->itemFormItems['showcur'] = array('caption' => 'Количество показов (текущее)', 'view'=>1);
		$this->itemFormItems['i_bann'] = array('type' => 'attach', 'caption' => 'Изображение (Flash)', 'att_type' => 'image');
		$this->itemFormItems['i1'] = array('type' => 'viewtext', 'caption' => '<div align="center"><strong>Характеристики FLASH-баннера</strong></div>');	
		$this->itemFormItems['fw'] = array('caption' => 'Ширина FLASH-баннера','comment'=>'Поле должно быть пустым, если баннер - картинка. Максимальная ширина 200px');
		$this->itemFormItems['fh'] = array('caption' => 'Высота FLASH-баннера','comment'=>'Поле должно быть пустым, если баннер - картинка.');
		$this->itemFormItems['i2'] = array('type' => 'viewtext', 'caption' => '<div align="center"><strong>Характеристики баннера с исходным кодом</strong></div>');	
		$this->itemFormItems['htmlcode'] = array('type' => 'textarea', 'rows'=>5,'caption' => 'HTML код баннера','comment'=>'Поле должно быть пустым, если баннер - картинка.');
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => 'Активен');
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
		$this->moduleCaption = 'гнёзда';

		$this->enumerate['banntype'] = array(
			'ban1'=>'Место 1 (940х95)',
			'ban2'=>'Место 2 (940х95)',
			'ban3'=>'Место 3 (940х95)',
			'ban4'=>'Место 4 (940х95)',
			'ban5'=>'Место 5 (940х95)',
			'ban6'=>'Место 6 (940х95)',
			'ban7'=>'Место 7 (940х95)',
			'ban8'=>'Место 8 (940х95)',
			'ban9'=>'Место 9 (940х95)',
			'ban10'=>'Место 10 (940х95)'
			/*
			'ban11'=>'Место 11 (200хХ)',
			'ban12'=>'Место 12 (200хХ)'
			*/
			);
			
		$this->moduleFields['banntype'] = array('type' => 'VARCHAR', 'width'=>'15', 'attr' => 'NOT NULL');
		
		$this->orderAzoneField = 'id';		
		// $this->itemFormItems['name'] = array('caption' => 'Наименование гнезда');
		// $this->itemFormItems['banntype'] = array('type' => 'list','listname'=>'banntype','caption'=>'Тип баннера');
		// $this->itemFormItems['active'] = array('type' => 'bool', 'caption' => 'Активен');
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
