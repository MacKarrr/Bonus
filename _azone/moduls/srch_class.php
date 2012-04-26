<?
class cSrch extends cModule 
{
	var $searchRule = 1; // 1 - не строгое соответствие; 0 - строгое соответствие
	var $messagesOnPage = 15;

	function fInitialSettings() 
	{
		parent::fInitialSettings();
		$this->mCharId = true;
		return 1;
	}

	function fCreateModule() 
	{
		parent::fCreateModule();
		
		$this->tableName = 'srch';

		$this->moduleFields['id'] = array('type' => 'VARCHAR', 'width' => 255, 'attr' => 'NOT NULL', 'min' => '1');
		$this->moduleFields['name'] = array('type' => 'VARCHAR', 'attr' => 'NOT NULL', 'min' => '1');
		$this->moduleFields['keywords'] = array('type' => 'TEXT', 'max' => 2048, 'attr' => 'NOT NULL');
		$this->moduleFields['topic'] = array('type' => 'VARCHAR', 'width' => 31, 'attr' => 'NOT NULL');
		$this->moduleFields['nick'] = array('type' => 'VARCHAR', 'width' => 31, 'attr' => 'NOT NULL');
		$this->moduleFields['description'] = array('type' => 'VARCHAR', 'width' => 255, 'attr' => 'NOT NULL');
		$this->moduleFields['adddate'] = array('type' => 'DATE', 'attr' => 'NOT NULL');
	}

	function fAddRecord($url,$data,$topic,$nick,$name,$description) 
	{
		if (in_array($nick,array('countrybonus','regionbonus','citybonus'))) return 1;
		
		preg_match_all("/[\-\_0-9A-Za-zА-Яа-я]+/", htmlspecialchars(strip_tags($data), ENT_QUOTES), $regs);
		$description = preg_replace(array("/\\\\/", "/'/"), array("\\\\", "\\'"), strip_tags($description));
			if (strlen($description) > 255)
			{
				$endPosition = strrpos(substr($description, 0, 250)," ");
					if ($endPosition!==false) 
						$description = substr($description, 0, $endPosition);
				$description .= "...";
			}
		$url = preg_replace(array("/\\\\/", "/'/"), array("\\\\", "\\'"), $url);
		$name = preg_replace(array("/\\\\/", "/'/"), array("\\\\", "\\'"), substr($name,0,254));
		$topic = preg_replace(array("/\\\\/", "/'/"), array("\\\\", "\\'"), $topic);
		
		$this->krnl->dbQuery = "REPLACE ".$this->tableName." SET id='".$url."', keywords='".implode(" ", $regs[0])."', name='".$name."', topic='".$topic."', nick='".$nick."', description='".$description."', adddate='".date("Y-m-d")."'";
		$this->krnl->fDbExecute();
	}

	function fAddSearchItemData_record(&$module,$delete='') 
	{
		if (!is_array($module->searchFeatures)) return 1;	
		 if ($module->tableName==$this->krnl->dbPref.'page' && isset($module->fieldsData['hidden']) && $module->fieldsData['hidden']==1) return 1;		
				
		$moduleData = array();
		
		if (is_array($module->searchFeatures['fields']))
			foreach($module->searchFeatures['fields'] as $field) 
			{
				if (isset($module->memosData[$field])) $value = $module->memosData[$field];
				elseif (isset($module->fieldsData[$field])) $value = $module->fieldsData[$field];					
				else $value = '';
				$moduleData[$field] = $value;
			}

		if (isset($module->searchFeatures['index']) && isset($module->fieldsData[$module->searchFeatures['index']]))
			$id = $module->fieldsData[$module->searchFeatures['index']];

		elseif (isset($module->searchFeatures['index']))
			$id = '';
	
		else
			$id = $module->id;	
		
		if (isset($module->searchFeatures['index2']) && isset($module->fieldsData[$module->searchFeatures['index2']]))
			$id2 = $module->fieldsData[$module->searchFeatures['index2']];

		elseif (isset($module->searchFeatures['index2']) && $module->searchFeatures['index2']=="ownerId")
			$id2 = $module->ownerId;
		else
			$id2 = '';			


		if (isset($module->searchFeatures['bsuff']))
			$suffixNew = $id2.$module->searchFeatures['bsuff'].$id.$module->searchFeatures['suff'];

		else
			$suffixNew = $id.$module->searchFeatures['suff'];

	
		$url = $module->id.'__'.$module->searchFeatures['pref'].$suffixNew;
		
			if ($delete=='delete')
			{
				$this->krnl->dbQuery = "DELETE FROM ".$this->tableName." WHERE id='".$url."'";
				$this->krnl->fDbExecute();
				return 1;
			}
		
		$description = $moduleData[$module->searchFeatures['description']];
		$name = $moduleData[$module->searchFeatures['name']];
		$topic = $module->moduleCaption;
		$nick = $module->moduleNick;
		$data = implode(' ', $moduleData);
		$this->fAddRecord($url,$data,$topic,$nick,$name,$description);
	}

	function fAddSearchAllData(&$module,$delete='') 
	{
		
		if (!is_array($module->searchFeatures)) return 1;
		
		$nick = $module->moduleNick;
		$this->krnl->dbQuery = "DELETE FROM ".$this->tableName." WHERE nick='".$nick."'";
		$this->krnl->fDbExecute();

		$arModuleFields = array('id as id001');
		
		if (is_array($module->searchFeatures['fields']))
			foreach($module->searchFeatures['fields'] as $field)
				if (isset($module->moduleFields[$field])) 
					$arModuleFields[] = $field;
		
		if (isset($module->searchFeatures['index']) && $module->searchFeatures['index']!='')
			$arModuleFields[] = $module->searchFeatures['index'];

		if (isset($module->searchFeatures['index2']) && $module->searchFeatures['index2']!='')
			$arModuleFields[] = $module->searchFeatures['index2'];

		$arModuleMemos = array();

			foreach($module->searchFeatures['fields'] as $field)
				if (isset($module->moduleMemos[$field]))
					$arModuleMemos[] = $field;

			if ($module->mIsTree)
				$arModuleFields[] = 'parentId';
		
		$this->krnl->dbQuery = "SELECT ".implode(",",$arModuleFields)." FROM ".$module->tableName;
		$i = 0;
			if($module->mActiveField)
			{
				$this->krnl->dbQuery .= ' WHERE active>0';
				$i = 1;
			}
			
			if ($module->tableName==$this->krnl->dbPref.'page')
			{
				if (!$i) $this->krnl->dbQuery .= ' WHERE hidden = 0';
				else $this->krnl->dbQuery .= ' AND hidden = 0';
			}
			if ($module->owner && count($module->arSrchId))
			{
				if (!$i) $this->krnl->dbQuery .= ' WHERE ownerId IN (0,'.implode(',',$module->arSrchId).')';
				else $this->krnl->dbQuery .= ' AND ownerId IN (0,'.implode(',',$module->arSrchId).')';				
			}
			
		$this->krnl->fDbExecute();

			if (!$this->krnl->dbError && $this->krnl->fDbNumRows())
			{
				while($row = $this->krnl->fDbGetRow()) 
					$moduleData[] = $row;
				
				if ($module->mIsTree)
				{
					$arId = $arParentId = $arNotParentId = array();
					
					foreach($moduleData as $row)
					{
						$arId[] = $row['id001'];
						$arParentId[] = $row['parentId'];
					}
					foreach($arParentId as $k=>$v)
						if (!in_array($v,$arId))
							$arNotParentId[] = $v;
				}

				$arId = array();
				
				foreach($moduleData as $row)
				{
					if ($module->mIsTree && in_array($row['parentId'],$arNotParentId) && $row['parentId'])
						continue;
					
					if (isset($module->searchFeatures['index']) && isset($row[$module->searchFeatures['index']]))
						$id = $row[$module->searchFeatures['index']];

					elseif (isset($module->searchFeatures['index']))
						$id = '';

					else
						$id = $row['id001'];

					if (isset($module->searchFeatures['index2']) && isset($row[$module->searchFeatures['index2']]))
						$id2 = $row[$module->searchFeatures['index2']];

					else
						$id2 = '';			

					if (isset($module->searchFeatures['bsuff']))
						$suffixNew = $id2.$module->searchFeatures['bsuff'].$id.$module->searchFeatures['suff'];

					else
						$suffixNew = $id.$module->searchFeatures['suff'];

					foreach($arModuleMemos as $key)
						if (!isset($row[$key]) && file_exists($module->krnl->pathWWW.$key."/".$row['id001'].$this->textExtension)) 
							$row[$key] = implode(" ", file($module->krnl->pathWWW.$key."/".$row['id001'].$this->textExtension));
						else
							$row[$key] = '';
				
					$url = $row['id001'].'__'.$module->searchFeatures['pref'].$suffixNew;
					
					$name = $row[$module->searchFeatures['name']];
					$description = $row[$module->searchFeatures['description']];
					$topic = $module->moduleCaption;
					$data = implode(" ", $row);
					$this->fAddRecord($url,$data,$topic,$nick,$name,$description);
					$arId[] = $row['id001'];
				}				
				
				return $arId;
			}
			else
				return 0;
	}
	
	function fSearch($searchQuery) 
	{
		$searchQuery = strip_tags(str_replace(array("'","`"),array("",""),$searchQuery));
		$srchType = 'По всему сайту';
		$xml = '<mess>Ваш запрос неверен. В запросе необходимо использовать слова длиною от 3 и более символов латинского, русского алфавитов.</mess>';

		if ($searchQuery!='' && preg_match("/[\-\_0-9A-Za-zА-Яа-я]+/",$searchQuery))
		{
			if ($this->searchRule)
			{
				preg_match_all("/[\-\_0-9A-Za-zА-Яа-я]+/", htmlspecialchars($searchQuery),$regs);
			
				$queryTerms = array();
				$search = $regs[0];
				$count = 0;
				
				foreach($search as $token)
				{
					$token = preg_replace("/\W\-/","",$token);
					if (strlen($token) > 2)
						$queryTerms[$count++] = "(keywords like '%".$token."%')";
				}

				$search = implode(' ', $search);
				$queryTerms = implode(' OR ',$queryTerms);
			}
			else
			{
				$count = 1;
				$queryTerms = "keywords like '%".htmlspecialchars($searchQuery)."%'";
			}
			
			if ($count) 
			{
				if (!empty($_GET['srchtype']))
				{
					if ($_GET['srchtype']=='ctl') { $srchType = 'По продукции'; $queryTerms .= " AND (topic = 'продукция' OR topic = 'каталог продукции') "; }
					elseif ($_GET['srchtype']=='news') { $srchType = 'По новостям'; $queryTerms .= " AND topic = 'новости' "; }
					elseif ($_GET['srchtype']=='art') { $srchType = 'По документации'; $queryTerms .= " AND topic = 'документация' "; }
				}						
				
				$this->krnl->dbQuery = "SELECT COUNT(id) as cnt FROM ".$this->tableName." WHERE ".$queryTerms;
				$this->krnl->fDbExecute();
				$row = $this->krnl->fDbGetRow();
				$countRows = $row['cnt'];
					
					if ($countRows) 
					{
						$beginRows = $this->messagesOnPage * ($this->krnl->pagenum - 1);
						$this->queryFields = array('id', 'name', 'description', 'topic', 'adddate');
						$this->queryTerms = 'WHERE '.$queryTerms.' ORDER BY adddate DESC LIMIT '.$beginRows.', '.$this->messagesOnPage;

							if ($this->fList())
							{
								foreach($this->moduleData as $row)
								{
									$date = explode('-',$row['adddate']);
									
									$pos = (int)strpos($row['id'],'__');
										if($pos) $pos += 2;

									$xml .= '<item> <href>'.substr($row['id'],$pos).'</href> <topic><![CDATA['.$row['topic'].']]></topic> <name><![CDATA['.$row['name'].']]></name> <description><![CDATA['.$row['description'].']]></description> <date>'.$date[2].'.'.$date[1].'.'.$date[0].'</date> </item>';
								}

								$countPref = 'найдено';
								if($countRows==1)
								{
									$countPref = 'найдена';
									$countSuff = 'ссылка';
								}
								elseif ($countRows>4)
									$countSuff = 'ссылок';
								else
									$countSuff = 'ссылки';

								$xml .=	'<query><![CDATA['.str_replace("\\","",$searchQuery).']]></query><count><![CDATA['.$countPref.' <b>'.$countRows.'</b> '.$countSuff.']]></count> <srchtype>'.$srchType.'</srchtype> <beginrows>'.$beginRows.'</beginrows> '.$this->fPageNavigation($this->krnl->pagenum,$countRows);
							}
					}
					else
						$xml = '<mess><![CDATA[По Вашему запросу <strong>'.str_replace("\\","",$searchQuery).'</strong> не найдено ни одной записи. Возможно, Вам необходимо упростить или переформулировать запрос.<p>В запросе поиска участвуют только слова, длина которых превышает 2 символа. Также можно использовать не полное слово, а только его чаcть.]]></mess>';
			}
		}
		
		return fXmlTransform($xml,'search');
	}
}
?>