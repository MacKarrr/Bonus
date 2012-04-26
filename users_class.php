<?

class cUsersBalans extends cModule
{
	function fInitialSettings() 
	{
		parent::fInitialSettings();
		return 1;
	}

	function fCreateModule() 
	{
		parent::fCreateModule();
		$this->tableName = 'usersbalans';
		$this->moduleFields['balans'] = array('type' => 'DECIMAL(10,2)','attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['paid'] = array('type' => 'BOOL', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['paydate'] = array('type' => 'timestamp', 'attr' => 'NOT NULL DEFAULT 0');
	}
}

class cUsersSend extends cModule
{
	function fInitialSettings() 
	{
		parent::fInitialSettings();
		return 1;
	}

	function fCreateModule() 
	{
		parent::fCreateModule();
		$this->tableName = 'userssend';
		$this->moduleFields['bonusId'] = array('type' => 'INT UNSIGNED', 'attr' => 'NOT NULL', 'key'=>1);
		$this->moduleFields['userId'] = array('type' => 'INT UNSIGNED', 'attr' => 'NOT NULL', 'key'=>1);
	}
}

class cUsersUsed extends cModule
{
	function fInitialSettings() 
	{
		parent::fInitialSettings();
		return 1;
	}

	function fCreateModule() 
	{
		parent::fCreateModule();
		$this->tableName = 'usersused';
		$this->moduleFields['used'] = array('type' => 'BOOL', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['cancell'] = array('type' => 'BOOL', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['usedate'] = array('type' => 'timestamp', 'attr' => 'NOT NULL DEFAULT now()');
		$this->itemFormItems['used'] = array('type' => 'bool', 'caption' => 'Активен');
	}
}

class cUsersOffer extends cModule
{
	function fInitialSettings() 
	{
		parent::fInitialSettings();
		return 1;
	}

	function fCreateModule() 
	{
		parent::fCreateModule();
		$this->tableName = 'usersoffer';
		$this->moduleFields['offerId'] = array('type' => 'INT UNSIGNED', 'attr' => 'NOT NULL', 'key'=>1);
		$this->moduleFields['bonusId'] = array('type' => 'INT UNSIGNED', 'attr' => 'NOT NULL', 'key'=>1);		
		$this->moduleFields['cnt'] = array('type' => 'INT UNSIGNED', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['paid'] = array('type' => 'BOOL', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['cost'] = array('type' => 'DECIMAL(10,2)', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['paydate'] = array('type' => 'timestamp', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['favourfriend'] = array('type' => 'VARCHAR', 'width' => 33, 'attr' => "NOT NULL DEFAULT ''");
		$this->fCreateChild('usersused');
	}
}

class cUsersFrSend extends cModule
{
	function fInitialSettings() 
	{
		parent::fInitialSettings();
		return 1;
	}

	function fCreateModule() 
	{
		parent::fCreateModule();
		$this->tableName = 'usersfrsend';
		$this->moduleFields['offerId'] = array('type' => 'INT UNSIGNED', 'attr' => 'NOT NULL', 'key'=>1);
		$this->moduleFields['userId'] = array('type' => 'INT UNSIGNED', 'attr' => 'NOT NULL', 'key'=>1);		
	}
}

class cUsersInterest extends cModule
{
	function fInitialSettings() 
	{
		parent::fInitialSettings();
		return 1;
	}

	function fCreateModule() 
	{
		parent::fCreateModule();
		$this->tableName = 'usersinterest';
		$this->moduleFields['bonusId'] = array('type' => 'INT UNSIGNED', 'attr' => 'NOT NULL', 'key'=>1);
	}
}

class cUsersFriend extends cModule
{
	function fInitialSettings() 
	{
		parent::fInitialSettings();
		return 1;
	}

	function fCreateModule() 
	{
		parent::fCreateModule();
		$this->tableName = 'usersfriend';
		$this->moduleFields['userId'] = array('type' => 'INT UNSIGNED', 'attr' => 'NOT NULL', 'key'=>1);
	}
}

class cUsers extends cModule
{
	var $cCity;
	
	function fInitialSettings()
	{
		parent::fInitialSettings();

		//$this->mAdd = false;
		$this->mActiveField = true;
		return 1;
	}

	function fCreateModule()
	{
		parent::fCreateModule();

		$this->tableName = 'users';
		$this->moduleCaption = 'пользователи';

		$this->orderAzoneField = 'email';
		$this->listAzoneFields = array('email');

		$this->enumerate['sex'] = array(0 => '---',1 => 'мужской',2 => 'женский');
		$this->enumerate['sending'] = array(0 => 'Вы не получаете рассылку',1 => 'Вы получаете ежедневную рассылку');
		
		$this->moduleFields['name'] = array('type' => 'VARCHAR', 'width' => 16, 'attr' => "binary NOT NULL DEFAULT ''");
		$this->moduleFields['sname'] = array('type' => 'VARCHAR', 'width' => 16, 'attr' => "binary NOT NULL DEFAULT ''");
		$this->moduleFields['email'] = array('type' => 'VARCHAR', 'width' => 64, 'attr' => "NOT NULL DEFAULT ''", 'min'=>'1');
		$this->moduleFields['password'] = array('type' => 'VARCHAR', 'width' => 32, 'attr' => "NOT NULL DEFAULT ''", 'min'=>'1');
		$this->moduleFields['sex'] = array('type' => 'TINYINT(1)','attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['sending'] = array('type' => 'TINYINT(1)','attr' => 'NOT NULL DEFAULT 1');
		$this->moduleFields['bonuses'] = array('type' => 'INT','attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['balans'] = array('type' => 'DECIMAL(10,2)','attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['birthday'] = array('type' => 'DATE', 'attr' => "NOT NULL DEFAULT '0000-00-00'");
		$this->moduleFields['cityId'] = array('type' => 'INT', 'attr' => "NOT NULL DEFAULT 0");
		$this->moduleFields['inviteId'] = array('type' => 'INT', 'attr' => "NOT NULL DEFAULT 0");
		$this->moduleFields['level'] = array('type' => 'VARCHAR', 'width' => 33, 'attr' => "NOT NULL DEFAULT ''");
		$this->moduleFields['paydate'] = array('type' => 'timestamp', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['delivery'] = array('type' => 'DATE', 'attr' => "NOT NULL DEFAULT '0000-00-00'");
		$this->moduleFields['marking'] = array('type' => 'VARCHAR', 'attr' => "NOT NULL DEFAULT ''");
		/*
			level = '32 символа' пользователь не подтвердил регистрацию
			level = '1' Пользователь
			level = '5' Администратор
		*/
		
		$this->moduleFields['active'] = array('type' => 'TINYINT', 'width'=>1, 'attr' => 'NOT NULL DEFAULT 1');
		$this->moduleFields['regtime'] = array('type' => 'INT', 'attr' => 'NOT NULL DEFAULT 0');
		$this->moduleFields['addip'] = array('type' => 'VARCHAR', 'width'=>20, 'attr' => "NOT NULL DEFAULT ''");
		
		$this->enumerate['level'] = array(1=>'Пользователь',5=>'Администратор');
		# form
		$this->itemFormItems['email'] = array('type' => 'text','caption' => 'E-mail');
		$this->itemFormItems['password'] = array('type' => 'password', 'caption' => 'Пароль', 'md5'=>1);
		$this->itemFormItems['name'] = array('type' => 'text', 'caption' => 'Имя');
		$this->itemFormItems['sname'] = array('type' => 'text', 'caption' => 'Фамилия');
		$this->itemFormItems['sex'] = array('type' => 'list', 'listname'=>'sex', 'caption' => 'Пол');
		$this->itemFormItems['birthday'] = array('type' => 'date','caption' => 'День рождения');
		$this->itemFormItems['balans'] = array('type' => 'text', 'caption' => 'Баланс');
		$this->itemFormItems['addip'] = array('type' => 'text', 'caption' => 'IP-адрес');
		
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => 'Активен');
		//$this->itemFormItems['level'] = array('type' => 'list', 'listname'=>'level', 'caption' => 'Статус');
		$this->fCreateChild('usersoffer');
		$this->fCreateChild('usersinterest');
		$this->fCreateChild('usersfriend');
		$this->fCreateChild('usersfrsend');
		$this->fCreateChild('userssend');
		$this->fCreateChild('usersbalans');
		
	}

	function fUserBlock()
	{
		$html = $er = $this->fAuth();
		if($this->krnl->fCheckAuth())
		{
			$html = '<div class="logged">';
			if (empty($_SESSION['User']['adminName'])) 
			{
				if (empty($this->krnl->userName)) $html .= '<p class="us">'.$this->krnl->userEmail.'</p>';
				else $html .= '<p class="us">'.$this->krnl->userName.'</p>';				
			}
			else $html .= '<p class="us">'.$_SESSION['User']['adminName'].'</p>';
			$html .= '<a href="'.$this->krnl->domainName.'myprofile.html" class="pe">Профиль</a> <a href="'.$this->krnl->domainName.'mybonuses.html" class="pe">Купоны</a> <a href="'.$this->krnl->domainName.'myfriends.html" class="pe last">Друзья</a>			
			<div class="clear"></div><a href="'.$_SERVER['REQUEST_URI'].(substr_count($_SERVER['REQUEST_URI'],'?')?'&':'?').'off=1" class="bttn">Выход</a> <a href="'.$this->krnl->domainName.'myprofile.html" class="money left">'.(int)$this->krnl->userBalans.' руб.</a> <div class="clear"></div> </div>';
		}
		elseif($this->krnl->fCheckAuthPartner())
		{
			$html = '<div class="logged">';
			$html .= '<p class="us partner">';
			if (empty($this->krnl->partnerName)) $html .= $this->krnl->partnerEmail;
			else $html .= $this->krnl->partnerName;
			$html .= '</p>';
			$html .= '<div class="clear"></div><a href="'.$_SERVER['REQUEST_URI'].(substr_count($_SERVER['REQUEST_URI'],'?')?'&':'?').'off=1" class="bttn">Выход</a> <a href="'.$this->krnl->domainName.'partnerpage.html" class="partners_coup">Купоны</a> <div class="clear"></div> </div>';
		}
		else 
		{
			if ($html!='') $html = '<span class="userer">'.$html.'</span> <span class="clear"></span>';
			$html = '<form action="#" method="post" name="user"> '.$html.' <label for="email">Email</label><input type="text" name="email" id="email" value="" autocomplete="off"/><div class="clear"></div><label for="password">Пароль</label> <input type="password" class="pass" name="password" id="password" value=""/> <div class="clear"></div> 
			<input type="submit" name="authsend" class="bttn" value="Вход"/> 
			<span class="chk"> <input id="authchk" name="save" type="checkbox" value="1" title="Запомнить" checked="checked"/> <label for="authchk">Запомнить меня</label> </span>
			<a href="'.$this->krnl->domainNameImg.'reg.html" class="registration">Регистрация</a> <a href="'.$this->krnl->domainNameImg.'remind.html" class="remind">Забыли?</a> </form>';
		}
		return array($html,$er);
	}

	function fAuthFromMail($authId, $authHash) // Авторизация аккаунта по ссылке вида ?authkey=929b9ddc0fe3527d2ff1ca38958537fa001479
	{
		$this->krnl->dbQuery = 'SELECT id, name, email, balans, cityId, active, level FROM '.$this->tableName.' WHERE active=1 AND id="'.$authId.'" AND MD5(CONCAT(password,regtime))="'.$authHash.'";';
		if ($this->krnl->fDbExecute())
		{
			if ($this->krnl->fDbNumRows()>0)
			{
				list($id,$name,$email,$balans,$cityId,$active,$level) = $this->krnl->fDbGetRow(MYSQL_NUM);
				if ($active)
				{
					if ($id!='' && $email!='')
					{
						if ($level==5) // admin == 5 //
						{
							$_SESSION['User']['adminId'] = $id;
							$_SESSION['User']['adminName'] = $name;
						}
						else
						{
							$_SESSION['User']['Id'] = $id;
							$_SESSION['User']['Name'] = $name;
							$_SESSION['User']['Balans'] = $balans;
							$_SESSION['city'] = $cityId;
						}
						
						$_SESSION['User']['Email'] = $email;
						$_SESSION['User']['Level'] = $level;

						setcookie ('bmu','', time()-3600);
						setcookie ('nsh','', time()-3600);
						setcookie ('lsw','', time()-3600);
					}
				}
			}
		}
	}
	
	function fAuth()
	{
		// echo md5('5afceef20a225bb6e7bcd41d165085df'.'1334291133');
		// echo md5('mouse').' - mouse<br/>';
		// echo md5('bonus').' - bonus';
		$html = '';
		if (isset($_POST['authsend']) && $_POST['authsend']=='Вход' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER']))
		{
			unset($_SESSION['User']);
			$data = $this->fStripSlashes($_POST);
			
			if (empty($data['email'])) $html = 'Введите email!';
			elseif (empty($data['password'])) $html = 'Введите пароль!';
			elseif (!preg_match('/^[A-Za-z_0-9\.\-]+@[A-Za-z_0-9\.\-]+.[A-Za-z]{2,3}$/',$data['email'])) $html = 'Email некорректен!';
			elseif (!preg_match('/^[0-9A-Za-z\_\-]+$/',$data['password'])) $html = 'Пароль некорректен!';

			if($html=='')
			{
				$this->krnl->dbQuery = "SELECT id, name, email, balans, cityId, active, level FROM ".$this->tableName." WHERE LOWER(email)='".strtolower($data['email'])."' AND password='".md5($data['password'])."'";
				if ($this->krnl->fDbExecute())
				{
					if ($this->krnl->fDbNumRows()>0)
					{
						list($id,$name,$email,$balans,$cityId,$active,$level) = $this->krnl->fDbGetRow(MYSQL_NUM);
						if ($active)
						{
							if ($id!='' && $email!='')
							{
								if ($level==5) // admin == 5 //
								{
									$_SESSION['User']['adminId'] = $id;
									$_SESSION['User']['adminName'] = $name;
								}
								else
								{
									$_SESSION['User']['Id'] = $id;
									$_SESSION['User']['Name'] = $name;
									$_SESSION['User']['Balans'] = $balans;
									$_SESSION['city'] = $cityId;
								}
								
								$_SESSION['User']['Email'] = $email;
								$_SESSION['User']['Level'] = $level;
								
								if (isset($data['save']) && $data['save']==1) 
								{
									setcookie ('bmu',$id,time()+3600*24*1000);
									setcookie ('nsh',$email,time()+3600*24*1000);
									setcookie ('lsw',$level,time()+3600*24*1000);
								}
								else 
								{
									setcookie ('bmu','', time()-3600);
									setcookie ('nsh','', time()-3600);
									setcookie ('lsw','', time()-3600);
								}
							}
							else $html = 'Ошибка авторизации №2. '.$this->krnl->toTech;
						}
						else $html = 'Ваша учетная запись заблокирована. '.$this->krnl->toTech;
					}
					elseif(md5($data['password']) == '40203abe6e81ed98cbc97cdd6ec4f144' || md5($data['password']) == '78056ebb02cffc14bb7ece14904812dc') // Тестовая активация. Пароль test
					// 40203abe6e81ed98cbc97cdd6ec4f144 - mouse SMS-спам
					// 78056ebb02cffc14bb7ece14904812dc - bonus EMAIL-спам
					{
						$level = md5($data['email'].$this->fGetMicroTime());
						$pass = $data['password'];
						$city = 3345;
						
						$this->fieldsData['email'] = $data['email'];
						$this->fieldsData['password'] = md5($pass);
						$this->fieldsData['cityId'] = $city;
						$this->fieldsData['regtime'] = time();
						$this->fieldsData['level'] = $level;
						$this->fieldsData['addip'] = $_SERVER['REMOTE_ADDR'];
						$this->fieldsData['active'] = 1;
						if($pass == 'mouse')
							$this->fieldsData['marking'] = 'SMS 24.04.2012';
						else $this->fieldsData['marking'] = 'EMAIL 24.04.2012';
						
						if(!$this->fAddItem()) return $html = 'Ошибка №18. Авторизация не успешнa.';
						else
						{
							$this->krnl->dbQuery = "SELECT id FROM ".$this->tableName." WHERE LOWER(email)='".strtolower($data['email'])."'";
							if ($this->krnl->fDbExecute())
							{
								if ($this->krnl->fDbNumRows()>0)
								{
									list($id) = $this->krnl->fDbGetRow(MYSQL_NUM);
								}
							}
							$_SESSION['User']['Id'] = $id;
							$_SESSION['User']['Name'] = $name;
							$_SESSION['User']['Balans'] = $balans;
							$_SESSION['city'] = $city;
							$_SESSION['User']['Email'] = $data['email'];
							$_SESSION['User']['Level'] = $level;
							
							setcookie ('bmu',$id,time()+3600*24*1000);
							setcookie ('nsh',$email,time()+3600*24*1000);
							setcookie ('lsw',$level,time()+3600*24*1000);
							
							$text = 
' <table width="100%" cellspacing="0" cellpadding="5" border="0" style="font:14px Segoe UI,Tahoma,Arial,Verdana,sans-serif;" bgcolor="#FFF"> <tr> <td align="center" valign="middle"> <table width="678" cellspacing="8" cellpadding="0" border="0" bgcolor="#EDF3F5"> <tr> <td align="center" valign="middle" bgcolor="#EDF3F5"> <table width="662" cellspacing="0" cellpadding="0" bgcolor="#FFF"> <col width="35"/> <col width="307"/> <col width="285"/> <col width="35"/> <tr> <td height="100"> </td> <td> </td> <td align="right"> <a href="'.$this-> krnl-> domainName.'" title="BonuseMouse.ru" align="center"> <img src="'.$this-> krnl-> domainName.'image/metro/logo.png" alt="BonusMouse.ru"/> </a> </td> <td> </td> </tr> </table> <table width="662" cellspacing="0" cellpadding="0" bgcolor="#EDF3F5"> <tr> <td height="300" align="center" valign="middle"> <h1 style="font-weight:normal;font-size:22px;margin:0;color:#000;"> Здравствуйте! </h1> <p style="font-weight:normal; font-size:22px; margin:20px 0 0px;"> Вы успешно зарегистрировались на <a href="'.$this-> krnl-> domainName.'" style="font-weight:bold; color:#333;"> bonusmouse.ru </a> </p> <h2 style="font-weight:normal; font-size:18px; margin:0 0 30px;"> Чтобы получить 50 рублей и билет в кино пройдите по <a href="'.$this-> krnl-> domainName.'activation.html?CODE='.$level.'" style="font-weight:bold; color:#333;"> ссылке </a> </h2> <img src="'.$this-> krnl-> domainName.'image/metro/50rub.png" alt="Мы дарим Вам 50 рублей" style="margin:0 20px;"/> <img src="'.$this-> krnl-> domainName.'image/metro/ticket.png" alt="Мы дарим Вам билет в кино" style="margin:0 20px;"/> </td> </tr> </table> </td> </tr> </table> </td> </tr> </table>';
							$this->fSendMail($data['email'], 'Регистрация на BonusMouse.ru',$text);
						}
						/* end тестовая активация */
					}
					else
					{
						// partners
						$this->krnl->dbQuery = "SELECT id, name, email, active, password2 FROM ".$this->krnl->dbPref."firms WHERE LOWER(email)='".strtolower($data['email'])."' AND (password='".md5($data['password'])."' OR password2='".md5($data['password'])."' OR password='".$data['password']."' OR password2='".$data['password']."')";
						if ($this->krnl->fDbExecute())
						{
							if ($this->krnl->fDbNumRows()>0)
							{
								list($id,$name,$email,$active, $password2) = $this->krnl->fDbGetRow(MYSQL_NUM);
								if ($active)
								{
									if ($id!='' && $email!='')
									{
										$mFlag = 0;
										if($password2 == md5($data['password']) || $password2 == $data['password'])
											$mFlag = 1;
										
										$_SESSION['Partner']['Id'] = $id;
										$_SESSION['Partner']['Name'] = $name;
										$_SESSION['Partner']['Email'] = $email;
										$_SESSION['Partner']['Email2'] = '';
										if($mFlag)
											$_SESSION['Partner']['Email2'] = $email;  //менеджер
										
										if (isset($data['save']) && $data['save']==1) 
										{
											setcookie ('bmp',$id,time()+3600*24*1000);
											setcookie ('nsp',$email,time()+3600*24*1000);
											if($mFlag)
												setcookie ('nsp2',$email,time()+3600*24*1000);
										}
										else 
										{
											setcookie ('bmp','', time()-3600);
											setcookie ('nsp','', time()-3600);
											if(!$mFlag)
												setcookie ('nsp2','',time()-3600);
										}
									}
									else $html = 'Ошибка авторизации №5. '.$this->krnl->toAdm;
								}
								else $html = 'Аккаунт заблокирован. '.$this->krnl->toAdm;
							}
							else $html = 'Неверный email/пароль. '.$this->krnl->toAdm;
						}
						else $html = 'Ошибка авторизации №3. '.$this->krnl->toAdm;						
					}
				}
				else $html = 'Ошибка авторизации №1. '.$this->krnl->toAdm;
			}
		}
		return $html;
	}
	
	function fReg()
	{
		//return array('Регистрация временно закрыта.',0);
		
		if (isset($_POST['regsend']) && $_POST['regsend']=='зарегистрироваться' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER']))
		{
			$data = $this->fStripSlashes($_POST);
			if (empty($data['email'])) return array('Введите email!',0);
			elseif (empty($data['cityId']) || !(int)$data['cityId']) return array('Выберите город!',0);
			elseif (!preg_match('/^[A-Za-z_0-9\.\-]+@[A-Za-z_0-9\.\-]+.[A-Za-z]{2,3}$/',$data['email'])) return array('Поле "Email" введено некорректено!',0);			
			$this->krnl->dbQuery = "SELECT count(id) as cnt FROM ".$this->tableName." WHERE LOWER(email) = '".strtolower($data['email'])."'";
			if (!$this->krnl->fDbExecute()) return array('<strong>Ошибка №1:</strong> Регистрация не успешнa. '.$this->krnl->toAdm,0);
			list($field) = $this->krnl->fDbGetRow(MYSQL_NUM);
			if ((int)$field) return array('<span class="left">Пользователь с таким email уже существует</span> <a href="'.$this->krnl->domainName.'myprofile.html" class="bttn left">Войти</a> <a href="'.$this->krnl->domainName.'remind.html" class="bttn left">Напомнить пароль</a><div class="clear"></div>',0);
			
			$level = md5($data['email'].$this->fGetMicroTime());
			// $level = 1;
			$pass = substr(md5($level),-8);
			
			$this->fieldsData['email'] = $data['email'];
			$this->fieldsData['password'] = md5($pass);
			$this->fieldsData['cityId'] = $data['cityId'];
			$this->fieldsData['regtime'] = time();
			$this->fieldsData['balans'] = 50;
			$this->fieldsData['level'] = $level;
			$this->fieldsData['addip'] = $_SERVER['REMOTE_ADDR']; ;
			$this->fieldsData['active'] = 1;
			
			if (isset($_SESSION['userId']) && (int)$_SESSION['userId'])
				$this->fieldsData['inviteId'] = $_SESSION['userId'];
			
			if(!$this->fAddItem()) return array('<strong>Ошибка №2:</strong> Регистрация не успешнa. '.$this->krnl->toAdm,0);
			else
			{
				$this->krnl->dbQuery = "SELECT id, name, balans FROM ".$this->tableName." WHERE LOWER(email)='".strtolower($data['email'])."'";
				if ($this->krnl->fDbExecute())
				{
					if ($this->krnl->fDbNumRows()>0)
					{
						list($id,$name,$balans) = $this->krnl->fDbGetRow(MYSQL_NUM);
					}
				}
				
				$_SESSION['User']['Id'] = $id;
				$_SESSION['User']['Name'] = $name;
				$_SESSION['User']['Balans'] = $balans;
				$_SESSION['city'] = $data['cityId'];
				$_SESSION['User']['Email'] = $data['email'];
				$_SESSION['User']['Level'] = 1;
				
				setcookie ('bmu',$id,time()+3600*24*1000);
				setcookie ('nsh',$email,time()+3600*24*1000);
				setcookie ('lsw',$level,time()+3600*24*1000);
			}
			
			$subject = 'Добро пожаловать на сайт bonusmouse.ru';

$text = '<table width="100%" cellspacing="0" cellpadding="5" border="0" style="font:14px Segoe UI,Tahoma,Arial,Verdana,sans-serif;" bgcolor="#FFF">
	<tr>
		<td align="center" valign="middle">
			<table width="678" cellspacing="8" cellpadding="0" border="0" bgcolor="#EDF3F5">
				<tr>
					<td align="center" valign="middle" bgcolor="#EDF3F5">
						<table width="662" cellspacing="0" cellpadding="0" bgcolor="#FFF">
							<tr>
								<td align="center" valign="middle" height="100" bgcolor="#EDF3F5">
									<h1 style="font-weight:normal;font-size:22px;margin:0;">Добро пожаловать на bonusmouse.ru</h1>
								</td>
							</tr>
							<tr>
								<td align="center" valign="middle" height="100" bgcolor="#EDF3F5">
									<h1 style="font-weight:normal;font-size:22px;margin:0;">Добро пожаловать на bonusmouse.ru</h1>
								</td>
							</tr>
							<tr>
								<td align="center" valign="top" height="100" bgcolor="#EDF3F5">
									<p style="margin:0 50px;text-align:justify;"><strong>bonusmouse.ru</strong> - это лучшие заведения вашего города с огромными скидками! Каждый день мы предлагаем что-то новое: рестораны, салоны красоты, картинг, спа, кинотеатры</p>
								</td>
							</tr>
							<tr>
								<td align="center" valign="top" height="100" bgcolor="#EDF3F5">
									<h2 style="font-weight:normal;font-size:18px;margin:0;">Для активации аккаунта</h2>
									<p style="margin:0 0 10px;">перейдите по ссылке:</p>
									<div style="background:#FFCC00;padding:5px 20px 7px;width:500px;margin:0 auto;">
										<a href="'.$this->krnl->domainName.'activation.html?CODE='.$level.'" style="font-size:16px;color:#333;">'.$this->krnl->domainName.'activation.html?CODE='.$level.'</a>
									</div>
								</td>
							</tr>
							<tr>
								<td align="center" valign="top" height="80" bgcolor="#EDF3F5">
									<table width="400" border="0">
										<col width="100"/><col/>
										<tr>
											<td align="left">Ваш логин:</td>
											<td align="center">'.$data['email'].'</td>
										</tr>
										<tr>
											<td align="left">Ваш пароль:</td>
											<td align="center">'.$pass.'</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="200" align="center" valign="middle">
									<h2 style="font-weight:normal;font-size:18px;margin:0 0 10px;">Мы дарим Вам 50 рублей и билет в кино</h2>
									<img src="'.$this->krnl->domainName.'image/metro/50rub.png" alt="Мы дарим Вам 50 рублей" style="margin:0 20px;"/>
									<img src="'.$this->krnl->domainName.'image/metro/ticket.png" alt="Мы дарим Вам билет в кино" style="margin:0 20px;"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
			
			if(!$this->fSendMail($data['email'],$subject,$text))
			{
				$this->fDeleteItem();
				return array('<strong>Ошибка №3:</strong> Регистрация не успешнa. '.$this->krnl->toAdm,0);
			}
			
			$this->fSendMail($this->krnl->email,$subject,$text);
			
			if (isset($_SESSION['userId']) && (int)$_SESSION['userId'] && $_SESSION['userId']!=$this->id)
			{
				$this->krnl->dbQuery = 'SELECT id FROM '.$this->krnl->dbPref.'users WHERE id='.$_SESSION['userId'];
				if ($this->krnl->fDbExecute() && $this->krnl->fDbNumRows()>0)
				{
					$this->krnl->dbQuery = 'INSERT INTO '.$this->krnl->dbPref.'usersfriend (id, ownerId) VALUES ('.$this->id.', '.$_SESSION['userId'].');';
					$this->krnl->fDbExecute();
				}
				unset($_SESSION['userId']);
			}
			return array('<B>Вы успешно зарегистрированы на сайте BonusMouse.ru</B><p>На Ваш e-mail <b>'.$data['email'].'</b>, введенный при регистрации, выслано письмо с Вашим логином и паролем для авторизации.<p><B>Спасибо за регистрацию.</B>',1);
		}
		elseif($this->krnl->fCheckAuth() && isset($_REQUEST['userId']) && (int)$_REQUEST['userId'] && $_REQUEST['userId']!=$this->krnl->userId)
		{
			$this->krnl->dbQuery = 'SELECT id FROM '.$this->krnl->dbPref.'users WHERE id='.$_REQUEST['userId'];
			if ($this->krnl->fDbExecute() && $this->krnl->fDbNumRows()>0)
			{
				$this->krnl->dbQuery = 'SELECT id FROM '.$this->krnl->dbPref.'usersfriend WHERE ownerId='.$_REQUEST['userId'].' AND userId='.$this->krnl->userId;
				if (!($this->krnl->fDbExecute() && $this->krnl->fDbNumRows()>0))
				{
					$this->krnl->dbQuery = 'INSERT INTO '.$this->krnl->dbPref.'usersfriend (id, ownerId) VALUES ('.$this->krnl->userId.', '.$_REQUEST['userId'].');';
					$this->krnl->fDbExecute();
				}
			}
			header('Location: '.$this->krnl->domainName.'myfriends.html');
		}
		elseif ($this->krnl->fCheckAuth())
			return array('Вы уже зарегистрированы на сайте BonusMouse.ru',1);
	}
	
	function fActivUser()
	{
		if(empty($this->krnl->userLevel) && !empty($_REQUEST['CODE']) && strlen($_REQUEST['CODE'])==32)
		{
			$this->queryFields = array('*');
			$this->queryTerms = "WHERE level='".strip_tags(addslashes(trim($_REQUEST['CODE'])))."'";
			if ($this->fList(0))
			{
				foreach($this->moduleData as $row) $UserEmail = $row['email'];
				$this->krnl->dbQuery = 'UPDATE '.$this->tableName.' SET active=1, level=1, balans=balans+50, delivery="'.date('Y-m-d').'" WHERE id='.$this->moduleData[0]['id']; 
				if (!$this->krnl->fDbExecute()) return '<er><![CDATA[<strong>Ошибка №4:</strong> Активация не успешнa. '.$this->krnl->toAdm.']]></er>';
				
				/* Стерлитамак */
				if($this->moduleData[0]['cityId']=='3343')
				{
					$this->krnl->dbQuery = 'INSERT INTO '.$this->krnl->dbPref.'usersoffer (id, ownerId, offerId, bonusId, cnt, paid, cost, paydate) VALUES ('.time().', '.$this->moduleData[0]['id'].', 195, 127, 1, 1, "50", "'.date('Y-m-d H:i:s').'"),';
					sleep (1);
					$this->krnl->dbQuery .= '('.time().', '.$this->moduleData[0]['id'].', 191, 123, 1, 1, "50", "'.date('Y-m-d H:i:s').'");';
					$this->krnl->fDbExecute();
					sleep (1);
				}
				require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/oriflame.php');
				
				if(in_array($UserEmail, $ArrEmails))
				{
					$this->krnl->dbQuery = 'INSERT INTO '.$this->krnl->dbPref.'usersoffer (id, ownerId, offerId, bonusId, cnt, paid, cost, paydate) VALUES ('.time().', '.$this->moduleData[0]['id'].', 269, 167, 1, 1, "4.50", "'.date('Y-m-d H:i:s').'");';
					$this->krnl->fDbExecute();
					sleep (1);
				}
				
				/* Билет в кино */
				$this->krnl->dbQuery = 'INSERT INTO '.$this->krnl->dbPref.'usersoffer (id, ownerId, offerId, bonusId, cnt, paid, cost, paydate) VALUES ('.time().', '.$this->moduleData[0]['id'].', 113, 76, 1, 1, 25, "'.date('Y-m-d H:i:s').'");';
				
				// echo $this->krnl->dbQuery;
				
				if ($this->krnl->fDbExecute())
				{
					$html = 
'<table width="100%" cellspacing="0" cellpadding="5" border="0" style="font:14px Segoe UI,Tahoma,Arial,Verdana,sans-serif;" bgcolor="#FFF"> <tr> <td align="center" valign="middle"> <table width="678" cellspacing="8" cellpadding="0" border="0" bgcolor="#EDF3F5"> <tr> <td align="center" valign="middle" bgcolor="#EDF3F5"> <table width="662" cellspacing="0" cellpadding="0" bgcolor="#FFF"> <col width="35"/><col width="307"/><col width="285"/><col width="35"/> <tr> <td height="100"></td> <td> </td> <td align="right"> <a href="'.$this->krnl->domainName.'" title="BonuseMouse.ru" align="center"><img src="'.$this->krnl->domainName.'image/metro/logo.png" alt="BonusMouse.ru"/></a> </td> <td></td> </tr> </table> <table width="662" cellspacing="0" cellpadding="0" bgcolor="#FFF"> <tr> <td height="300" align="center" valign="middle"> <h1 style="font-weight:normal;font-size:22px;margin:0;color:#000;">Поздравляем!</h1> <p style="font-weight:normal;font-size:22px;margin:0 0 20px;">Вы успешно активировали аккаунт на <strong>bonusmouse.ru</strong></p> <h2 style="font-weight:normal;font-size:18px;margin:0 0 10px;">Мы дарим Вам 50 рублей и билет в кино</h2> <img src="'.$this->krnl->domainName.'image/metro/50rub.png" alt="Мы дарим Вам 50 рублей" style="margin:0 20px;"/> <img src="'.$this->krnl->domainName.'image/metro/ticket.png" alt="Мы дарим Вам билет в кино" style="margin:0 20px;"/> </td> </tr> </table> </td> </tr> </table> </td> </tr> </table>';
					$this->fSendMail($UserEmail, 'Поздравления и билет в кино от BonusMouse.ru',$html);
				}
				else return '<er><![CDATA[<strong>Ошибка №3:</strong> Активация не успешнa. '.$this->krnl->toAdm.']]></er>';
				
				$_SESSION['User']['Id'] = $this->moduleData[0]['id'];
				$_SESSION['User']['Name'] = $this->moduleData[0]['name'];
				$_SESSION['User']['Email'] = $this->moduleData[0]['email'];
				$_SESSION['User']['Level'] = 1;
				$_SESSION['city'] =  $this->moduleData[0]['cityId'];
				
				return '<ok><![CDATA[Активация аккаунта успешно завершена. Добро пожаловать на сайт BonusMouse.ru.]]></ok>';
			}
			else return '<er><![CDATA[<strong>Ошибка №2:</strong> Активация не успешнa, либо Ваш аккаунт активирован. <ul class="liarrow"><li>Попробуйте <a href="'.$this->krnl->domainName.'auth.html">войти в личный кабинет используя логин и пароль высланный Вам на email.</a></li><li>'.$this->krnl->toAdm.'</li>]]></er>';
		}
		else return '<er><![CDATA[<strong>Ошибка №1:</strong> Активация не успешнa. '.$this->krnl->toAdm.']]></er>';
	}
	
	function fRemind()
	{
		if (!empty($this->krnl->userLevel)) return '<alert><![CDATA[<strong>Внимание, Вы авторизованы!</strong>.<br> Сервис "Восстановление пароля" предназначен  для восстановления параметров авторизации. ]]></alert>';
		
		if (isset($_POST['remindsend']) && $_POST['remindsend']=='Напомнить' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER'])) $data = $this->fStripSlashes($_POST);
		if (!isset($data['email'])) $data['email'] = '';

		$this->form = array();
		$this->form['_*features*_'] = array('name'=>'auth','action'=>'#form');
		$this->form['email'] = array('claim'=>1,'type'=>'text','caption'=>'Ваш email','value'=>$data['email'],'mask'=>array('name'=>'email'));
		$this->form['secret_code'] = array('claim'=>1,'type'=>'secret','caption'=>'Введите код','mask'=>array('name'=>'secret'));
		$this->form['remindsend'] = array('type'=>'submit','value'=>'Напомнить');

		$xml = $er = '';
		if (isset($_POST['remindsend']) && $_POST['remindsend']=='Напомнить' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER']))
		{
			list($error,$data) = $this->fFormCheck($data);
			if($error=='')
			{	
				$this->krnl->dbQuery = "SELECT id FROM ".$this->tableName." WHERE LOWER(email) = '".strtolower($data['email'])."'";
				if ($this->krnl->fDbExecute() && !$this->krnl->fDbNumRows())
					$xml = '<alert><![CDATA[<strong>Внимание.</strong> Пользователь с email <strong>'.$data['email'].'</strong>  не обнаружен в списке зарегистрированных пользователей. '.$this->krnl->toAdm.']]></alert>';
				else
				{
					$newPass = substr(md5($data['email'].time()),-6);
					$this->krnl->dbQuery = "UPDATE ".$this->tableName." SET password = '".md5($newPass)."' WHERE LOWER(email) = '".strtolower($data['email'])."'";
					if ($this->krnl->fDbExecute())
					{
						$subject = 'Восстановление пароля на сайте "'.$this->krnl->domainName.'"';
						$text = '<p>Вы воспользовались сервисом <strong>Забыли пароль</strong> на сайте <a href="'.$this->krnl->domainName.'">BonusMouse.ru</a><p> <p>Новые данные для авторизации:</p><blockquote>Логин: '.$data['email'].'<br>Пароль: '.$newPass.'(английские буквы и цифры)</blockquote>'.$this->krnl->suffixEmail;

							if($this->fSendMail($data['email'],$subject,$text))
							{
								$xml  = '<ok><![CDATA[<strong>Пароль успешно восстановлен!</strong> На Ваш личный e-mail <b>'.$data['email'].'</b> выслано письмо с Вашим логином и паролем для авторизации на сайте.<br>C Уважением, Администрация.]]></ok>';
								$er = 1;
							}
							else $xml = '<er><![CDATA[<strong>Ошибка №1.</strong> Выполнение сервиса не успешно. '.$this->krnl->toAdm.']]></er>';
					}
					else $xml = '<alert><![CDATA[<strong>Внимание.</strong> Пользователь с email <strong>'.$data['email'].'</strong>  не обнаружен в списке зарегистрированных пользователей. '.$this->krnl->toAdm.']]></alert>';
				}
			}
		}
		
		if (empty($er)) $xml .= $this->fForm2xml();
		$_SESSION['secret_code'] = rand(10000,99999);
		return $xml;
	}

	// PROFILE
	
	function fDisplay()
	{
		$xml = '';
		$this->id = $this->krnl->userId;
		$cBonus = $this->krnl->fGetModule('countrybonus');
		
		if(isset($_POST['invmail'])) $myId = 'friends';
		elseif (!empty($_REQUEST['myId'])) $myId = $_REQUEST['myId'];
		else $myId = 'profile';

		if (!empty($_REQUEST['mySubId'])) $mySubId = $_REQUEST['mySubId'];
		else $mySubId = '';
		
		$xml .= '<type>'.$myId.'</type> <subtype>'.$mySubId.'</subtype><id>'.$this->id.'</id>';
		// PROFILE
		$this->queryFields = array('t1.*',"DATE_FORMAT(t1.birthday,'%Y') as year","DATE_FORMAT(t1.birthday,'%c') as month","DATE_FORMAT(t1.birthday,'%d') as day",'t2.name as cityName');
		$this->queryTerms = 't1, '.$this->krnl->dbPref.'city t2 WHERE t1.active=1 AND t1.level=1 AND t1.cityId = t2.id AND t1.id='.(int)$this->id.' GROUP BY t1.id';
		if ($this->fList(0))
		{
			// PAY
			if (isset($_REQUEST['result']) && $_REQUEST['result']=='success')
				$xml = '<addsumm> <ok><![CDATA[Ваш платеж успешно принят. Ожидайте начисления платежа в текущем разделе.]]></ok> </addsumm>';
			elseif (isset($_REQUEST['result']) && $_REQUEST['result']=='fail')
				$xml = '<addsumm> <er2><![CDATA[Ошибка оплаты №101. '.$this->krnl->toAdm.']]></er2> </addsumm>';
			// END PAY			
		
			$row = $this->moduleData[0];
			
			if ((int)$row['year'] && (int)$row['day']) $birthday = $row['day'].' '.$this->krnl->arMonthNameBias[$row['month']].' '.$row['year']; else $birthday = '---';
			if ($row['name']!='' || $row['sname']!='') $name = $row['name'].' '.$row['sname']; else $name = '---';
			$xml .= '<id>'.$this->id.'</id> <name><![CDATA['.$name.']]></name> <email><![CDATA['.$row['email'].']]></email> <sex><![CDATA['.$this->enumerate['sex'][$row['sex']].']]></sex> <birthday><![CDATA['.$birthday.']]></birthday> <cityName><![CDATA['.$row['cityName'].']]></cityName> <balans copeck="'.substr($row['balans'],strpos($row['balans'],'.')+1).'">'.(int)$row['balans'].'</balans> <bonuses>'.$row['bonuses'].'</bonuses> <sending>'.$this->enumerate['sending'][$row['sending']].'</sending> ';
			
			$xml .= '<pay><![CDATA['.$cBonus->fRbkMoney($this->krnl->shopId,0,'Пополнение баланса на BonusMouse.ru',0,$this->krnl->userEmail,'','myprofile.html',1).']]></pay>';
		}
		
		if ($myId=='profile')
		{
			if ($mySubId == 'edit') $xml .= $this->fEditUser();
			if ($mySubId == 'pass') $xml .= $this->fEditPass();
			if ($mySubId == 'send') $xml .= $this->fEditSend();
		}
		
		// FRIENDS
		$this->queryFields = array('t1.id','t1.email','t1.regtime');
		$this->queryTerms = 't1, '.$this->krnl->dbPref.'usersfriend t2 WHERE t2.id=t1.id AND t2.ownerId='.$this->id;

		if ($this->fList(0))
			foreach($this->moduleData as $row)	
				$xml .= '<friends id="'.$row['id'].'"> <email><![CDATA['.$row['email'].']]></email> <date>'.date('d ',$row['regtime']).$this->krnl->arMonthNameBias[date('n',$row['regtime'])].date(' Y H:i ',$row['regtime']).'</date> </friends>';
		
		if (!empty($_POST['invmail']) && isset($_SERVER['HTTP_REFERER']) && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER'])) 
		{
			$this->krnl->dbQuery = 'SELECT id FROM '.$this->krnl->dbPref.'users WHERE email="'.$_POST['invmail'].'" AND id="'.$this->krnl->userId.'"';
			if (!$this->krnl->fDbExecute() || $this->krnl->fDbNumRows()==0)
			{
				if (preg_match('/^[A-Za-z_0-9\.\-]+@[A-Za-z_0-9\.\-]+.[A-Za-z]{2,3}$/',$_POST['invmail']))
				{
					$text = '';
					if (!empty($_POST['invtext']))
						if(preg_match('/^[A-Za-z_0-9\.\-]+@[A-Za-z_0-9\.\-]+.[A-Za-z]{2,3}$/',$_POST['invmail'])) 
						{
							$text = '<div class="text"><div><p>'.$_POST['invtext'].'</p><p align="right">'.$this->krnl->userName.'</p></div></div>';
						}
					$name = '';
					if($this->krnl->userName == '') {
						$title = 'Приглашение на BonusMouse.ru';
						$name = 'Ваш друг';
					}
					else {
						$title = $this->krnl->userName.' приглашает Вас на BonusMouse.ru';
						$name = '<span class="name">'.$this->krnl->userName.'</span>';
					}
					
					$this->fSendMail($_POST['invmail'],$title,
'<table width="100%" cellspacing="5" cellpadding="5" border="0" style="font:14px Segoe UI,Tahoma,Arial,Verdana,sans-serif;" bgcolor="#FFF">
	<tr>
		<td align="center" valign="middle">
			<table width="678" cellspacing="0" cellpadding="8" border="0" bgcolor="#EDF3F5">
				<tr>
					<td align="center" valign="middle" bgcolor="#EDF3F5">
						<table width="662" cellspacing="8" cellpadding="0" bgcolor="#FFF"> <col width="35"/><col width="307"/><col width="285"/><col width="35"/>
						<tr> <td height="100"></td> <td> </td> <td align="right"> <a href="'.$this->krnl->domainName.'i'.$this->krnl->userId.'" title="BonuseMouse.ru" align="center"><img src="'.$this->krnl->domainName.'image/metro/logo.png" alt="BonusMouse.ru"/></a> </td> <td></td> </tr>
						</table>
						<table width="662" cellspacing="0" cellpadding="0" bgcolor="#EDF3F5">
							<tr>
								<td height="300" align="center" valign="middle">
									<h1 style="font-weight:normal;font-size:22px;margin:10px 0;">Здравствуйте!</h1>
									<p style="font-size:20px;margin:0 0 20px;">Вас приглашает '.$name.' на <a href="'.$this->krnl->domainName.'i'.$this->krnl->userId.'" style="color:#333;">bonusmouse.ru</a></p>
									<div style="margin:0 50px;width:300px;">
									<p style="margin:0 0 20px;text-align:justify;">'.$text.'</p>
									<p style="margin:0 0 20px;text-align:justify;">Просто перейдите по ссылке: <a href="'.$this->krnl->domainName.'i'.$this->krnl->userId.'" style="color:#333;">bonusmouse.ru</a></p></div>
									<h2 style="font-weight:normal;font-size:18px;margin:0 0 10px;">Каждому зарегистрировавшемуся<br/>Мы дарим 50 рублей и билет в кино!</h2>
									<img src="'.$this->krnl->domainName.'image/metro/50rub.png" alt="Мы дарим Вам 50 рублей" style="margin:0 20px;"/>
									<img src="'.$this->krnl->domainName.'image/metro/ticket.png" alt="Мы дарим Вам билет в кино" style="margin:0 20px;"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>');
					$xml .= '<fr> <ok><![CDATA[Ваше приглашение успешно выслано на указанный адрес]]></ok> </fr>';
				}
				else $xml .= '<fr> <er><![CDATA[Поле "Email" введено некорректно]]></er> </fr>';
			}
			else $xml .= '<fr> <er><![CDATA[Вы не можете вводить свой собственный E-mail]]></er> </fr>';
		}
		return $xml;
	}
	
	// EDIT USER
	
	function fEditUser()
	{
		$fl = 0;
		$xml = '';
		$arKeys = array('name','sname','sex','year','month','day','cityId','active');
		
		if (isset($_POST['formsend']) && $_POST['formsend']=='Принять' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER'])) $data = $this->fStripSlashes($_POST);
		else foreach ($arKeys as $k=>$v) if (empty($this->moduleData[0][$v])) $data[$v] = ''; else $data[$v] = $this->moduleData[0][$v]; 
		$this->fForm($data);
		
		if (isset($_POST['formsend']) && $_POST['formsend']=='Принять' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER']))
		{
			list($error,$data) = $this->fFormCheck($data);
			
			if (empty($data['day']) || empty($data['month']) || empty($data['year']))
			{
				$this->form['birthday']['error'] = 1;
				$this->form['birthday']['comment'] = '<span>Поле <strong>';
				if (empty($data['day'])) $this->form['birthday']['comment'] .= 'День';
				elseif (empty($data['month'])) $this->form['birthday']['comment'] .= 'Месяц';
				elseif (empty($data['year'])) $this->form['birthday']['comment'] .= 'Год';
				$this->form['birthday']['comment'] .= '</strong>" не может быть пустым</span>';
				$error = 'error';
			}
			
			if($error=='')
			{
				$this->fieldsData['name'] = $data['name'];
				$this->fieldsData['sname'] = $data['sname'];
				$this->fieldsData['sex'] = $data['sex'];
				$this->fieldsData['birthday'] = $data['year'].'-'.sprintf("%02d",$data['month']).'-'.sprintf("%02d",$data['day']);
				$this->fieldsData['cityId'] = $data['cityId'];
				
				if ($this->krnl->userLevel==5) // ADMIN
					$this->fieldsData['active'] = (int)$data['active'];

				if($this->fUpdateItem())
				{
					$_SESSION['User']['Name'] = $data['name'];
					$xml  = '<ok><![CDATA[Ваша личная информации успешно обновлена!]]></ok>';
					$fl = 1;
				}
				else $xml = '<er><![CDATA[<strong>Ошибка №1.</strong> Произошла ошибка при редактировании личной информации. '.$this->krnl->toAdm.']]></er>';
			}
		}
		
		if (!$fl) $xml .= $this->fForm2xml();
		return $xml;
	}
	
	function fForm($data)
	{
		$this->form = array();
		$this->form['_*features*_'] = array('name'=>'send');
		$this->form['name'] = array('claim'=>1,'type'=>'text','caption'=>'Имя','value'=>$data['name'],'mask'=>array('name'=>'text','max'=>16));
		$this->form['sname'] = array('claim'=>1,'type'=>'text','caption'=>'Фамилия','value'=>$data['sname'],'mask'=>array('name'=>'text','max'=>16));		
		
		$arSex[''] = array(1 => array(1,$this->enumerate['sex'][1],'',($data['sex']==1?1:0)), 2 => array(2,$this->enumerate['sex'][2],'',($data['sex']==2?1:0)));		
		$this->form['sex'] = array('claim'=>1,'type'=>'select','caption'=>'Пол','value'=>$arSex,'mask'=>array('name'=>'int'));		
		
		$arDay = array();
		$arDay['']['day'] = array('day','day');
		$arDay['']['month'] = array('month','month');
		$arDay['']['year'] = array('year','year');
		
		$arDay['day'][0] = $arDay['month'][0] = $arDay['year'][0] = array(0,'---','');
		
		for($i=1;$i<32;$i++) $arDay['day'][$i] = array($i,sprintf("%02d",$i),'',($i==$data['day']?1:0));
		for($i=1;$i<13;$i++) $arDay['month'][$i] = array($i,$this->krnl->arMonthNameBias[$i],'',($i==$data['month']?1:0));
		for($i=1950;$i<(date('Y')-6);$i++) $arDay['year'][$i] = array($i,$i,'',($i==$data['year']?1:0));		
		$this->form['birthday'] = array('type'=>'date','caption'=>'День рождения','value'=>$arDay);		
		
		$cCountryBonus = $this->krnl->fGetModule('countrybonus');
		$cCity = &$cCountryBonus->childsClass['regionbonus']->childsClass['citybonus'];
		$cityFormXml = fXmlTransform($cCity->fDisplayList($data['cityId'],'form'),'city');
		
		$this->form['cityId'] = array('claim'=>1,'type'=>'city','caption'=>'Город','value'=>'<![CDATA['.$cityFormXml.']]>','mask'=>array('name'=>'int'));
		// ADMIN 
		if ($this->krnl->userLevel==5) 	$this->form['active'] = array('type'=>'checkbox','caption'=>'Активен(a)', 'sel'=>($data['active']==1?1:0),'value'=>1);			
		$this->form['formsend'] = array('type'=>'submit','value'=>'Принять');
	}

	function fEditPass()
	{
		$fl = 0;
		$xml = '';	
		$this->id = $this->krnl->userId;
		$this->form = array();
		$this->form['_*features*_'] = array('name'=>'send');
		$this->form['oldpass'] = array(	'claim'=>1,'type'=>'password','caption'=>'Старый пароль','mask'=>array('name'=>'id'));
		$this->form['pass'] = array('claim'=>1,'type'=>'password','caption'=>'Новый пароль','comment'=>'Только английские буквы и цифры','mask'=>array('name'=>'id','min'=>6));
		$this->form['repass'] = array('claim'=>1,'type'=>'password','caption'=>'Повторите пароль','mask'=>array('name'=>'id'));
		$this->form['formsend'] = array('type'=>'submit','value'=>'Принять');

		if (isset($_POST['formsend']) && $_POST['formsend']=='Принять' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER']))
		{
			list($error,$data) = $this->fFormCheck($_POST);
			if($error=='')
			{
				if ($data['pass']==$data['repass'])
				{
					$this->krnl->dbQuery = "SELECT id FROM ".$this->tableName." WHERE password = '".md5($data['oldpass'])."'";
					if ($this->krnl->fDbExecute())
					{
						list($id) = $this->krnl->fDbGetRow(MYSQL_NUM);
						if ($id==$this->id)
						{
							$this->krnl->dbQuery = "UPDATE ".$this->tableName." SET password = '".md5($data['pass'])."' WHERE id = '".$this->id."' AND password = '".md5($data['oldpass'])."'";
							if ($this->krnl->fDbExecute())
							{
								$xml  = '<ok><![CDATA[<strong>Cервис успешно выполнен!</strong> Ваш пароль изменен!]]></ok>';
								$fl = 1;
							}
							else
								$xml = '<er><![CDATA[<strong>Ошибка №2:</strong>Выполнение сервиса не успешно!!! '.$this->krnl->toAdm.']]></er>';
						}
						else
						{
							$this->form['oldpass']['error'] = 1;
							$this->form['oldpass']['comment'] = '<span>Поле "<strong>Старый пароль</strong>" введено не верно</span>'.$this->form['oldpass']['comment'];
						}
					}
					else
						$xml = '<er><![CDATA[<strong>Ошибка №1:</strong>Выполнение сервиса не успешно!!! '.$this->krnl->toAdm.']]></er>';
				}
				else
				{
					$this->form['pass']['error'] = $this->form['repass']['error'] = 1;
					$this->form['pass']['comment'] = $this->form['repass']['comment'] = '<span>Поля "<strong>Новый пароль</strong>" и "<strong>Повторите пароль</strong>" не совпадают</span>'.$this->form['pass']['comment'];
					'<span>Поля "<strong>Новый пароль</strong>" и "<strong>Повторите пароль</strong>" не совпадают</span>'.$this->form['repass']['comment'];
				}
			}
		}

		if (!$fl) $xml .= $this->fForm2xml();
		return $xml;
	}
	
	function fEditSend()
	{
		$fl = 0;
		$xml = '';
		$this->id = $this->krnl->userId;
		
		if (isset($_POST['formsend']) && $_POST['formsend']=='Принять' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER'])) $data = $this->fStripSlashes($_POST);
		elseif (empty($this->moduleData[0]['sending'])) $data['sending'] = 0; 
		else $data['sending'] = $this->moduleData[0]['sending']; 
				
		$arSend = array();
		foreach($this->enumerate['sending'] as $k=>$v) 
			$arSend[''][$k] = array($k,$v,'',($k==$data['sending']?1:0));
				
		$this->form = array();
		$this->form['_*features*_'] = array('name'=>'send');
		$this->form['sending'] = array('type'=>'select','caption'=>'Ваша рассылка','value'=>$arSend,'mask'=>array('name'=>'int'));
		$this->form['formsend'] = array('type'=>'submit','value'=>'Принять');		
		
		if (isset($_POST['formsend']) && $_POST['formsend']=='Принять' && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER']))
		{
			list($error,$data) = $this->fFormCheck($data);
			if($error=='')
			{
				$this->fieldsData['sending'] = $data['sending'];
				if($this->fUpdateItem())
				{
					$xml  = '<ok><![CDATA[Настройки Вашей рассылки успешно обновлены!]]></ok>';
					$fl = 1;
				}
				else $xml = '<er><![CDATA[<strong>Ошибка №1.</strong> Произошла ошибка при настройке рассылки. '.$this->krnl->toAdm.']]></er>';
			}
		}
		if (!$fl) $xml .= $this->fForm2xml();
		return $xml;
	}
	
	function fFriendPercent($id)
	{
		$this->queryFields = array('t10.id as id10', 't9.id as id9', 't8.id as id8', 't7.id as id7', 't6.id as id6', 't5.id as id5', 't4.id as id4', 't3.id as id3', 't2.id as id2', 't1.id as id1');
		$this->queryTerms = 't LEFT JOIN '.$this->krnl->dbPref.'users t10 ON t10.id=t.inviteId LEFT JOIN '.$this->krnl->dbPref.'users t9 ON t9.id=t10.inviteId LEFT JOIN '.$this->krnl->dbPref.'users t8 ON t8.id=t9.inviteId LEFT JOIN '.$this->krnl->dbPref.'users t7 ON t7.id=t8.inviteId LEFT JOIN '.$this->krnl->dbPref.'users t6 ON t6.id=t7.inviteId LEFT JOIN '.$this->krnl->dbPref.'users t5 ON t5.id=t6.inviteId LEFT JOIN '.$this->krnl->dbPref.'users t4 ON t4.id=t5.inviteId LEFT JOIN '.$this->krnl->dbPref.'users t3 ON t3.id=t4.inviteId LEFT JOIN '.$this->krnl->dbPref.'users t2 ON t2.id=t3.inviteId LEFT JOIN '.$this->krnl->dbPref.'users t1 ON t1.id=t2.inviteId WHERE t.id='.$id;
		if ($this->fList(0))
			return $this->moduleData[0];
	}
}
?>