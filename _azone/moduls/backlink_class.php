<?
class cBackLink extends cModule
{

	function fInitialSettings() 
	{
		parent::fInitialSettings();
		return 1;
	}

	function fCreateModule() 
	{
		parent::fCreateModule();

		$this->tableName = 'backlink';
		$this->moduleCaption = 'письма';
		
		$this->moduleFields['email'] = array('type' => 'VARCHAR', 'width' => 127, 'attr' => "NOT NULL DEFAULT ''");
		$this->moduleFields['phone'] = array('type' => 'VARCHAR', 'width' => 127, 'attr' => "NOT NULL DEFAULT ''");
		$this->moduleFields['letter'] = array('type' => 'TEXT', 'max' => 4096, 'attr' => 'NOT NULL');
		$this->moduleFields['adddate'] = array('type' => 'DATE', 'attr' => 'NOT NULL');
		$this->moduleFields['addip'] = array('type' => 'VARCHAR', 'width' => 32, 'attr' => "NOT NULL DEFAULT ''");

		$this->orderAzoneField = 'adddate DESC, id DESC';
		$this->listAzoneFields = array('adddate','name');			
		
		$this->itemFormItems['name'] = array('caption' => 'Автор','view'=>1);
		$this->itemFormItems['email'] = array('caption' => 'E-mail автора','view'=>1);
		$this->itemFormItems['phone'] = array('caption' => 'Телефон автора','view'=>1);
		$this->itemFormItems['letter'] = array('type' => 'textarea', 'caption' => 'Tекcт письма','view'=>1);
		$this->itemFormItems['adddate'] = array('type' => 'date', 'caption' => 'Дата добавления','view'=>1);
		$this->itemFormItems['addip'] = array('caption' => 'IP-адрес автора','view'=>1);
    }
	
	function fDisplay($type='')
	{		
		$data = array();
		if (isset($_POST['bsend'.$type]) && $_POST['bsend'.$type]=='Отправить' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER'])) 
			$data = $this->fStripSlashes($_POST); 
		elseif(isset($_SESSION['backlink'])) 
			$data = $_SESSION['backlink'];		
			
		$this->fForm($data,$type);
		
		if (isset($_POST['bsend'.$type]) && $_POST['bsend'.$type]=='Отправить' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER']))
		{
			list($error,$data) = $this->fFormCheck($data);
			if($error=='')
			{
				$this->fieldsData['name'] = $_SESSION['backlink']['name'] = $data['name'];
				$this->fieldsData['email'] = $_SESSION['backlink']['email'] = $data['email'];
				$this->fieldsData['phone'] = $_SESSION['backlink']['phone'] = $data['phone'];
				$this->fieldsData['letter'] = $data['txt'];
				$this->fieldsData['adddate'] = date('Y-m-d');
				$this->fieldsData['addip'] = $_SERVER['REMOTE_ADDR'];
				$this->fAddItem();

				$txt = '<p>Cо страницы  обратной связи (<a href="'.$this->krnl->domainName.'backlink.html">'.$this->krnl->domainName.'backlink.html</a>) отправлено сообщение для Администрации сайта.</p> <p><b>Контактные данные отправителя</b></p><blockquote>Имя : '.$data['name'].'<br>E-mail : '.$data['email'].'<br>Телефон : '.$data['phone'].'<br> </blockquote><p><b>Текст сообщения</b></p><blockquote>'.$data['txt'].'</blockquote>';
				
				if($this->fSendMail('dq15@mail.ru, mackarr@inbox.ru','Сообщение от пользователя со страницы обратной связи '.$this->krnl->domainName,$txt)) 
					$xml = '<ok><![CDATA[Спасибо! Ваше сообщение успешно отправлено. В ближайшее время наши специалисты свяжутся с Вами.]]></ok>';
				else $xml = '<er2><![CDATA[Ошибка отправки сообщения. Попробуте повторить попытку.<br> В случае, если вы не можете решить проблему самостоятельно – <a href="mailto:'.$this->krnl->email.'">напишите о ней нам</a>.]]></er2>';
			}
			else $xml = $this->fForm2xml();
		}
		else $xml = $this->fForm2xml();

		return fXmlTransform($xml,'formblock');
	}
	
	function fForm($data,$type)
	{
		if (!isset($data['name'])) $data['name'] = '';
		if (!isset($data['email'])) $data['email'] = '';    
		if (!isset($data['phone'])) $data['phone'] = ''; 
		if (!isset($data['txt'])) $data['txt'] = '';

		$this->form = array();
		$this->form['_*features*_'] = array('name'=>'backlink','action'=>'#form');
		$this->form['i1'] = array('type'=>'info','value'=>'По интересующим вопросам Вы можете связаться с нами с помощью данной формы.');		
		$this->form['name'] = array('claim'=>1,'type'=>'text','caption'=>'Ваше имя','value'=>$data['name'],'mask'=>array('name'=>'text','max'=>127));
		$this->form['email'] = array('claim'=>1,'type'=>'text','caption'=>'Email','value'=>$data['email'],'mask'=>array('name'=>'email'));
		$this->form['phone'] = array('type'=>'text','caption'=>'Телефон','value'=>$data['phone'],'mask'=>array('name'=>'phone'));
		$this->form['txt'] = array('claim'=>1,'type'=>'textarea','rows'=>7,'caption'=>'Текст письма','value'=>$data['txt'],'mask'=>array('name'=>'text','max'=>512));
		
		$this->form['secret_code'.$type] = array('claim'=>1,'type'=>'secret','caption'=>'Введите код:','mask'=>array('name'=>'secret'));
		$this->form['bsend'.$type] = array('type'=>'submit','value'=>'Отправить');
		return 1;
	}
	
}

?>
