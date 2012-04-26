<?
class cBonusFoto extends cModule
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
		
		$this->tableName = 'bonusfoto';
		$this->moduleCaption = 'фото';
		
		$this->moduleAttaches['i_bonus'] = $this->krnl->imageAttaches;
		$this->moduleAttaches['i_bonus']['mod'] = array(array('crop','b_','568','288'),array('crop','','548','273'),array('crop','m_','212','110'),array('crop','s_','42','42'),array('crop','sq_','273','273'));
		
		$this->itemFormItems['name'] = array('caption' => 'Наименование');
		$this->itemFormItems['i_bonus'] = $this->krnl->imageFormItems;
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => 'Активно');
	}

	function fGatherData($row,$prefix='')
	{
		$xml = '';
		$img = $this->fGetFile($row['fid'],'i_bonus',$row['i_bonus']);
		if ($prefix!='') $img = $this->fPrefixImage($img,$prefix);
		if ($img!='') $xml .= '
<foto id="'.$row['fid'].'"> 
	<name><![CDATA['.$this->fText4Script($row['fname']).']]></name> 
	<img>'.$img.'</img> 
</foto>';
		return $xml;
	}
}

class cBonusComm extends cModule
{
	function fInitialSettings()
	{
		parent::fInitialSettings();
		$this->mOrderField = true;
		$this->mActiveField = true;
		$this->mOnSearch = true;
		return 1;
	}

	function fCreateModule()
	{
		parent::fCreateModule();

		$this->tableName = 'bonuscomm';
		$this->moduleCaption = 'комментарий';
		
		$this->searchFeatures = array('fields'=>array('name','comment','answer'), 'description'=>'comment', 'name'=>'name', 'index'=>'ownerId', 'pref'=>'bonus', 'index'=>'ownerId', 'suff'=>'.html');		
		
		$this->moduleFields['userId'] = array('type' => 'INT', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['adddate'] = array('type' => 'TIMESTAMP', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['comment'] = array('type' => 'TEXT', 'max'=>4096, 'attr' => 'NOT NULL');
		$this->moduleFields['answer'] = array('type' => 'TEXT', 'max'=>4096, 'attr' => "NOT NULL DEFAULT ''");
		$this->moduleFields['adminview'] = array('type' => 'BOOL', 'attr' => 'NOT NULL DEFAULT 0','key'=>1);
		
		$this->orderAzoneField = 'adddate DESC';
		$this->listAzoneFields = array('userId');
		
		$this->itemFormItems['comment'] = array('type' => 'textarea', 'caption' => 'комментарий');
		$this->itemFormItems['answer'] = array('type' => 'textarea', 'caption' => 'ответ');
		$this->itemFormItems['adddate'] = array('type' => 'timestamp', 'caption' => 'Дата подачи');		
		$this->itemFormItems['userId'] = array('type' => 'text', 'caption' => 'Логин пользователя');
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => 'Активна');
	}
	
	function fDisplay()
	{
		if ($this->krnl->fCheckAuth()) $xml = $this->fAddComment();
		else $xml = '<ok/> <er/>';
		
		$this->queryFields = array('t1.id','t1.comment','t1.answer',"DATE_FORMAT(t1.adddate,'%Y') as y","DATE_FORMAT(t1.adddate,'%c') as c","DATE_FORMAT(t1.adddate,'%d') as d","DATE_FORMAT(t1.adddate,'%H:%i') as t",'t2.name as userName','t2.sname as userSName');
		$this->queryTerms = 't1, '.$this->krnl->dbPref.'users t2 WHERE t2.id=t1.userId AND t1.active=1 AND t1.ownerId='.$this->owner->id.' ORDER BY t1.adddate';
		if ($this->fList(0))
			foreach ($this->moduleData as $row)
				$xml .= '
<comment id="'.$row['id'].'"> 
	<comment><![CDATA['.$row['comment'].']]></comment> 
	<answer><![CDATA['.$row['answer'].']]></answer>
	<userName><![CDATA['.$row['userName'].' '.$row['userSName'].']]></userName> 
	<date>'.$row['d'].' '.$this->krnl->arMonthNameBias[$row['c']].'</date> 
</comment>';

		return $xml;
	}
	
	function fAddComment()
	{
		$xml = '<ok/> <er/>';
		if (isset($_POST['addcomm']) && $_POST['addcomm']=='Комментировать' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER'])) $data = $this->fStripSlashes($_POST);
		else $data['comment'] = '';
	
		if (trim($data['comment'])=='Введите комментарий') $data['comment'] = '';
	
		$this->form = array();
		$this->form['_*features*_'] = array('name'=>'сomment','action'=>'#form');
		$this->form['comment'] = array('claim'=>1,'type'=>'textarea','caption'=>'Введите комментарий','rows'=>4,'value'=>$data['comment'],'mask'=>array('name'=>'text','max'=>4096));
		$this->form['secret_code'] = array('claim'=>1,'type'=>'secret','caption'=>'Введите код','mask'=>array('name'=>'secret'));
		$this->form['addcomm'] = array('type'=>'submit','value'=>'Комментировать');
		
		if (isset($_POST['addcomm']) && $_POST['addcomm']=='Комментировать' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER']))
		{
			list($error,$data) = $this->fFormCheck($data);
			if($error=='')
			{
				$this->fieldsData['comment'] = $data['comment'];
				$this->fieldsData['adddate'] = date('Y-m-d-G-i-s');
				$this->fieldsData['userId'] = $this->krnl->userId;
				$this->fieldsData['answer'] = '';
				$this->fieldsData['active'] = 1;
				$this->fieldsData['ownerId'] = $this->ownerId = $this->owner->id;
				
				if ($this->fAddItem())
				{
					$this->form['comment']['value'] = '';
					if ($this->krnl->email!='')
						$this->fSendMail(
							'dq15@mail.ru, mackarr@inbox.ru',
							'Комментирование акции на '.$this->krnl->domainName,
							'<p>Пользователь "'.$this->krnl->userEmail.' ('.$this->krnl->userId.')" прокомментировал акцию #'.$this->owner->id.' на '.$this->krnl->domainName.'</p><p>Текст комментария:</p> <blockquote>'.$data['comment'].'</blockquote> <p><a href="'.$this->krnl->domainName.'bonus'.$this->owner->id.'.html">Перейти к комментарию</a></p>');
							
					$xml = '<ok>1</ok> <er/>';
				}
				else $xml = '<ok/> <er><![CDATA[Произошла ошибка при добавлении комментария. '.$this->krnl->toAdm.']]></er>';
			}
			else $xml = '<ok/> '.$error;
		}
		return $xml.$this->fForm2Xml();
	}
}

class cBonusOffer extends cModule
{
	function fInitialSettings()
	{
		parent::fInitialSettings();
		$this->mOrderField = true;
		$this->mActiveField = true;
		$this->mOnSearch = true;
		return 1;
	}

	function fCreateModule()
	{
		parent::fCreateModule();

		$this->tableName = 'bonusoffer';
		$this->moduleCaption = 'предложения';
		
		$this->searchFeatures = array('fields'=>array('name','descr'), 'description'=>'descr', 'name'=>'name', 'index'=>'ownerId', 'pref'=>'bonus', 'index'=>'ownerId', 'suff'=>'.html');
		
		$this->moduleFields['bprice'] = array('type' => 'DECIMAL(10,2)', 'attr' => 'NOT NULL DEFAULT 0','min'=>1);
		$this->moduleFields['eprice'] = array('type' => 'DECIMAL(10,2)', 'attr' => 'NOT NULL DEFAULT 0','min'=>1);
		$this->moduleFields['percent'] = array('type' => 'VARCHAR', 'width' => 127, 'attr' => "NOT NULL DEFAULT ''", 'comment'=>'Ввобдить в случае со скидочными купонами.');
		$this->moduleFields['percentbonus'] = array('type' => 'DECIMAL(10,2)', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['descr'] = array('type' => 'TEXT', 'max'=>4096, 'attr' => 'NOT NULL');

		$this->itemFormItems['name'] = array('type' => 'textarea', 'rows'=>3,'caption' => 'Предложение');
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => 'Активно');
		$this->itemFormItems['bprice'] = array('type' => 'text', 'caption' => 'Цена без скидки, руб.','comment'=>'В случае если купон предоставляет только скидку, значение должно быть равно значению поля <b>Цена со скидкой, руб.</b>');
		$this->itemFormItems['eprice'] = array('type' => 'text', 'caption' => 'Цена со скидкой, руб.','comment'=>'В случае если купон предоставляет только скидку, значение должно быть равно значению поля <b>Цена без скидки, руб.</b>');
		$this->itemFormItems['percent'] = array('type' => 'text', 'caption' => 'Комментарий','comment'=>'Заполнять в случае если купон предоставляет только скидку.<br/>Пример: <b>Скидка с купоном 50%</b>');
		$this->itemFormItems['percentbonus'] = array('type' => 'text', 'caption' => 'Процент скидки','comment'=>'Заполнять в случае если купон предоставляет только скидку.<br/>Пример: <b>50</b>');
		$this->itemFormItems['descr'] = array('type' => 'dbmemo', 'caption' => 'Детальная информация', 'editor'=>'Small', 'width'=>490,'height'=>200, 'max' => 20000);
	}
}

class cBonus extends cModule
{
	var $city;
	var $interest = array();

	function fInitialSettings()
	{
		parent::fInitialSettings();
		$this->mOrderField = true;
		$this->mActiveField = true;
		$this->mOnSearch = true;
		return 1;
	}

	function fCreateModule()
	{
		parent::fCreateModule();

		$this->tableName = 'bonus';
		$this->moduleCaption = 'акции';
		
		$this->searchFeatures = array('fields'=>array('name','m_contacts','m_clause','m_special','m_bonus'), 'description'=>'m_bonus', 'name'=>'name', 'pref'=>'bonus', 'suff'=>'.html');
		
		$this->moduleFields['bdate'] = array('type' => 'DATE', 'attr' => 'NOT NULL','min'=>1);
		$this->moduleFields['edate'] = array('type' => 'DATE', 'attr' => 'NOT NULL','min'=>1);
		$this->moduleFields['ldate'] = array('type' => 'DATE', 'attr' => 'NOT NULL','min'=>1);
		$this->moduleFields['contractdate'] = array('type' => 'DATE', 'attr' => 'NOT NULL','min'=>1);
		$this->moduleFields['address'] = array('type' => 'TEXT', 'attr' => 'NOT NULL');
		$this->moduleFields['name_short'] = array('type' => 'VARCHAR', 'attr' => 'NOT NULL DEFAULT 0','min'=>1);
		$this->moduleFields['name_shortest'] = array('type' => 'VARCHAR', 'attr' => 'NOT NULL DEFAULT 0','min'=>1);
		$this->moduleFields['firmId'] = array('type' => 'INT','attr' => 'NOT NULL DEFAULT 0','min'=>1);
		$this->moduleFields['catId'] = array('type' => 'INT','attr' => 'NOT NULL DEFAULT 0','min'=>1);
		
		$this->moduleMemos['m_bonus'] = array('max'=>20000);
		$this->moduleMemos['m_clause'] = array('max'=>20000);
		$this->moduleMemos['m_special'] = array('max'=>20000);
		$this->moduleMemos['m_contacts'] = array('max'=>20000);

		$this->orderAzoneField = 'active DESC, orderIndex DESC';
		$this->listAzoneFields = array('id','name');
		$this->listAzoneFieldsSpacer = 1;
		
		$this->itemFormItems['name'] = array('type' => 'textarea', 'rows'=>3,'caption' => 'Акция');
		$this->itemFormItems['name_short'] = array('type' => 'text', 'caption' => 'Краткое название', 'comment'=>'Короткое название акции для e-mail рассылок');
		$this->itemFormItems['name_shortest'] = array('type' => 'text', 'caption' => 'Минимальное название', 'comment'=>'Название для заголовков e-mail рассылок. Не более 3-4 слов.');
		
		$this->itemFormItems['firmId'] = array('type' => 'list', 'listname'=>'firm', 'caption' => 'Компания');
		$this->itemFormItems['catId'] = array('type' => 'list', 'listname'=>'cat', 'caption' => 'Категория');
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => 'Активна');
		$this->itemFormItems['bdate'] = array('type' => 'timestamp', 'caption' => 'Начало продаж');
		$this->itemFormItems['edate'] = array('type' => 'timestamp', 'caption' => 'Конец продаж');
		$this->itemFormItems['ldate'] = array('type' => 'timestamp', 'caption' => 'Акция действует до');
		$this->itemFormItems['contractdate'] = array('type' => 'timestamp', 'caption' => 'Дата подписания договора');
		$this->itemFormItems['m_contacts'] = array('type' => 'memo', 'caption' => 'Контакты', 'editor'=>'Small', 'width'=>490,'height'=>200, 'max' => 20000);
		$this->itemFormItems['address'] = array('type' => 'textarea', 'caption' => 'Адреса','comment'=>'Каждый адрес в новой строке');	
		$this->itemFormItems['m_bonus'] = array('type' => 'memo', 'caption' => 'Описание', 'height'=>400, 'max' => 20000);		
		$this->itemFormItems['m_clause'] = array('type' => 'memo', 'caption' => 'Условия', 'editor'=>'Small', 'width'=>490,'height'=>200, 'max' => 20000);
		$this->itemFormItems['m_special'] = array('type' => 'memo', 'caption' => 'Особенности', 'editor'=>'Small', 'width'=>490,'height'=>200, 'max' => 20000);

		$this->fCreateChild('bonusoffer');
		$this->fCreateChild('bonuscomm');
		$this->fCreateChild('bonusfoto');	
		
	}	
	
	function fGetList() 
	{
		if ($this->listName == 'firm') 
		{
			$this->moduleData = array();
			$this->krnl->dbQuery = 'SELECT id, name FROM '.$this->krnl->dbPref.'firms ORDER BY name';
			$this->moduleData[0] = '---';
			if($this->krnl->fDbExecute())
				while($row = $this->krnl->fDbGetRow())
					$this->moduleData[$row['id']] = $row['name'];
			return 1;
		}
		if ($this->listName == 'cat') 
		{
			$this->moduleData = array();
			$this->krnl->dbQuery = 'SELECT id, name FROM '.$this->krnl->dbPref.'cat ORDER BY name';
			$this->moduleData[0] = '---';
			if($this->krnl->fDbExecute())
				while($row = $this->krnl->fDbGetRow())
					$this->moduleData[$row['id']] = $row['name'];
			return 1;
		}
		else 
			return parent::fGetList();
	}
	
	function fDisplayXml()
	{
		$cBonusOffer = &$this->childsClass['bonusoffer'];
		$path = $xml = '';
		$id = $offerId = $fotoId = $min = $max = $maxDiscount = $offer = 0;
		$cBonusFoto = &$this->childsClass['bonusfoto'];
		
		$this->queryFields = array("t2.id as id","t2.name as name","t2.percentbonus","t1.id as url","t4.name as region","DATE_FORMAT(t1.bdate,'%Y.%m.%dT00:00:00') as beginsell","DATE_FORMAT(t1.edate,'%Y.%m.%dT00:00:00') as endsell","DATE_FORMAT(t1.ldate,'%Y.%m.%dT00:00:00') as endvalid","t3.id as picture", "t3.i_bonus as picformat","t2.bprice as price","t2.eprice as discountprice","CONCAT(t5.type,' ',t5.name) as firmname","t5.url as firmurl","t5.phone as firmtel","t5.address as firmaddresses");
		
		$this->queryTerms = "t1 LEFT JOIN bmous_city t4 ON t4.id = t1.ownerId LEFT JOIN bmous_firms t5 ON t5.id = t1.firmId LEFT JOIN bmous_bonusfoto t3 ON t3.ownerId = t1.id, bmous_bonusoffer t2 WHERE t1.active=1 AND t2.ownerId=t1.id AND t2.active=1 AND DATE_FORMAT(t1.edate,'%Y-%m-%d')>='2012-04-18' AND DATE_FORMAT(t1.bdate,'%Y-%m-%d')<='2012-04-18' GROUP BY t2.id ORDER BY t1.bdate";
		
		if ($this->fList(0))
		{
			foreach($this->moduleData as $row)
			{
				// текстовое описание
				$fileName = $this->krnl->pathWWW.'m_bonus/'.$row['url'].'.art';
				if (file_exists($fileName))
				{
					$name = $this->fWin1251ToUtf8($row['name']);
					$firmname = $this->fWin1251ToUtf8($row['firmname']);
					
					if($row['firmurl'] != '')
						$firmurl = '<url>'.$row['firmurl'].'</url>';
					else $firmurl = '';
					
					$string = file_get_contents($fileName);
					$text = $this->fWin1251ToUtf8(implode(array_slice(explode('<BREAK>',wordwrap(preg_replace("/&#?[a-z0-9]{2,8};/i", "", strip_tags($string)),250,'<BREAK>',false)),0,1)).'..');
				}
				// фотографии
				$exts = array(0=>'jpg',1=>'gif',2=>'png');
				$img = '';
				$fotoPath = 'i_bonus/'.$row['picture'].'.'.$exts[$row['picformat']];
				if (file_exists($this->krnl->pathWWW.$fotoPath))
					$img = $this->krnl->domainName.$fotoPath;
				// расчет стоимостей
				if($row['price'] == $row['discountprice'])
				{
					$pricecoupon = $price;
					$discount = $row['percentbonus'];
					$price = 0;
					$discountprice = 0;
				}
				else
				{
					$pricecoupon = 0;
					$discount = $row['discountprice']/$row['price']*100;
					$price = $row['price'];
					$discountprice = $row['discountprice'];
				}
				// телефон
				if ($row['firmtel']!='')
				{
					$tel = explode("\r\n",$row['firmtel']);
					$telephone = '<tel>'.$tel[0].'</tel>';
				}
				else $telephone = '';
				// адреса
				$address='';
				if ($row['firmaddresses']!='')
				{
					$addressES = explode("\r\n",$row['firmaddresses']);
					if ($addressES[0]!='')
						foreach($addressES as $k=>$v)
							$address.='<address><name>'.$v.'</name></address>';
						$address='<addresses>'.$address.'</addresses>';
				}
				else $address='';
				$xml.='
		<offer>
			<id>'.$row['id'].'</id><name>'.$name.'</name><url>'.$this->krnl->domainName.'bonus'.$row['url'].'.html</url><discription>'.$text.'</discription><region>'.$row['region'].'</region><beginsell>'.$row['beginsell'].'</beginsell><endsell>'.$row['endsell'].'</endsell><beginvalid>'.$row['beginsell'].'</beginvalid><endvalid>'.$row['endvalid'].'</endvalid><picture>'.$img.'</picture><price>'.(int)$price.'</price><discount>'.(int)$discount.'</discount><discountprice>'.(int)$discountprice.'</discountprice><pricecoupon>'.(int)$pricecoupon.'</pricecoupon><supplier><name>'.$firmname.'</name>'.$firmurl.$telephone.$address.'</supplier>
		</offer>';
			}
		}
		return '
<discounts>
	<operator> 
		<name>BonusMouse.ru</name>
		<url>http://bonusmouse.ru/</url>
		<logo>http://bonusmouse.ru/</logo>
		<logo264>http://bonusmouse.ru/</logo264>
		<logo88>http://bonusmouse.ru/</logo88>
		<logo16>http://bonusmouse.ru/im/metro/favicon.png</logo16>
	</operator>
	<offers>'.$xml.'
	</offers>
</discounts>';
	}
	
	function fDisplay($catId='')
	{
		$cBonusOffer = &$this->childsClass['bonusoffer'];
		$path = $xml = '';
		if (isset($_REQUEST['bonusId']) && (int)$_REQUEST['bonusId'])
		{
			$cBonusComm = &$this->childsClass['bonuscomm']; 
			$this->id = $cBonusComm->owner->id = (int)$_REQUEST['bonusId'];
			
			$this->krnl->dbQuery = 'SELECT count(id) as cnt FROM '.$this->krnl->dbPref.'usersinterest WHERE bonusId='.$this->id;				
			if ($this->krnl->fDbExecute() && $this->krnl->fDbNumRows())
			{
				$row = $this->krnl->fDbGetRow();
				$this->interest[$this->id] = $row['cnt'];
			}
			else $this->interest[$this->id] = 0;
			
			$userId = 0;
			if(isset($this->krnl->userId))
				$userId = $this->krnl->userId;
			
			$this->queryFields = array('t1.*','t4.name as catname',"DATE_FORMAT(t1.edate,'%Y') as y","DATE_FORMAT(t1.edate,'%c') as c","DATE_FORMAT(t1.edate,'%m') as m","DATE_FORMAT(t1.edate,'%d') as d","DATE_FORMAT(t1.ldate,'%Y') as ly","DATE_FORMAT(t1.ldate,'%c') as lc","DATE_FORMAT(t1.ldate,'%d') as ld",'t2.id as offerId','t2.name as offerName','t2.percent','t2.bprice','t2.eprice','t2.descr','count(t3.id) as paid');
			$this->queryTerms = "t1 LEFT JOIN ".$this->krnl->dbPref."cat t4 ON t4.id=t1.catId, ".$cBonusOffer->tableName." t2 LEFT JOIN ".$this->krnl->dbPref."usersoffer t3 ON t3.offerId=t2.id AND t3.paid=1 WHERE t1.active=1 AND t2.ownerId=t1.id AND t2.active=1 AND t1.id='".$this->id."' GROUP BY t2.id ORDER BY t2.orderIndex";
			
			if ($this->fList(0)) 
			{ 
				$this->fGetFoto();
				$xml = $this->fGatherData().$cBonusComm->fDisplay();
				// Заполнение заинтересовавшими бонусами
				if ($this->krnl->fCheckAuth())
				{
					$this->krnl->dbQuery = 'SELECT id FROM '.$this->krnl->dbPref.'usersinterest WHERE ownerId='.$this->krnl->userId.' AND bonusId='.$this->id;				
					if ($this->krnl->fDbExecute() && !$this->krnl->fDbNumRows())
					{
						$this->krnl->dbQuery = 'SELECT count(id) as cnt, min(id) as id FROM '.$this->krnl->dbPref.'usersinterest WHERE ownerId='.$this->krnl->userId;
						if ($this->krnl->fDbExecute())
						{
							$row = $this->krnl->fDbGetRow();
							if ($row['cnt']>2)
							{
								$this->krnl->dbQuery = 'DELETE FROM '.$this->krnl->dbPref.'usersinterest WHERE id='.$row['id'];
								$this->krnl->fDbExecute();
							}
						}					
						$this->krnl->dbQuery = 'INSERT '.$this->krnl->dbPref.'usersinterest SET bonusId='.$this->id.', ownerId='.$this->krnl->userId;
						$this->krnl->fDbExecute();
					}
				}
			}
			$xsl = 'bonusitem';
		}
		elseif (isset($_REQUEST['bonusId']) && $_REQUEST['bonusId']=='arch')
		{
			$tree = $this->fMap();
			$xml = '<menu>'.(isset($tree['bonus'])?$this->fOutTree($tree['bonus'],$tree):'').'</menu>'.$this->fDisplayArchive();
			$xsl = 'bonusarch';
		}
		else
		{
			// Вывод акций по городам
			$city = $cityId = $cat = '';
			if(isset($_REQUEST['city']) && (int)$_REQUEST['city']) $cityId = $_REQUEST['city'];
			elseif(isset($_SESSION['city']) && (int)$_SESSION['city']) $cityId = $_SESSION['city'];
			
			else $cityId = 3345; // 4400 - Москва 3345 - Уфа
			
			if($cityId != '')
				$city = '(t1.ownerId = '.$cityId.' OR t1.ownerId = "4400" ) AND ';
			
			$this->queryFields = array('t1.*',"DATE_FORMAT(t1.edate,'%Y') as y","DATE_FORMAT(t1.edate,'%c') as c","DATE_FORMAT(t1.edate,'%m') as m","DATE_FORMAT(t1.edate,'%d') as d",'t2.id as offerId','t2.percent','t2.bprice','t2.eprice','count(t3.id) as paid');
			$this->queryTerms = "t1, ".$cBonusOffer->tableName." t2 LEFT JOIN ".$this->krnl->dbPref."usersoffer t3 ON t3.offerId=t2.id AND t3.paid=1 WHERE ".$city.$catId." t1.active=1 AND t2.ownerId=t1.id AND t2.active=1 AND DATE_FORMAT(t1.edate,'%Y-%m-%d')>='".date('Y-m-d')."' AND DATE_FORMAT(t1.bdate,'%Y-%m-%d')<='".date('Y-m-d')."' GROUP BY t2.id ORDER BY t1.ownerId DESC, t1.orderIndex DESC, t2.orderIndex";
			if ($this->fList(0)) { $this->fGetFoto(); $xml .= $this->fGatherData(0); }
			$xsl = 'bonuslist';
		}
		return array($xml,$xsl,$path);
	}
	
	function fDisplayPrint()
	{
		$xml = '';
		$cBonusOffer = &$this->childsClass['bonusoffer'];		
		if (isset($_REQUEST['offerId']) && (int)$_REQUEST['offerId'] && $this->krnl->fCheckAuth())
		{
			$this->id = (int)$_REQUEST['offerId'];
			$ownerId = (int)$this->krnl->userId;
			// Доступ проверка друга			
			$this->krnl->dbQuery = 'SELECT ownerId FROM '.$this->krnl->dbPref.'usersoffer WHERE id='.$_REQUEST['offerId'].' AND favourfriend="'.$this->krnl->userEmail.'"';
			if ($this->krnl->fDbExecute()&& $this->krnl->fDbNumRows()>0) list($ownerId) = $this->krnl->fDbGetRow(MYSQL_NUM);			
			// --------------
			
			$this->queryFields = array('t1.*',"DATE_FORMAT(t1.edate,'%Y') as y","DATE_FORMAT(t1.edate,'%c') as c","DATE_FORMAT(t1.edate,'%m') as m","DATE_FORMAT(t1.edate,'%d') as d","DATE_FORMAT(t1.ldate,'%Y') as ly","DATE_FORMAT(t1.ldate,'%c') as lc","DATE_FORMAT(t1.ldate,'%d') as ld",'t2.id as offerId','t2.name as offerName','t2.bprice','t2.eprice','t2.descr', 't2.percent', 't3.id as firstId','t1.firmId as secondId','t3.cnt','t3.cost','t4.usedate');
			$this->queryTerms = "t1, ".$cBonusOffer->tableName." t2, ".$this->krnl->dbPref."usersoffer t3 LEFT JOIN ".$this->krnl->dbPref."usersused t4 on t4.ownerId=t3.id WHERE t1.active=1 AND t2.ownerId=t1.id AND t2.active=1 AND t3.id='".$this->id."' AND t3.offerId=t2.id AND t3.paid=1 AND t3.ownerId=".$ownerId;
			
			
			if ($this->fList(0) && $this->moduleData[0]['usedate']=='')
			{
				$min = $this->moduleData[0]['cost'];
				$xml = $this->fGatherData().'<firstId>'.$this->moduleData[0]['firstId'].'</firstId> <secondId>'.sprintf("%05d",$this->moduleData[0]['secondId']).'</secondId> <cnt>'.$this->moduleData[0]['cnt'].'</cnt> <cost copeck="'.substr($min,strpos($min,'.')+1).'">'.(int)$min.'</cost> <cost2>'.(int)$this->moduleData[0]['cnt']*$this->moduleData[0]['bprice'].'</cost2>';
			}
			else $this->krnl->page404 = 1;
		}
		// echo htmlspecialchars($xml);
		return $xml;
	}
	
	function fGetFoto($field='id')
	{
		$id = $arId = 0;
		$arData = array();
		
		foreach ($this->moduleData as $row) 
			if ($id!=$row[$field]) 
			{ 
				$arId .= ','.$row[$field]; 
				$id = $row[$field]; 
			}		
		
		$cBonusFoto = &$this->childsClass['bonusfoto'];
		$cBonusFoto->queryFields = array('*');
		$cBonusFoto->queryTerms = 'WHERE active=1 AND ownerId IN ('.$arId.') ORDER BY ownerId, orderIndex';
		if ($cBonusFoto->fList(0)) 
			foreach($cBonusFoto->moduleData as $row) 
				$arData[$row['ownerId']][] = array($row['id'],$row['i_bonus']);
				
		$cBonusFoto->moduleData = $arData;
		return 1;
	}
	
	function fGatherData($item=1,$subscr=0)	
	{
		if (isset($_POST['authsend']) && $_POST['authsend']=='Вход' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER'])) $xml = '<authsend>1</authsend>';
		else $xml = '<authsend>0</authsend>';
		$interest = 0;
		$id = $offerId = $fotoId = $min = $max = $maxDiscount = $offer = 0;
		$cBonusFoto = &$this->childsClass['bonusfoto'];
		
		foreach($this->moduleData as $row)
		
		
			if ($row['eprice'])
			{
				if ($id!=$row['id'])
				{
					if(!empty($this->interest[$row['id']])) $interest = $this->interest[$row['id']];
					else $interest = 0;
					if ($id) $xml .= '<paidUsers>'.$paidUsers.'</paidUsers> <interest>'.$interest.'</interest> <min copeck="'.substr($min,strpos($min,'.')+1).'"><![CDATA['.(int)$min.']]></min> <max ><![CDATA['.(int)$max.']]></max> <discount><![CDATA['.$maxDiscount.']]></discount> </item>'; 
					$xml .= '<item id="'.$row['id'].'"> <name name="'.$this->fWin1251ToUtf8($this->fText4Script($row['name'])).'"><![CDATA['.$this->fText4Script($row['name']).']]></name> <date><![CDATA['.$row['d'].' <span>'.$this->krnl->arMonthNameBias[$row['c']].'</span>]]></date> <sysdate><year>'.$row['y'].'</year><month>'.date('m').'</month><day>'.date('d').'</day></sysdate> <percent small="'.((strlen($row['percent'])>20)?'1':'2').'"><![CDATA['.$row['percent'].']]></percent> <cat>'.$row['catname'].'</cat>';
					
					if(!isset($row['address'])) $row['address'] = '';
					$arAddr = explode('<br />',nl2br($row['address']));
					foreach($arAddr as $k=>$v) $xml .= '<address><![CDATA['.ltrim($v).']]></address>';
					
					if ($item)
					{
						$active = 1;
						if ($row['y'].'-'.$row['m'].'-'.$row['d'] < date('Y-m-d')) $active = 0;
						
						// ПРОВЕРКА НА ТО ЧТО ЕСЛИ КУПИЛ ОДИН РАЗ БОЛЬШЕ НЕ ПОКУПАЛ
						/* if ($active && !empty($this->krnl->userId))
						{
							$this->krnl->dbQuery = 'SELECT id FROM '.$this->krnl->dbPref.'usersoffer WHERE paid=1 AND bonusId='.$row['id'].' AND ownerId='.(int)$this->krnl->userId;
							if ($this->krnl->fDbExecute() && $this->krnl->fDbNumRows()>0) $active = 0;
						} */
						$xml .= '<active>'.$active.'</active>';
					
						foreach($this->moduleMemos as $k=>$v) 
						{
							$fileName = $this->krnl->pathWWW.$k.'/'.$row['id'].'.art'; 
							if (file_exists($fileName)) $xml .= '<'.$k.'><![CDATA['.file_get_contents($fileName).']]></'.$k.'>';
							else $xml .= '<'.$k.'/>'; 
						}
						if (isset($cBonusFoto->moduleData[$row['id']]) && count($cBonusFoto->moduleData[$row['id']]))
							foreach($cBonusFoto->moduleData[$row['id']] as $rowFoto)
							{
								$fotoPath = $cBonusFoto->fGetFile($rowFoto[0],'i_bonus',$rowFoto[1]);
								$xml .= '<img>'.$this->fPrefixImage($fotoPath,'b_').'</img>'; 
							}
					}
					elseif (isset($cBonusFoto->moduleData[$row['id']]) && count($cBonusFoto->moduleData[$row['id']])) 
					{ 
						$fotoPath = $cBonusFoto->fGetFile($cBonusFoto->moduleData[$row['id']][0][0],'i_bonus',$cBonusFoto->moduleData[$row['id']][0][1]); 
						if ($subscr)
							$xml .= '<img>'.$this->fPrefixImage($fotoPath,'').'</img> <imgs>'.$this->fPrefixImage($fotoPath,'s_').'</imgs>';
						else
							$xml .= '<img>'.$fotoPath.'</img> <imgm>'.$this->fPrefixImage($fotoPath,'m_').'</imgm>'; 
					}

					$id = $row['id'];
					$min = $row['eprice'];
					$max = $row['bprice'];
					$paidUsers = 0;
					$maxDiscount = 100-ceil($row['eprice']/$row['bprice']*100);
				}
				
				if ($offerId!=$row['offerId']) 
				{
					$tempDiscount = 100-ceil($row['eprice']/$row['bprice']*100);
					if ($min > $row['eprice']) $min = $row['eprice'];
					if ($max < $row['bprice']) $max = $row['bprice'];
					if ($maxDiscount < $tempDiscount) $maxDiscount = $tempDiscount;
					if (empty($row['paid'])) $row['paid'] = 0;
					if ($item) 	$xml .= '<offer id="'.$row['offerId'].'" paid="'.$row['paid'].'"> <name><![CDATA['.$row['offerName'].']]></name> <descr><![CDATA['.$row['descr'].']]></descr> <min copeck="'.substr($row['eprice'],strpos($row['eprice'],'.')+1).'"><![CDATA['.(int)$row['eprice'].']]></min> <max><![CDATA['.(int)$row['bprice'].']]></max> <discount><![CDATA['.$tempDiscount.']]></discount> <date>'.$row['ld'].' '.$this->krnl->arMonthNameBias[$row['lc']].' '.$row['ly'].'</date> <percent><![CDATA['.(empty($row['percent'])?'':$row['percent']).']]></percent></offer>';
					else $xml .= '<offer/>';				
					$paidUsers += $row['paid'];
					$offerId = $row['offerId'];
				}
			}
		if ($id) $xml .= '<paidUsers>'.$paidUsers.'</paidUsers> <interest>'.$interest.'</interest> <min copeck="'.substr($min,strpos($min,'.')+1).'"><![CDATA['.(int)$min.']]></min> <max><![CDATA['.(int)$max.']]></max> <discount><![CDATA['.$maxDiscount.']]></discount> </item>';
		// echo htmlspecialchars($xml);
		return $xml;
	}
	
	function fDisplayPay()
	{
		$er = 0;
		$xml = '';
		if (isset($_REQUEST['offerId']) && (int)$_REQUEST['offerId'] && $this->krnl->fCheckAuth())
		{
			/* $this->krnl->dbQuery = 'SELECT id FROM '.$this->krnl->dbPref.'usersoffer WHERE offerId='.$_REQUEST['offerId'].' AND paid=1 AND ownerId='.$this->krnl->userId;
			if ($this->krnl->fDbExecute() && !$this->krnl->fDbNumRows())
			{ */
				$cBonusOffer = &$this->childsClass['bonusoffer'];
				$cBonusOffer->id = (int)$_REQUEST['offerId'];
				$this->queryFields = array("DATE_FORMAT(t1.ldate,'%Y') as ly","DATE_FORMAT(t1.ldate,'%c') as lc","DATE_FORMAT(t1.ldate,'%d') as ld",'t2.*');
				$this->queryTerms = "t1, ".$cBonusOffer->tableName." t2 WHERE t1.active=1 AND t2.ownerId=t1.id AND t2.active=1 AND t2.id=".$cBonusOffer->id." AND DATE_FORMAT(t1.edate,'%Y-%m-%d')>='".date('Y-m-d')."' AND DATE_FORMAT(t1.bdate,'%Y-%m-%d')<='".date('Y-m-d')."'";		
				
				if ($this->fList(0))
				{
					$row = $this->moduleData[0];	
					if ((int)$row['eprice'])
					{	
						$userOfferId = 0;
						$paid = $cntoffer = 1;
						$this->krnl->dbQuery = 'SELECT id, cnt, paid FROM '.$this->krnl->dbPref.'usersoffer WHERE offerId='.$row['id'].' AND bonusId='.$row['ownerId'].' AND ownerId='.(int)$this->krnl->userId.' ORDER BY id DESC LIMIT 1';
						if ($this->krnl->fDbExecute() && $this->krnl->fDbNumRows())
						{
							$row2 = $this->krnl->fDbGetRow();
							$paid = $row2['paid'];
							$cntoffer = $row2['cnt'];
							$userOfferId = $row2['id'];
						}
						
						if ($paid)
						{
							$this->krnl->dbQuery = 'INSERT '.$this->krnl->dbPref.'usersoffer SET id='.time().', offerId='.$row['id'].', bonusId='.$row['ownerId'].', ownerId='.(int)$this->krnl->userId.', paid=0, cnt=1, cost='.(int)$row['eprice'];
							if ($this->krnl->fDbExecute())
							{
								$this->krnl->dbQuery = 'SELECT id FROM '.$this->krnl->dbPref.'usersoffer WHERE offerId='.$row['id'].' AND bonusId='.$row['ownerId'].' AND ownerId='.(int)$this->krnl->userId.' ORDER BY id DESC LIMIT 1';
								if ($this->krnl->fDbExecute() && $this->krnl->fDbNumRows())
								{
									$row2 = $this->krnl->fDbGetRow();
									$userOfferId = $row2['id'];
								}							
								else $er = 6;
							}
							else $er = 5;
						}
						
						if (!$userOfferId) $er = 7;
						
						if (!$er)
						{
							$xml = '
		<pay><![CDATA['.$this->fRbkMoney($this->krnl->shopId,$userOfferId,$row['name'],(int)$cntoffer*$row['eprice'],$this->krnl->userEmail).']]></pay>
		<item id="'.$row['id'].'" ownerId="'.$row['ownerId'].'" cntoffer="'.$cntoffer.'"> 
			<name><![CDATA['.$row['name'].']]></name> 
			<date><![CDATA['.$row['ld'].' '.$this->krnl->arMonthNameBias[$row['lc']].' '.$row['ly'].']]></date>
			<min copeck="'.substr($row['eprice'],strpos($row['eprice'],'.')+1).'"><![CDATA['.(int)$row['eprice'].']]></min>
			<max><![CDATA['.(int)$row['bprice'].']]></max>
			<cost>'.(int)$cntoffer*$row['eprice'].'</cost>
			<discount><![CDATA['.(100-ceil($row['eprice']/$row['bprice']*100)).']]></discount> ';
							
							$cBonusFoto = &$this->childsClass['bonusfoto'];
							$this->fGetFoto('ownerId');
							if (isset($cBonusFoto->moduleData[$row['ownerId']]) && count($cBonusFoto->moduleData[$row['ownerId']])) 
							{ 
								$fotoPath = $cBonusFoto->fGetFile($cBonusFoto->moduleData[$row['ownerId']][0][0],'i_bonus',$cBonusFoto->moduleData[$row['ownerId']][0][1]); 
								$xml .= '<img>'.$this->fPrefixImage($fotoPath,'m_').'</img>'; 
							}
							
							$xml .= '</item>';
						}
					}
					else $er = 4;
				}			
				else $er = 3;
/* 			}
			else $er = 2; */
		}
		else $er = 1;
			
		if ($er)
			$xml = '<er2><![CDATA[Ошибка оплаты №'.$er.'.'.$this->krnl->toAdm.']]></er2>';
		
		return array($xml,'pay');
	}
	
	function fDisplayOffer()
	{
		$xml = '';
		// PAY
		if (isset($_REQUEST['result']) && $_REQUEST['result']=='success')
			$xml = '<coupon> <ok><![CDATA[Ваш платеж успешно принят. Ожидайте начисления платежа в текущем разделе.<br/>Для проверки платажей пользуйтесь сервисом "Проверить платежи"]]></ok> </coupon>';
		elseif (isset($_REQUEST['result']) && $_REQUEST['result']=='fail')
			$xml = '<coupon> <er2><![CDATA[Ошибка оплаты №101. '.$this->krnl->toAdm.']]></er2> </coupon>';
		// END PAY	
	
		$filter = '';
		$filter2 = "AND t1.ldate>='".date('Y-m-d H:i')."'";
		//if (isset($_REQUEST['fl']) && $_REQUEST['fl']=='active') $filter = "AND DATE_FORMAT(t1.ldate,'%Y-%m-%d')>='".date('Y-m-d')."'";
		if (isset($_REQUEST['fl']) && $_REQUEST['fl']=='nopaid') $filter = "AND t3.paid=0";
		if (isset($_REQUEST['fl']) && $_REQUEST['fl']=='ldate') $filter2 = "AND t1.ldate<='".date('Y-m-d H:i')."'";
		
		$cBonusOffer = &$this->childsClass['bonusoffer'];		
		$this->queryFields = array("DATE_FORMAT(t1.edate,'%Y-%m-%d') as edate","DATE_FORMAT(t1.ldate,'%Y') as ly","DATE_FORMAT(t1.ldate,'%c') as lc","DATE_FORMAT(t1.ldate,'%d') as ld", 't1.ldate as ldate','t2.*',"DATE_FORMAT(t3.paydate,'%d.%m.%Y в %H:%i') as paydate",'t3.id as prId','t3.paid','t3.cnt','t4.usedate','t3.favourfriend as sendFriend');
		$this->queryTerms = "t1, ".$cBonusOffer->tableName." t2, ".$this->krnl->dbPref."usersoffer t3 LEFT JOIN ".$this->krnl->dbPref."usersused t4 ON t4.ownerId=t3.id WHERE t1.active=1 AND t2.ownerId=t1.id AND t2.active=1 AND t2.id=t3.offerId AND t3.ownerId=".(int)$this->krnl->userId." ".$filter." ".$filter2." GROUP BY t3.id ORDER BY t3.id DESC";
		
		
		$filte2 = "AND t1.ldate>='".date('Y-m-d H:i')."' '";
		if ($this->fList(0))
		{
			
			$cBonusFoto = &$this->childsClass['bonusfoto'];
			$this->fGetFoto('ownerId');
			
			foreach($this->moduleData as $row)
			{
				if ($row['usedate']=='') // Выводим если не использован
				{
					$xml .= '
			<offer id="'.$row['id'].'" prId="'.$row['prId'].'" ownerId="'.$row['ownerId'].'" paid="'.$row['paid'].'" cnt="'.$row['cnt'].'" used="'.$row['usedate'].'" sendFriend="'.$row['sendFriend'].'" ldate="'.(($row['ldate']<=date('Y-m-d H:i'))?1:0).'"> 
			<name><![CDATA['.$row['name'].']]></name> 
			<date><![CDATA['.$row['ld'].' '.$this->krnl->arMonthNameBias[$row['lc']].' '.$row['ly'].']]></date>
			<paydate><![CDATA['.$row['paydate'].']]></paydate>
			<min copeck="'.substr($row['cnt']*$row['eprice'],strpos($row['cnt']*$row['eprice'],'.')+1).'"><![CDATA['.(int)$row['cnt']*$row['eprice'].']]></min> 
			<max><![CDATA['.(int)$row['cnt']*$row['bprice'].']]></max> 
			<discount><![CDATA['.(100-ceil($row['eprice']/$row['bprice']*100)).']]></discount> ';
			
					if (isset($cBonusFoto->moduleData[$row['ownerId']]) && count($cBonusFoto->moduleData[$row['ownerId']])) 
					{ 
						$fotoPath = $cBonusFoto->fGetFile($cBonusFoto->moduleData[$row['ownerId']][0][0],'i_bonus',$cBonusFoto->moduleData[$row['ownerId']][0][1]); 
						$xml .= '<img>'.$this->fPrefixImage($fotoPath,'m_').'</img>'; 
					}
					$xml .= '</offer>';		
				}
			}
		}
		return $xml;
	}
	
	function fDisplayInterest()
	{
		$xml = '';
		$cBonusOffer = &$this->childsClass['bonusoffer'];
		
		$this->queryFields = array('t1.*',"DATE_FORMAT(t1.edate,'%Y') as y","DATE_FORMAT(t1.edate,'%c') as c","DATE_FORMAT(t1.edate,'%m') as m","DATE_FORMAT(t1.edate,'%d') as d",'t2.id as offerId','t2.bprice','t2.eprice');
		$this->queryTerms = "t1, ".$cBonusOffer->tableName." t2, ".$this->krnl->dbPref."usersinterest t3 WHERE t1.active=1 AND t2.ownerId=t1.id AND t2.active=1 AND t1.id=t3.bonusId AND t3.ownerId=".(int)$this->krnl->userId." ORDER BY t1.edate DESC, t1.id, t2.orderIndex";	
		$id = $offerId = $min = $max = $maxDiscount = 0;

		if ($this->fList(0))
		{
			$cBonusFoto = &$this->childsClass['bonusfoto'];
			$this->fGetFoto();
			foreach($this->moduleData as $row)
				if ($row['eprice'])
				{
					if ($id!=$row['id'])
					{
						if ($id) $xml .= '<min copeck="'.substr($min,strpos($min,'.')+1).'"><![CDATA['.(int)$min.']]></min> <max><![CDATA['.(int)$max.']]></max> <discount><![CDATA['.$maxDiscount.']]></discount> </interest>'; 
						$xml .= '<interest id="'.$row['id'].'"> <name><![CDATA['.$this->fText4Script($row['name']).']]></name> <date><![CDATA['.$row['d'].'.'.$row['m'].'.'.$row['y'].']]></date> ';
						if (isset($cBonusFoto->moduleData[$row['id']]) && count($cBonusFoto->moduleData[$row['id']])) 
						{ 
							$fotoPath = $cBonusFoto->fGetFile($cBonusFoto->moduleData[$row['id']][0][0],'i_bonus',$cBonusFoto->moduleData[$row['id']][0][1]); 
							$xml .= '<img>'.$this->fPrefixImage($fotoPath,'s_').'</img>'; 
						}

						$id = $row['id'];
						$min = $row['eprice'];
						$max = $row['bprice'];
						$maxDiscount = 100-ceil($row['eprice']/$row['bprice']*100);
					}
					
					if ($offerId!=$row['offerId']) 
					{
						$tempDiscount = 100-ceil($row['eprice']/$row['bprice']*100);
						if ($min > $row['eprice']) $min = $row['eprice'];
						if ($max < $row['bprice']) $max = $row['bprice'];
						if ($maxDiscount < $tempDiscount) $maxDiscount = $tempDiscount;
						$offerId = $row['offerId'];
						$xml .= '<offer/>';
					}
				}
			
			if ($id) $xml .= '<min copeck="'.substr($min,strpos($min,'.')+1).'"><![CDATA['.(int)$min.']]></min> <max><![CDATA['.(int)$max.']]></max> <discount><![CDATA['.$maxDiscount.']]></discount> </interest>';
		}
		
		return $xml;
	}	
	
	function fDisplayPartner()
	{
		$xml = '';
		$cBonusOffer = &$this->childsClass['bonusoffer'];	
		if ($this->krnl->fCheckAuthPartner())
		{
			if($this->krnl->partnerEmail2) //менеджер
			{
				$xml .= '<ident>2</ident>';
				$this->queryFields = array("DATE_FORMAT(t1.edate,'%Y-%m-%d') as edate","DATE_FORMAT(t1.ldate,'%Y') as ly","DATE_FORMAT(t1.ldate,'%c') as lc","DATE_FORMAT(t1.ldate,'%d') as ld",'t2.*',"DATE_FORMAT(t3.paydate,'%d.%m.%Y в %H:%i') as paydate",'t3.id as uOfferId','t3.paid','t3.cnt','t4.usedate','t1.firmId');
				$this->queryTerms = "t1, ".$cBonusOffer->tableName." t2, ".$this->krnl->dbPref."usersoffer t3 LEFT JOIN ".$this->krnl->dbPref."usersused t4 ON t4.ownerId=t3.id WHERE t2.ownerId=t1.id AND t2.id=t3.offerId AND t1.firmId=".(int)$this->krnl->partnerId." ORDER BY t4.id AND t3.paydate DESC";
				// $this->queryTerms = "t1, ".$cBonusOffer->tableName." t2, ".$this->krnl->dbPref."usersoffer t3 LEFT JOIN ".$this->krnl->dbPref."usersused t4 ON t4.ownerId=t3.id WHERE t2.ownerId=t1.id AND t2.id=t3.offerId AND t1.firmId=".(int)$this->krnl->partnerId." AND t1.ldate>='".date('Y-m-d H:i')."' ORDER BY t4.id AND t3.paydate DESC";
				if (isset($_POST['used']) && (int)$_POST['used']==1)
				{
					$this->krnl->dbQuery = "INSERT ".$this->krnl->dbPref."usersused SET used=1, usedate='".date("Y-m-d H:i:s")."', ownerId=".$_POST["couponId"];
						if ($this->krnl->fDbExecute())
							$xml .= '<ok><![CDATA[<b>Купон №'.$_POST["couponId"].'/'.sprintf("%05d",$this->krnl->partnerId).' успешно отмечен использованным</b>]]></ok>';
						else
							$xml .= '<er2><![CDATA[Ошибка отметки купона №. '.$this->krnl->toAdm.'/'.sprintf("%05d",$this->krnl->partnerId).']]></er2>';
				}
				elseif (isset($_POST['used']) && (int)$_POST['used']==0)
				{
					$this->krnl->dbQuery = "DELETE FROM ".$this->krnl->dbPref."usersused WHERE ownerId=".$_POST["couponId"];
						if ($this->krnl->fDbExecute())
							$xml .= '<ok><![CDATA[<b>Для купона №'.$_POST["couponId"].'/'.sprintf("%05d",$this->krnl->partnerId).' успешно отменено использованние</b>]]></ok>';
						else
							$xml .= '<er2><![CDATA[Ошибка отметки купона №. '.$this->krnl->toAdm.'/'.sprintf("%05d",$this->krnl->partnerId).']]></er2>';
				}
				if ($this->fList(0))
				{
					$cBonusFoto = &$this->childsClass['bonusfoto'];
					$this->fGetFoto('ownerId');
					
					foreach($this->moduleData as $row)
					{
						if($row['usedate']=='')
						{
							$uOfferId = substr($row['uOfferId'], 0, strlen($row['uOfferId'])-4).'****';
						}
						else $uOfferId = $row['uOfferId'];
						$xml .= '
<offer id="'.$row['id'].'" ownerId="'.$row['ownerId'].'" paid="'.$row['paid'].'" cnt="'.$row['cnt'].'" used="'.$row['usedate'].'" uOfferId="'.$uOfferId.'" firmId="'.sprintf("%05d",$row['firmId']).'">
<name><![CDATA['.$row['name'].']]></name>
<date><![CDATA['.$row['ld'].' '.$this->krnl->arMonthNameBias[$row['lc']].' '.$row['ly'].']]></date>
<paydate><![CDATA['.$row['paydate'].']]></paydate>
<min copeck="'.substr($row['cnt']*$row['eprice'],strpos($row['cnt']*$row['eprice'],'.')+1).'"><![CDATA['.(int)$row['cnt']*$row['eprice'].']]></min>
<max><![CDATA['.(int)$row['cnt']*$row['bprice'].']]></max>
<discount><![CDATA['.(100-ceil($row['eprice']/$row['bprice']*100)).']]></discount>';
						if (isset($cBonusFoto->moduleData[$row['ownerId']]) && count($cBonusFoto->moduleData[$row['ownerId']])) 
						{ 
							$fotoPath = $cBonusFoto->fGetFile($cBonusFoto->moduleData[$row['ownerId']][0][0],'i_bonus',$cBonusFoto->moduleData[$row['ownerId']][0][1]); 
							$xml .= '<img>'.$this->fPrefixImage($fotoPath,'s_').'</img>'; 
						}
						$xml .= '</offer>';
					}
				}
				else
					$xml = '<er2><![CDATA[<b>Купоны не найдены</b>]]></er2>';
			}
			else //кассир
			{
				if (isset($_POST['couponId']) && (int)$_POST['couponId'])
				{
					if (isset($_POST['used']) && (int)$_POST['used']==1)
					{
						$this->krnl->dbQuery = "INSERT ".$this->krnl->dbPref."usersused SET used=1, usedate='".date("Y-m-d H:i:s")."', ownerId=".$_POST["couponId"];
							if ($this->krnl->fDbExecute())
								$xml = '<ok><![CDATA[<b>Купон №'.$_POST["couponId"].'/'.sprintf("%05d",$this->krnl->partnerId).' успешно отмечен использованным</b>]]></ok>';
							else
								$xml = '<er2><![CDATA[Ошибка отметки купона №. '.$this->krnl->toAdm.'/'.sprintf("%05d",$this->krnl->partnerId).']]></er2>';
					}
					if ($xml=='')
					{
						$xml .= '<ident>1</ident>';
						
						$this->queryFields = array("DATE_FORMAT(t1.edate,'%Y-%m-%d') as edate","DATE_FORMAT(t1.ldate,'%Y') as ly","DATE_FORMAT(t1.ldate,'%c') as lc","DATE_FORMAT(t1.ldate,'%d') as ld",'t2.*',"DATE_FORMAT(t3.paydate,'%d.%m.%Y в %H:%i') as paydate",'t3.id as uOfferId','t3.paid','t3.cnt','t4.usedate','count(t4.id) as cntused','t1.firmId');
						$this->queryTerms = "t1, ".$cBonusOffer->tableName." t2, ".$this->krnl->dbPref."usersoffer t3 LEFT JOIN ".$this->krnl->dbPref."usersused t4 ON t4.ownerId=t3.id WHERE t2.ownerId=t1.id AND t2.id=t3.offerId AND t3.id=".$_POST['couponId']." AND t1.firmId=".(int)$this->krnl->partnerId." ORDER BY t3.paydate DESC";

						if ($this->fList(0))
						{
							$cBonusFoto = &$this->childsClass['bonusfoto'];
							$this->fGetFoto('ownerId');
							foreach($this->moduleData as $row)
								if ($row['usedate']=='' && ($row['edate']>=date('Y-m-d') || ($row['edate']<date('Y-m-d')) && $row['paid'])) // Выводим если не использован и если не просрочена дата оплаты
								{
									$xml .= '
<offer id="'.$row['id'].'" ownerId="'.$row['ownerId'].'" paid="'.$row['paid'].'" cnt="'.$row['cnt'].'" used="'.$row['usedate'].'" uOfferId="'.$row['uOfferId'].'" firmId="'.sprintf("%05d",$row['firmId']).'">
<name><![CDATA['.$row['name'].']]></name>
<date><![CDATA['.$row['ld'].' '.$this->krnl->arMonthNameBias[$row['lc']].' '.$row['ly'].']]></date>
<paydate><![CDATA['.$row['paydate'].']]></paydate>
<min copeck="'.substr($row['cnt']*$row['eprice'],strpos($row['cnt']*$row['eprice'],'.')+1).'"><![CDATA['.(int)$row['cnt']*$row['eprice'].']]></min>
<max><![CDATA['.(int)$row['cnt']*$row['bprice'].']]></max>
<discount><![CDATA['.(100-ceil($row['eprice']/$row['bprice']*100)).']]></discount>';
									if (isset($cBonusFoto->moduleData[$row['ownerId']]) && count($cBonusFoto->moduleData[$row['ownerId']])) 
									{ 
										$fotoPath = $cBonusFoto->fGetFile($cBonusFoto->moduleData[$row['ownerId']][0][0],'i_bonus',$cBonusFoto->moduleData[$row['ownerId']][0][1]); 
										$xml .= '<img>'.$this->fPrefixImage($fotoPath,'m_').'</img>'; 
									}
									$xml .= '</offer>';		
								}
								else
									$xml = '<er2><![CDATA[<b>Купон №'.$_POST["couponId"].'/'.sprintf("%05d",$this->krnl->partnerId).' не найден!</b>]]></er2>';
						}
						else
							$xml = '<er2><![CDATA[<b>Купон №'.$_POST["couponId"].'/'.sprintf("%05d",$this->krnl->partnerId).' не найден!</b>]]></er2>';
					}
				}
				elseif (isset($_POST['couponId']))
					$xml = '<er2><![CDATA[<b>Введите номер купона!!!</b>]]></er2>';
				$xml .= '<partner>'.sprintf("%05d",$this->krnl->partnerId).'</partner>';
			}
		}
		// echo htmlspecialchars($xml);
		return $xml;
	}		
	
	function fDisplayArchive()
	{
		$xml = $path = '';	

		$this->queryFields = array("DATE_FORMAT(edate,'%Y') as y","DATE_FORMAT(edate,'%m') as m");
		$this->queryTerms = "WHERE active=1 AND DATE_FORMAT(edate,'%Y-%m-%d')<'".date('Y-m-d')."' ORDER BY edate DESC";
		if ($this->fList(0)) 
		{ 
			$bonusY = $this->moduleData[0]['y'];
			$bonusM = $this->moduleData[0]['m'];
		}
		else 
		{
			$bonusY = date('Y');
			$bonusM = date('m');
		}
		
		$cBonusOffer = &$this->childsClass['bonusoffer'];
		$cBonusF = &$this->childsClass['bonusf'];
		
		if (isset($_REQUEST['bonusy']) && (int)$_REQUEST['bonusy'] && $_REQUEST['bonusy'] < $bonusY) $bonusY = $_REQUEST['bonusy'];
		if (isset($_REQUEST['bonusm']) && (int)$_REQUEST['bonusm'] && (
			($_REQUEST['bonusm'] < $bonusM && ($bonusY.'-'.$_REQUEST['bonusm']) < ($bonusY.'-'.$bonusM)) ||
			($_REQUEST['bonusm'] > $bonusM && ($bonusY.'-'.$_REQUEST['bonusm']) < (date('Y').'-'.$bonusM))
		)) $bonusM = $_REQUEST['bonusm'];
		
		if ($bonusY.'-'.$bonusM==date('Y-m')) $query = "AND DATE_FORMAT(edate,'%Y-%m-%d')<'".date('Y-m-d')."'"; // Для сегодняшнего дня!
		else $query = '';
			
		$cnt = 0;	
		$this->queryFields = array('id');
		$this->queryTerms = "WHERE active=1 AND DATE_FORMAT(edate,'%Y-%m')='".$bonusY."-".$bonusM."' ".$query." ORDER BY orderIndex";
		
		if ($this->fList(0)) 
		{
			$i = 0;
			$bonusId = '0';
			foreach($this->moduleData as $row)
			{
				$begin = $this->messagesOnPage * ($this->krnl->pagenum - 1);
				$end = $begin + $this->messagesOnPage;
				if ($begin <= $i && $i < $end) $bonusId .= ','.$row['id'];
				$i++;
			}				
			$cnt = count($this->moduleData);
		}
	
		if ($cnt)
		{
			// если указанна страница навигации при которой не существует записей
			if (($this->messagesOnPage * ($this->krnl->pagenum - 1))>=$cnt) $this->krnl->pagenum = ceil($cnt/$this->messagesOnPage); 
			
			$this->queryFields = array('t1.id','t1.name',"DATE_FORMAT(t1.edate,'%Y') as y","DATE_FORMAT(t1.edate,'%c') as c","DATE_FORMAT(t1.edate,'%m') as m","DATE_FORMAT(t1.edate,'%d') as d",'t2.id as offerId','t2.bprice','t2.eprice','count(t3.id) as paid');
			$this->queryTerms = 't1, '.$cBonusOffer->tableName.' t2 LEFT JOIN '.$this->krnl->dbPref.'usersoffer t3 ON t3.offerId=t2.id AND t3.paid=1 WHERE t1.active=1 AND t2.ownerId=t1.id AND t2.active=1 AND t1.id IN ('.$bonusId.') GROUP BY t2.id  ORDER BY t1.edate, t1.id, t2.orderIndex';			
			
			if ($this->fList(0)) { $this->fGetFoto();  $xml .= $this->fGatherData(0).$this->fPageNavigation($this->krnl->pagenum,$cnt);	}
		}
	
		return '<path>'.strtolower($this->krnl->arMonthName[(int)$bonusM]).' '.$bonusY.' года</path>'.$xml;
	}

	function fMap()
	{
		$tree = array();
		$this->queryFields = array("DATE_FORMAT(edate,'%Y') as y","DATE_FORMAT(edate,'%m') as m");
		$this->queryTerms = "WHERE active=1 AND DATE_FORMAT(edate,'%Y-%m-%d')<'".date('Y-m-d')."' ORDER BY edate DESC";
		if ($this->fList(0)) 
		{ 
			$bonusY = $this->moduleData[0]['y'];
			$bonusM = $this->moduleData[0]['m'];
		}
		else 
		{
			$bonusY = date('Y');
			$bonusM = date('m');
		}
		
		if (isset($_REQUEST['bonusy']) && (int)$_REQUEST['bonusy'] && $_REQUEST['bonusy'] < $bonusY) $bonusY = $_REQUEST['bonusy'];
		if (isset($_REQUEST['bonusm']) && (int)$_REQUEST['bonusm'] && (
			($_REQUEST['bonusm'] < $bonusM && ($bonusY.'-'.$_REQUEST['bonusm']) < ($bonusY.'-'.$bonusM)) ||
			($_REQUEST['bonusm'] > $bonusM && ($bonusY.'-'.$_REQUEST['bonusm']) < (date('Y').'-'.$bonusM))
		)) $bonusM = $_REQUEST['bonusm'];
		
		$this->queryFields = array("DATE_FORMAT(edate,'%Y') as y","DATE_FORMAT(edate,'%m') as m","DATE_FORMAT(edate,'%c') as c");
		$this->queryTerms = "WHERE active=1 AND DATE_FORMAT(edate,'%Y-%m-%d')<'".date('Y-m-d')."' ORDER BY y DESC, c DESC";
		$y = $ym = $cy = $cym = 0;
		$i = 0;
		if ($this->fList(0))
			foreach($this->moduleData as $row)
			{
				if ($y!=$row['y'])
				{
					if ($y) $tree['bonus']['bonusarch'.$y][1] = $y.' <span>('.$cy.')</span>';
					$y = $row['y'];
					$cy = 0;
					$tree['bonus']['bonusarch'.$y] = array('bonusarch'.$y,$y.' <span>(1)</span>','bonusarch'.$y.'.html',($bonusY==$y?1:0));
				}			
			
				if ($ym!=$y.'-'.$row['m'])
				{
					if ($ym) $tree['bonusarch'.substr($ym,0,4)]['bonusarch'.$ym][1] = $this->krnl->arMonthName[(int)substr($ym,-2)].' <span>('.$cym.')</span>';
					$ym = $y.'-'.$row['m'];
					$cym = 0;
					$tree['bonusarch'.$y]['bonusarch'.$ym] = array('bonusarch'.$ym,$this->krnl->arMonthName[(int)substr($ym,-2)].' <span>(1)</span>','bonusarch'.$ym.'.html',($bonusY.'-'.$bonusM==$ym?1:0));
				}
			
				$cy++;
				$cym++;
			}	

		if ($y) $tree['bonus']['bonusarch'.$y][1] = $y.' <span>('.$cy.')</span>';
		if ($ym) $tree['bonusarch'.substr($ym,0,4)]['bonusarch'.$ym][1] = $this->krnl->arMonthName[(int)substr($ym,-2)].' <span>('.$cym.')</span>';
		
		return $tree;
	}
}

class cCityBonus extends cModule
{
	function fInitialSettings()
	{
		parent::fInitialSettings();
		$this->mActiveField = true;
		$this->mOrderField = true;
		$this->mOnSearch = true;
		$this->mAdd = false;
		return 1;
	}

	function fCreateModule()
	{
		parent::fCreateModule();

		$this->tableName = 'city';
		$this->moduleNick = 'citybonus';
		
		$this->searchFeatures = array('fields'=>array('name'), 'description'=>'name', 'name'=>'name', 'pref'=>'city', 'suff'=>'/');
		
		$this->orderAzoneField = 'active DESC, orderIndex';
		
		$this->moduleFields['email'] = array('type' => 'VARCHAR', 'attr' => 'NOT NULL');
		$this->moduleFields['hour'] = array('type' => 'INT UNSIGNED', 'attr' => 'NOT NULL DEFAULT 0');
		
		$this->fCreateChild('bonus');
	}
	
	function fGetName($id=0,$type='')
	{
		if (!$id) $id = $this->id;
		if ($id)
		{
			$this->queryFields = array('t1.*','t2.id as regionId','t2.ownerId as countryId');
			$this->queryTerms = 't1, '.$this->owner->tableName.' t2 WHERE t2.id=t1.ownerId AND t1.id='.$id;

			if ($this->fList(0))
			{
				if ($type=='') $_SESSION['city'] = $id;
				$this->name = $this->moduleData[0]['name'];
				$this->hour = $this->moduleData[0]['hour'];
				$this->owner->id = $this->moduleData[0]['regionId'];
				$this->owner->owner->id = $this->moduleData[0]['countryId'];
				return 1;
			}
		}
		return 1;		
	}

	function fDisplayList($id=0,$type='')
	{
		if ($id) $this->id = $id;
		elseif (isset($_GET['city']) && (int)$_GET['city']) $this->id = $_SESSION['city'] = $_GET['city'];
		elseif (isset($_SESSION['city']) && (int)$_SESSION['city']) $this->id = $_SESSION['city'];
		else $this->id = 3345; // 4400 - Москва 3345 - Уфа
		$this->fGetName(0,$type);
		$this->queryFields = array('t1.id','t1.name');
		$this->queryTerms = '';
		
		$this->queryTerms = 't1 WHERE id IN (4400, 4962, 3283, 5106, 3731, 5269, 3933, 4183, 3612, 4549, 4580, 4617, 4720, 4917, 5310, 5395, 3345, 5539, 3343) ORDER BY t1.orderIndex, t1.name LIMIT 20';
		
		
		// echo htmlspecialchars($this->queryTerms);
		$xml = '';
		

		if($this->fList(0))
			foreach($this->moduleData as $row)
				$xml .= '<item id="'.$row['id'].'"> <name><![CDATA['.$row['name'].']]></name> </item>';

		$this->owner->queryFields = array('t1.id','t1.name','t2.id as countryId','t2.name as countryName');		
		$this->owner->queryTerms = 't1, '.$this->owner->owner->tableName.' t2 WHERE t1.active=1 AND t2.active=1 AND t1.ownerId=t2.id ORDER BY t2.orderIndex, t2.name, t1.orderIndex, t1.name';
		$countryId = $i = 0;		
			if ($this->owner->fList(0))
				foreach($this->owner->moduleData as $row)
				{
					if ($countryId!=$row['countryId'])
					{
						$xml .= '<country id="'.$row['countryId'].'"> <name><![CDATA['.$row['countryName'].']]></name> </country>';
						$countryId = $row['countryId'];
						$i++;
					}
					if ($i==2) continue; // Регион ставим только для первого
					$xml .= '<region id="'.$row['id'].'"> <name><![CDATA['.$row['name'].']]></name> </region>';
				}

		$xml .= '<id>'.$this->id.'</id> <type>'.$type.'</type> <name><![CDATA['.substr($this->name,0,15).']]></name>';
	
		return $xml;
	}
}

class cRegionBonus extends cModule
{
	function fInitialSettings()
	{
		parent::fInitialSettings();
		$this->mActiveField = true;
		$this->mOrderField = true;
		$this->mOnSearch = true;
		$this->mAdd = false;
		return 1;
	}

	function fCreateModule()
	{
		parent::fCreateModule();

		$this->searchFeatures = array('fields'=>array('name'), 'description'=>'name', 'name'=>'name', 'pref'=>'region', 'suff'=>'/');
		
		$this->tableName = 'region';
		$this->moduleNick = 'regionbonus';
		
		$this->orderAzoneField = 'active DESC, orderIndex';
		
		$this->fCreateChild('citybonus');
	}
}

class cCountryBonus extends cModule
{
	function fInitialSettings()
	{
		parent::fInitialSettings();
		$this->mActiveField = true;
		$this->mOrderField = true;
		$this->mOnSearch = true;
		$this->mAdd = false;
		return 1;
	}

	function fCreateModule()
	{
		parent::fCreateModule();
		
		$this->searchFeatures = array('fields'=>array('name'), 'description'=>'name', 'name'=>'name', 'pref'=>'country', 'suff'=>'/');
		
		$this->tableName = 'country';
		$this->moduleNick = 'countrybonus';
		
		$this->orderAzoneField = 'active DESC, orderIndex';
		
		$this->serviceFormItems['order'] = array('type' => 'text', 'caption' => 'Номер транзакции');
		$this->serviceFormItems['summ'] = array('type' => 'text', 'caption' => 'Сумма пополнения', 'comment'=>'Заполняется только в случае пополнения баланса пользователя');
		$this->services['order'] = array('type'=>'form','function'=>'fAddPay','form'=>$this->serviceFormItems,'caption'=>'провести транзакцию');
		
		$this->fCreateChild('regionbonus');
	}
	
	function fAddPay()
	{
		if (isset($_POST['order']) && (int)$_POST['order']) $orderId = (int)$_POST['order'];
		else return $this->fWriteError('Поле `'.$this->serviceFormItems['order']['caption'].'` не может быть пустым');
		
		if (isset($_POST['summ']) && (int)$_POST['summ'])  // Пополнение баланса
		{
			$this->krnl->dbQuery = "SELECT balans, ownerId FROM ".$this->krnl->dbPref."usersbalans WHERE paid=0 AND id=".$orderId;
			if ($this->krnl->fDbExecute() && $this->krnl->fDbNumRows())
			{
				$row = $this->krnl->fDbGetRow();
				
				if ($_POST['summ'] == (int)$row['balans'])
				{
					$this->krnl->dbQuery = "UPDATE ".$this->krnl->dbPref."usersbalans SET paid=1, paydate='".date('Y-m-d H:i:s')."' WHERE id=".$orderId;
					if (!$this->krnl->fDbExecute()) return $this->fWriteError('Ошибка №3. Проведение транзакции не успешно');								
					
					$this->krnl->dbQuery = "UPDATE ".$this->krnl->dbPref."users SET balans=balans+".$row['balans'].", paydate='".date('Y-m-d H:i:s')."' WHERE id=".$row['ownerId'];
					if (!$this->krnl->fDbExecute()) return $this->fWriteError('Ошибка №4. Проведение транзакции не успешно');								
				}
				else return $this->fWriteError('Ошибка №2. Проведение транзакции не успешно');			
			}
			else return $this->fWriteError('Ошибка №1. Проведение транзакции не успешно');			
		}
		else 
		{
			$this->krnl->dbQuery = "UPDATE ".$this->krnl->dbPref."usersoffer SET paid=1, paydate='".date('Y-m-d H:i:s')."' WHERE id=".$orderId;				
			if (!$this->krnl->fDbExecute()) return $this->fWriteError('Ошибка №2. Проведение транзакции не успешно');		
		}
		
		return 1;	
	}
}

?>