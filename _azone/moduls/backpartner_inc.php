<?
	if (!isset($cBackLink)) { include_once($cDB->pathMDL.'backlink_class.php'); $cBackLink = new cBackLink($cDB, $null); }
	$email = $cPage->config['email'];
	if (isset($_POST) && isset($_POST['send']) && $_POST['send']=='���������') $data = $cBackLink->fStripSlashes($_POST); elseif(isset($_SESSION['goOrder'])) $data = $_SESSION['goOrder'];
	if (!isset($data['name'])) $data['name'] = '';
	if (!isset($data['email'])) $data['email'] = '';    
	if (!isset($data['phone'])) $data['phone'] = ''; 
	if (!isset($data['txt'])) $data['txt'] = '';

	$cBackLink->form = array();
	$cBackLink->form['_*features*_'] = array('name'=>'send','action'=>$cDB->domainName.'backlink.html#form');
	$cBackLink->form['i1'] = array('type'=>'info','value'=>'�������� ������ ��� <strong>'.$cPage->config['sitename'].'</strong>');
	$cBackLink->form['name'] = array('claim'=>1,'type'=>'text','caption'=>'���� ���','value'=>$data['name'],'mask'=>array('name'=>'text','max'=>127));
	$cBackLink->form['email'] = array('claim'=>1,'type'=>'text','caption'=>'Email','value'=>$data['email'],'mask'=>array('name'=>'email'));
	$cBackLink->form['phone'] = array('type'=>'text','caption'=>'�������','value'=>$data['phone'],'mask'=>array('name'=>'phone'));
	$cBackLink->form['txt'] = array('claim'=>1,'type'=>'textarea','rows'=>7,'caption'=>'����� ������','value'=>$data['txt'],'mask'=>array('name'=>'textarea','max'=>512));
	$cBackLink->form['secret_code'] = array('claim'=>1,'type'=>'secret','caption'=>'������� ���:','mask'=>array('name'=>'secret','code'=>$_SESSION['secret_code']));    
	$cBackLink->form['send'] = array('type'=>'submit','value'=>'���������');  
	// ----------------

	if (count($_POST) && $email!='')
	{
		$Arr = $cBackLink->fFormCheck($data);
		if(trim($Arr[0])=='')
		{

		$txt = '<p>C� ��������  �������� ����� (<a href=\''.$cDB->domainName.'backlink.html\'>'.$cDB->domainName.'backlink.html</a>) ���������� ������ ��� ������������� �����.</p> <p><b>���������� ������ �����������</b></p><blockquote>��� : '.$data['name']./* '<br>����������� : '.$data['org']. */'<br>E-mail : '.$data['email'].'<br>������� : '.$data['phone'].'<br> </blockquote><p><b>����� ������</b></p><blockquote>'.$data['txt'].'</blockquote>';
		$ttl = '��� ������ � '.$cDB->domainName;        
			if($cBackLink->fSendMail($email,$ttl,$txt)) $xml = '<ok><![CDATA[�������! ���� ������ ��� <strong>'.$cPage->config['sitename'].'</strong> ������� ����������. <a href="'.$cDB->domainName.'backlink.html">��������� ��� ���� ������.</a>]]></ok>';
			else $xml = '<er2><![CDATA[������ �������� ������. ��������� ��������� �������.<br> � ������, ���� �� �� ������ ������ �������� �������������� � <a href="mailto:'.$email.'">�������� � ��� ��� �� "'.$email.'"</a>.]]></er2>';
		}
		else $xml = $cBackLink->fForm2xml();
	}
	elseif ($email!='') $xml = $cBackLink->fForm2xml();
	else $xml = '<er2>������ �������� ������</er2>';
	$_SESSION['secret_code'] = rand(10000,99999);
	return fXmlTransform($xml,'formblock');
?>