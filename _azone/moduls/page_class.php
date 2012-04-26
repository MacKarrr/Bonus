<?

class cPage extends cModule 
{
	var $pageTpl = 'default';

	function fInitialSettings() 
	{
		parent::fInitialSettings();
		$this->mIsTree = true;
		$this->mOrderField = true;
		$this->mActiveField = true;
		$this->mOnSearch = true;
		$this->mLinkField = true;
	}

	function fCreateModule() 
	{
		parent::fCreateModule();
		$this->tableName = 'page';
		$this->moduleCaption = '��������';

		$this->searchFeatures = array('fields'=>array('name', 'm_page'), 'description'=>'m_page', 'name'=>'name', 'pref'=>'page', 'suff'=>'.html');
		$this->enumerate['pagetype'] = array(
			''=>'���������� �����',
			'bonus'=>'������',
			'pay'=>'������',
			'print'=>'������ ������',
			'vacancy'=>'��������',
			'faq'=>'FAQ',				
			'remind'=>'�������������� ������',
			'reg'=>'�����������',
			'activation'=>'��������� ��������',
			'forms'=>'�����',
			'my'=>'�������',
			'partnerpage'=>'�������� ��������',
			'payact'=>'��������� ������',
			'docs'=>'������������',
			'map'=>'����� �����',
			'srch'=>'���������� ������',
			'backlink'=>'�������� �����',
			'xml'=>'XML');
		
		$this->moduleFields['template'] = array('type' => 'VARCHAR', 'width'=>15, 'attr' => "NOT NULL DEFAULT 'default'");
		$this->moduleFields['pagetype'] = array('type' => 'VARCHAR', 'width'=>15, 'attr' => "NOT NULL DEFAULT ''");
		$this->moduleFields['onmenu'] = array('type' => 'BOOL', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['onmenu2'] = array('type' => 'BOOL', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['onmenu3'] = array('type' => 'BOOL', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['onmenu4'] = array('type' => 'BOOL', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['hidden'] = array('type' => 'BOOL', 'attr' => 'NOT NULL DEFAULT 0');

		$this->moduleMemos['m_page'] = array('max' => 20000);

		$this->itemFormItems['link'] = array('caption' => 'ID');
		$this->itemFormItems['name'] = array('caption' => '�������� ��������');
		if ($this->mLinkField)
		{
			$this->itemFormItems['h1'] = array('caption' => 'H1 ��������');
			$this->itemFormItems['title'] = array('caption' => 'Title ��������');
			$this->itemFormItems['keywords'] = array('caption' => 'Keywords ��������');
			$this->itemFormItems['description'] = array('caption' => 'Description ��������');		
		}
		$this->itemFormItems['href'] = array('caption' => '����� ��������','comment'=>'������ ����� � ������� �����, ��� �������������');
		$this->itemFormItems['pagetype'] = array('type' => 'list', 'listname'=>'pagetype', 'caption' => '�� �������� ����������');
		$this->itemFormItems['m_page'] = array('type' => 'memo', 'caption' => '����� ��������', 'max' => 20000);
		$this->itemFormItems['template'] = array('type' => 'list', 'listname'=> 'design', 'caption' => '������ ��������');
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => '���������� �� �����');
		$this->itemFormItems['onmenu'] = array('type' => 'bool', 'caption' => '�������� � ����');
		$this->itemFormItems['onmenu2'] = array('type' => 'bool', 'caption' => '�������� � ����<br>(� ��������)');
		$this->itemFormItems['onmenu3'] = array('type' => 'bool', 'caption' => '�������� � ����<br>(������ ������)');
		$this->itemFormItems['onmenu4'] = array('type' => 'bool', 'caption' => '�������� � ����<br>(�������������)');
		$this->itemFormItems['hidden'] = array('type' => 'bool', 'caption' => '��������� ��������');
		$this->itemFormItems['parentId'] = array('type' => 'list', 'listname'=>'list', 'caption' => '������������ ��������');

		$this->config['sitename'] = '';
		$this->config['sitedescr'] = '';
		$this->config['email'] = 'va@qb-art.ru';
		$this->config['copyright'] = '';
		$this->config['phone'] = '';
		$this->config['keywords'] = '';
		$this->config['description'] = '';
		$this->config['about'] = '';
		$this->config['sufemail'] = '';
		$this->config['yandexmap'] = '';
		
		$this->configFormItems['sitename'] = array('type' => 'text', 'caption' => '�������� �����');
		$this->configFormItems['sitedescr'] = array('type' => 'text', 'caption' => '�������� �����');
		$this->configFormItems['email'] = array('type' => 'text', 'caption' => 'E-mail �����', 'comment'=>'������ email ����� �������');
		$this->configFormItems['phone'] = array('type' => 'text', 'caption' => '�������');
		$this->configFormItems['about'] = array('type' => 'memo', 'editor'=>'Small', 'width'=>500, 'height'=>200,'caption' => '� �����');
		$this->configFormItems['sufemail'] = array('type' => 'memo', 'editor'=>'Small', 'width'=>500, 'height'=>200,'caption' => '������� � �������� ����� �����');		
		$this->configFormItems['copyright'] = array('type' => 'text','caption' => '��������');
		$this->configFormItems['yandexmap'] = array('type' => 'text','caption' => '���� ������ ����');
		$this->configFormItems['keywords'] = array('type' => 'textarea', 'rows'=>5, 'caption' => '�������� �����');
		$this->configFormItems['description'] = array('type' => 'textarea', 'rows'=>5, 'caption' => '�������� c����');
		
	}

	function fGetList() 
	{
		if ($this->listName == 'design') 
		{
			$dir = opendir($this->krnl->pathTPL);
			if (!$dir) return 0;
			$this->moduleData = array();
			while ($file = readdir($dir)) 
				if ($file!='.' && $file!='..' && (!is_dir($this->krnl->pathTPL.$file)))
				{
					$file = substr($file,0,-4);
					$this->moduleData[$file] = $file;
				}
				
			ksort($this->moduleData);
			return 1;
		}
		else 
			return parent::fGetList();
	}

	function fInitialPage()
	{		
		$link = '';
		
		if (isset($_REQUEST['pageId']) && preg_match("/^[0-9]+$/",$_REQUEST['pageId'])) $this->id = $this->krnl->currentId = $_REQUEST['pageId'];
		elseif(isset($_REQUEST['page']) && preg_match("/^[0-9A-Za-z\_\-]+$/",$_REQUEST['page']))
		{
			$query = '';
			$this->krnl->dbQuery = "SHOW TABLES LIKE '".$this->krnl->dbPref."%'";
			if ($this->krnl->fDbExecute())
				while(list($table) = $this->krnl->fDbGetRow(MYSQL_NUM))
					if (!in_array($table,array('srch','counter','backlink','bann','bannim','bann_page','prm_group','prm_users','counter','region','city','metro')))
						$query .= "SELECT id, '".$table."' as module FROM ".$table." WHERE link = '".$_REQUEST['page']."' UNION ";
			
			$this->krnl->dbQuery = $query." SELECT 0 as id, '".$this->krnl->dbPref.$_REQUEST['page']."' as module FROM ".$this->tableName." WHERE pagetype = '".$_REQUEST['page']."'";
			if ($this->krnl->fDbExecute() && $this->krnl->fDbNumRows())
			{
				list($this->krnl->currentId,$this->krnl->currentModule) = $this->krnl->fDbGetRow(MYSQL_NUM);
				$this->krnl->currentModule = substr($this->krnl->currentModule,strlen($this->krnl->dbPref));
				if ($this->krnl->currentModule=='page') $link = "link = '".$_REQUEST['page']."'";
				else $link = "pagetype = '".(in_array($this->krnl->currentModule,array_keys($this->krnl->arMainClass))?$this->krnl->arMainClass[$this->krnl->currentModule]:$this->krnl->currentModule)."'"; // ������� �������� ������, ������� ������ � ENUMERATE
			}
		}
		else $link = "link='index'";
		
		if (!$this->id && $link!='')
		{
			$this->krnl->dbQuery = 'SELECT id FROM '.$this->tableName.' WHERE '.$link;
			if ($this->krnl->fDbExecute() && $this->krnl->fDbNumRows()) list($this->id) = $this->krnl->fDbGetRow(MYSQL_NUM);
		}
		
		$this->selectId = $this->id;		
		$this->fGetPath();
		$this->pagePath = array_reverse($this->pagePath);
		
		$this->fCheckTpl(); // �������� �� ������������� �������
		
		return $this->id;
	}	
	
	function fGetContent()
	{
		$fileName = $this->krnl->pathWWW.'m_page/'.$this->id.'.art';
		if (file_exists($fileName)) $this->pageText = file_get_contents($fileName);
		
		if ($this->moduleData[0]['template']!='') $this->pageTpl = $this->moduleData[0]['template'];
		$this->pageInc = $this->moduleData[0]['pagetype'];

		if ($this->pageInc!='' && !file_exists($this->krnl->pathINC.$this->pageInc.'_inc.php')) return 0;
		else
		{
			$tree = $this->fMap(0);
			$this->pageText = $this->pageText.(isset($tree['page'.$this->id])?fXmlTransform($this->fOutTree($tree['page'.$this->id],$tree),'text'):'');
		}
		
		return 1;
	}
	
	function fCheckTpl()
	{
		$this->pagePathTpl = $this->krnl->pathTPL.$this->pageTpl.'.tpl';		
		if (file_exists($this->pagePathTpl)) return true;
		else exit('<h2 align="center">�� ���� ������� ������<h2>');        
	}

	function fPathXML()
	{
		$xml = '';
		foreach($this->pagePath as $href=>$name) $xml .= '<item> <href>'.$href.'</href> <name><![CDATA['.$name.']]></name> </item>';					
		return $xml;
	}

	function fMenuXML()
	{
		$xml = '';
		$this->queryFields = array('id','link','href','name','onmenu','onmenu2','onmenu3','onmenu4');
		$this->queryTerms = 'WHERE active=1 AND (onmenu=1 OR onmenu2=1  OR onmenu3=1  OR onmenu4=1) ORDER BY orderIndex, name';
		if ($this->fList(0))
			foreach($this->moduleData as $row)
			{
				list($blank,$href) = $this->fGetHref($row);
				if($row['href']=='' && $row['link']=='index') $href = $this->krnl->domainName;
				if (in_array($row['id'],$this->arSelId)) $sel = 1;
				else $sel = 0;
				$xml .= '<item onmenu1="'.$row['onmenu'].'" onmenu2="'.$row['onmenu2'].'" onmenu3="'.$row['onmenu3'].'" onmenu4="'.$row['onmenu4'].'" sel="'.$sel.'" blank="'.$blank.'"> <href>'.$href.'</href> <name><![CDATA['.$row['name'].']]></name> </item>';
			}
			
		return $xml;
	}

	function fPageNotFound()
	{
		header('HTTP/1.0 404 Not Found');		
		$this->pageTpl = 'default';
		$this->fCheckTpl();
		$tpl['title'] = $this->name = '�������� �� �������!';
		$tpl['path'] = fXmlTransform('<item> <name>'.$tpl['title'].'</name> </item>','path');
		$tpl['text'] = '<p><br/>������������� ���� �������� �� ������� ��� ���� ������� ���������������</p><p>��������� ������������ ���������� URL. �������� �������� �� ��, ��� �������� � ��������� ����� � ��������� ���� ������ � ��������� �����������.</p><p>�������� ����� ����������� ��� �������� ������� <a href=\''.$this->krnl->domainName.'map.html\'>����� �����</a> </p><p>� ������, ���� �� �� ������ ������ �������� �������������� � <a href=\''.$this->krnl->domainName.'backlink.html\'>�������� � ��� ���</a></p>';
		return $tpl;
	}

	function fMap($type=1)
	{
		$this->queryFields = array('id','link','parentId','href','name','pagetype');
		$this->queryTerms = "WHERE hidden=0 AND active=1 ORDER BY orderIndex, name";
		$tree = array();			
			if ($this->fList(0))
				foreach($this->moduleData as $row)
				{
					list($blank,$href) = $this->fGetHref($row);
					if (!$row['parentId']) $row['parentId'] = '';
					if (in_array($row['id'],$this->arSelId)) $sel = 1;
					else $sel = 0;
					
					if ($row['pagetype']!='' && $type)
					{
						$tree['page'.$row['parentId']][$row['pagetype']] = array($row['pagetype'],$row['name'],$href,$sel);
						$mapFile = $this->krnl->pathINC.$row['pagetype'].'_map_inc.php';
							if (file_exists($mapFile))
							{
								$includeTree = include($mapFile);
								$tree = array_merge($tree,$includeTree);
							}
					}
					else $tree['page'.$row['parentId']]['page'.$row['id']] = array('page'.$row['id'],$row['name'],$href,$sel);						
				}

		return $tree;
	}
}
?>