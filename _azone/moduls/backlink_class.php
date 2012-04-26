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
		$this->moduleCaption = '������';
		
		$this->moduleFields['email'] = array('type' => 'VARCHAR', 'width' => 127, 'attr' => "NOT NULL DEFAULT ''");
		$this->moduleFields['phone'] = array('type' => 'VARCHAR', 'width' => 127, 'attr' => "NOT NULL DEFAULT ''");
		$this->moduleFields['letter'] = array('type' => 'TEXT', 'max' => 4096, 'attr' => 'NOT NULL');
		$this->moduleFields['adddate'] = array('type' => 'DATE', 'attr' => 'NOT NULL');
		$this->moduleFields['addip'] = array('type' => 'VARCHAR', 'width' => 32, 'attr' => "NOT NULL DEFAULT ''");

		$this->orderAzoneField = 'adddate DESC, id DESC';
		$this->listAzoneFields = array('adddate','name');			
		
		$this->itemFormItems['name'] = array('caption' => '�����','view'=>1);
		$this->itemFormItems['email'] = array('caption' => 'E-mail ������','view'=>1);
		$this->itemFormItems['phone'] = array('caption' => '������� ������','view'=>1);
		$this->itemFormItems['letter'] = array('type' => 'textarea', 'caption' => 'T��c� ������','view'=>1);
		$this->itemFormItems['adddate'] = array('type' => 'date', 'caption' => '���� ����������','view'=>1);
		$this->itemFormItems['addip'] = array('caption' => 'IP-����� ������','view'=>1);
    }
	
	function fDisplay($type='')
	{		
		$data = array();
		if (isset($_POST['bsend'.$type]) && $_POST['bsend'.$type]=='���������' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER'])) 
			$data = $this->fStripSlashes($_POST); 
		elseif(isset($_SESSION['backlink'])) 
			$data = $_SESSION['backlink'];		
			
		$this->fForm($data,$type);
		
		if (isset($_POST['bsend'.$type]) && $_POST['bsend'.$type]=='���������' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER']))
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

				$txt = '<p>C� ��������  �������� ����� (<a href="'.$this->krnl->domainName.'backlink.html">'.$this->krnl->domainName.'backlink.html</a>) ���������� ��������� ��� ������������� �����.</p> <p><b>���������� ������ �����������</b></p><blockquote>��� : '.$data['name'].'<br>E-mail : '.$data['email'].'<br>������� : '.$data['phone'].'<br> </blockquote><p><b>����� ���������</b></p><blockquote>'.$data['txt'].'</blockquote>';
				
				if($this->fSendMail('dq15@mail.ru, mackarr@inbox.ru','��������� �� ������������ �� �������� �������� ����� '.$this->krnl->domainName,$txt)) 
					$xml = '<ok><![CDATA[�������! ���� ��������� ������� ����������. � ��������� ����� ���� ����������� �������� � ����.]]></ok>';
				else $xml = '<er2><![CDATA[������ �������� ���������. ��������� ��������� �������.<br> � ������, ���� �� �� ������ ������ �������� �������������� � <a href="mailto:'.$this->krnl->email.'">�������� � ��� ���</a>.]]></er2>';
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
		$this->form['i1'] = array('type'=>'info','value'=>'�� ������������ �������� �� ������ ��������� � ���� � ������� ������ �����.');		
		$this->form['name'] = array('claim'=>1,'type'=>'text','caption'=>'���� ���','value'=>$data['name'],'mask'=>array('name'=>'text','max'=>127));
		$this->form['email'] = array('claim'=>1,'type'=>'text','caption'=>'Email','value'=>$data['email'],'mask'=>array('name'=>'email'));
		$this->form['phone'] = array('type'=>'text','caption'=>'�������','value'=>$data['phone'],'mask'=>array('name'=>'phone'));
		$this->form['txt'] = array('claim'=>1,'type'=>'textarea','rows'=>7,'caption'=>'����� ������','value'=>$data['txt'],'mask'=>array('name'=>'text','max'=>512));
		
		$this->form['secret_code'.$type] = array('claim'=>1,'type'=>'secret','caption'=>'������� ���:','mask'=>array('name'=>'secret'));
		$this->form['bsend'.$type] = array('type'=>'submit','value'=>'���������');
		return 1;
	}
	
}

?>
