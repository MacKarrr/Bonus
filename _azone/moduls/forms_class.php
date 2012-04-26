<?

class cFormsI extends cModule
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

		$this->tableName = 'formsi';
		$this->moduleCaption = '����';
		
		$this->enumerate['itype'] = array(
			'text'=>'��������� ����', 
			'textarea' => '������������� ����',
			'select'=>'������',
			'checkbox'=>'���������� (��-���)',
			'radio'=>'����� ������',
			'info'=>'������������� ����');	
		
		$this->moduleFields['itype'] = array('type' => 'VARCHAR', 'width' => 16, 'attr' => 'NOT NULL');
		$this->moduleFields['req'] = array('type' => 'BOOL', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['items'] = array('type' => 'VARCHAR', 'width' => 1024, 'attr' => "NOT NULL DEFAULT ''");
		$this->moduleFields['comment'] = array('type' => 'VARCHAR', 'attr' => "NOT NULL DEFAULT ''");
		
		$this->itemFormItems['name'] = array('caption' => '������������ ����');
		$this->itemFormItems['itype'] = array('type' => 'list', 'listname'=>'itype','caption' => '��� ����');
		$this->itemFormItems['items'] = array('type' => 'textarea', 'rows'=>6,'caption' => '�������� ������', 'comment'=>"��� ����� ����: '������', '���������� (��-���)', '����� ������'. ������ ������� � ����� ������!");
		$this->itemFormItems['comment'] = array('caption' => '�����������');
		$this->itemFormItems['req'] = array('type' => 'bool', 'caption' => '������������ ����');	
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => '�������');
	}
}

class cForms extends cModule
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

		$this->tableName = 'forms';
		$this->moduleCaption = '�����';

		$this->itemFormItems['link'] = array('caption' => 'ID');
		$this->itemFormItems['name'] = array('type' => 'text', 'caption' => '������������ �����');
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => '�������');
		$this->fCreateChild('formsi');
	}

	function fDisplay()
	{
		$xml = $xsl = $txt = '';
		$this->fInitialPage();
		if ($this->id)
		{
			if ($this->krnl->email!='')
			{
				$cFormsi = &$this->childsClass['formsi'];
				$cFormsi->queryFields = array('*');
				$cFormsi->queryTerms = 'WHERE active=1 AND ownerId='.(int)$this->id.' ORDER BY orderIndex';				
					if($cFormsi->fList(0))
					{
						if (isset($_POST['fsend']) && $_POST['fsend']=='���������' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER'])) 
							$data = $this->fStripSlashes($_POST);
							
						$this->form = array();	
						$this->form['_*features*_'] = array('action'=>'#form');
						foreach($cFormsi->moduleData as $row)
						{
							if (!isset($data[$row['id']])) $data[$row['id']] = '';						

							$this->form[$row['id']]['claim'] = $row['req'];
							$this->form[$row['id']]['type'] = $row['itype'];
							$this->form[$row['id']]['comment'] = $row['comment'];
								
								if ($row['itype']=='info') 
									$this->form[$row['id']]['value'] = $row['name'];
								else
								{
									$this->form[$row['id']]['caption'] = $row['name'];
									$txt .= '<b>'.$row['name'].'</b> : ';
									
									if (in_array($row['itype'],array('text','textarea')))
									{
										$this->form[$row['id']]['value'] = $data[$row['id']];
										$txt .= $data[$row['id']].'<br>';
									}	
									else
									{
										$valList = array();
										$arValItems = explode('<br />',nl2br($row['items']));											
											
										if ($row['itype']=='radio' && (!isset($data[$row['id']]) || $data[$row['id']]=='')) $data[$row['id']] = '0';
										
											foreach($arValItems as $k=>$v)
											{
												if (
													(is_array($data[$row['id']]) && in_array($k,$data[$row['id']]))
													 || ($data[$row['id']]!='' && $k==$data[$row['id']])
												) 
												{
													$sel = 1;
													$txt .= $v.', ';
												}
												else 
													$sel = 0;
													
												$valList[''][$k] = array($k,$v,'',$sel);
											}
										$this->form[$row['id']]['value'] = $valList;
										$txt .= '<br>';
									}									
								}
						}	
						
						$this->form['secret_code'] = array('claim'=>1,'type'=>'secret','caption'=>'������� ���:','mask'=>array('name'=>'secret'));
						$this->form['fsend'] = array('type'=>'submit','value'=>'���������');		

						if (isset($_POST['fsend']) && $_POST['fsend']=='���������'&& eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER'])) 
						{
							list($error,$data) = $this->fFormCheck($data);
								if($error=='')
								{
									$ttl = '��������� ������ '.$this->name.' �� ����� '.$_SERVER['SERVER_NAME'].'.';
									$txt = '<h2>��������� ������ "'.$this->name.'" �� ����� '.$_SERVER['SERVER_NAME'].'.</h2> ������ ������: <blockquote> '.$txt.' </blockquote>';
										if($this->fSendMail('dq15@mail.ru, mackarr@inbox.ru',$ttl,$txt))
											$xml = '<ok>�������! ���� ������ ������� ����������!</ok>';
										else
											$xml = '<er2>������ �3. ���� ������ �� ����������!. �������� ��������� �� ������������ ����������.</er2>';
								}
								else
									$xml = $this->fForm2xml();
						}
						else
							$xml = $this->fForm2xml();								
					}
					else
						$xml = '<er2><![CDATA[������ �2. ������ �������� �����.<br> �������� ��������� �� ������������ ����������.]]></er2>';						
			}
			else
				$xml = '<er2><![CDATA[������ �1. ������ ��� ������������� ����� �� ����� ���� ����������.<br> �������� ��������� �� ������������ ����������.]]></er2>';
				
			$xsl = 'formblock';			
		}
		elseif (!$this->krnl->page404)
		{
			$tree = $this->fMap();
			$xml = $this->fOutTree($tree['forms'],$tree);
			$xsl = 'text';
		}
		
		return array($xml,$xsl);
	}
	
	function fDisplayIndex()
	{
		$tree = $this->fMap();
		return $this->fOutTree($tree['forms'],$tree);
	}
}

?>
