<?
DEFINE('PRM_USER_SELECT', 0x01);
DEFINE('PRM_USER_ADD',    0x02);
DEFINE('PRM_USER_UPDATE', 0x04);
DEFINE('PRM_USER_DELETE', 0x08);
DEFINE('PRM_USER_ORDER',  0x10);
DEFINE('PRM_USER_ACTIVE', 0x20);

DEFINE('PRM_GROUP_SELECT', 0x0100);
DEFINE('PRM_GROUP_ADD',    0x0200);
DEFINE('PRM_GROUP_UPDATE', 0x0400);
DEFINE('PRM_GROUP_DELETE', 0x0800);
DEFINE('PRM_GROUP_ORDER',  0x1000);
DEFINE('PRM_GROUP_ACTIVE', 0x2000);

DEFINE('PRM_ALL_SELECT', 0x010000);
DEFINE('PRM_ALL_ADD',    0x020000);
DEFINE('PRM_ALL_UPDATE', 0x040000);
DEFINE('PRM_ALL_DELETE', 0x080000);
DEFINE('PRM_ALL_ORDER',  0x100000);
DEFINE('PRM_ALL_ACTIVE', 0x200000);

DEFINE('PRM_NOT_ACCESS', 0x000000);
DEFINE('PRM_SELECT', 0x010101);
DEFINE('PRM_ADD',    0x020202);
DEFINE('PRM_UPDATE', 0x040404);
DEFINE('PRM_DELETE', 0x080808);
DEFINE('PRM_ORDER',  0x101010);
DEFINE('PRM_ACTIVE', 0x202020);
DEFINE('PRM_CONFIG',  0x404040);
DEFINE('PRM_PRM', 0x808080);

DEFINE('PRM_USER', 0x0000FF);
DEFINE('PRM_GROUP', 0x00FF00);
DEFINE('PRM_ALL', 0xFF0000);


class cPrmUsers extends cModule
{

	function fInitialSettings() 
	{
		parent::fInitialSettings();		
		$this->mActiveField = true;
		return 1;
	}

	function fCreateModule() 
	{
		parent::fCreateModule();
		$this->tableName = 'prm_users';
		$this->moduleCaption = 'пользователи';
		$this->addFormTitle = 'Добавить пользователя';
		$this->editFormTitle = 'Изменить пользователя';		
		$this->moduleFields['name'] = array('type' => 'VARCHAR', 'attr' => 'NOT NULL', 'min' => 1);
		$this->itemFormItems['name'] = array('type' => 'text', 'caption' => 'Название группы');		
		$this->orderAzoneField = 'id';
		$this->listAzoneFields = array('id');
		$this->moduleFields['id'] = array('type' => 'VARCHAR', 'width' => 32, 'attr' => 'NOT NULL', 'min'=>1);
		$this->moduleFields['name'] = array('type' => 'VARCHAR', 'attr' => 'NOT NULL', 'min'=>1);
		$this->itemFormItems['id'] = array('type' => 'text', 'caption' => 'Логин', 'comment'=>'Только латиница и цифры');
		$this->itemFormItems['name'] = array('type' => 'password', 'caption' => 'Пароль', 'md5'=>1);
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => 'Доступ разрешен');
	}
}

class cPrm extends cModule
{
	var $deniedAllItem;
	var $deniedAllAction;
	var $denied;
	var $error = '';
	var $userData;

	function fInitialSettings() 
	{
		parent::fInitialSettings();		
		$this->mActiveField = true;
		return 1;
	}

	function fCreateModule() 
	{
		parent::fCreateModule();
		$this->tableName = 'prm_group';
		$this->moduleNick = 'prm';
		$this->moduleCaption = 'группа';
		$this->addFormTitle = 'Добавить группу';
		$this->editFormTitle = 'Изменить группу';
		$this->moduleFields['name'] = array('type' => 'VARCHAR', 'attr' => 'NOT NULL', 'min' => 1);
		$this->itemFormItems['name'] = array('type' => 'text', 'caption' => 'Название группы');
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => 'Доступ разрешен');
		$this->deniedAllItem = implode('',file($this->krnl->pathWWW.'_azone/styles/_denied_item.tpl'));
		$this->deniedAllAction = implode('', file($this->krnl->pathWWW.'_azone/styles/_denied_action.tpl'));
		$this->denied = implode('', file($this->krnl->pathWWW.'_azone/styles/_denied.tpl'));
		$this->fCreateChild('prmusers');
	}

	function fCheckRights(&$module,$tryRights = PRM_SELECT,$id = NULL)
	{
		$mask = PRM_ALL;		
		
		if (!$this->krnl->mPrmControl) return true; // ГЛОБАЛЬНО если отключена то всегда возвращаем true!!!
		
		if (!(isset($_SESSION['prmGroupId']) && (int)$_SESSION['prmGroupId'] && isset($_SESSION['prmPass'])  && trim($_SESSION['prmPass'])!='' && isset($_SESSION['prmLogin']) && trim($_SESSION['prmLogin'])!='')) return false; // Затем проверка на авториазацию		
		
		// Проверка на активность пользователя
		$users = &$this->childsClass['prmusers'];
		$this->krnl->dbQuery = "SELECT id FROM ".$users->tableName." WHERE id='".$_SESSION["prmLogin"]."' AND active=1";		
		if (!$this->krnl->fDbExecute() || !$this->krnl->fDbNumRows()) return false;
		// Конец проверки на активность пользователя
			
		if($_SESSION['prmGroupId']==1 && $_SESSION['prmLogin']=='root') return true; // Для Root - всегда полный доступ
		
		if (isset($module->id) && ($module->id || $module->id!='')) $id = $module->id;
		
		// СНАЧАЛА ПРАВА ДОСТУПА МОДУЛЯ ВООБЩЕ
		// ЕСЛИ ЕСТЬ ОВНЕР - ТО БЕРЕМ ПРАВА ОВНЕРА САМОГО ГЛАВНОГО, ТАК КАК ДЛЯ ЧИЛДМОДУЛЕЙ ПРАВА ДОСТУПА НЕ РАССТАВЛЯЮТСЯ - ТОЛЬКО ДЛЯ САМОГО ГЛАВНОГО МОДУЛЯ
		// СООТВЕТВЕТСВЕННО ПРАВА ПОЗИЦИЙ ГЛАВНОГО МОДУЛЯ РАСКИДЫВАЮТСЯ НА ВСЕ ДОЧЕРНИЕ ПОЗИЦИИ
		// ЕСЛИ ГЛАВНЫМ МОДУЛЕМ (ГЛОБАЛЬНЫЕ ПРАВА) ЗАПРЕЩЕНЫ КАКИЕ ЛИБО ДЕЙСТВИЯ ТО ОНИ ЗАПРЕЩЕНЫ ДЛЯ ВСЕХ ПОЛЬЗОВАТЕЛЕЙ ВНУТРИ МОДУЛЯ
		
		if ($module->owner)
		{
			$row1['ownerId'] = 0;
			$this->krnl->dbQuery = "SELECT ownerId FROM ".$module->tableName." WHERE id = '".$id."'";						
			
			if($this->krnl->fDbExecute()) $row1 = $this->krnl->fDbGetRow();				
			
			if ($row1['ownerId']) return $this->fCheckRights(&$module->owner,$tryRights,$row1['ownerId']);
			else return false;
		}
		
		if ($_SESSION['prmGroupId'] == $module->modulePrm['prmGroupId']) $mask |= PRM_GROUP;			
		if ($_SESSION['prmLogin'] == $module->modulePrm['prmLogin']) $mask |= PRM_USER;
		$resultModule = (bool)($tryRights & $mask & $module->modulePrm['prmRights']);
		
		// ЗАТЕМ ПРАВА ДОСТУПА ЭЛЕМЕНТА ЕСЛИ ЕСТЬ ЭЛЕМЕНТ
		$resultItem = true;
		if($resultModule && $id)
		{
			$mask = PRM_ALL;
			$this->krnl->dbQuery = "SELECT prmLogin, prmGroupId, prmRights FROM ".$module->tableName." WHERE id = '".$id."'";			
			if($this->krnl->fDbExecute() && $this->krnl->fDbNumRows())
			{
				$arTemp = $this->krnl->fDbGetRow(); 				
				if ($_SESSION['prmGroupId'] == $arTemp['prmGroupId']) $mask |= PRM_GROUP;					
				if ($_SESSION['prmLogin'] == $arTemp['prmLogin']) $mask |= PRM_USER;					
				$resultItem = (bool)($tryRights & $mask & $arTemp['prmRights']);
			}
		}
		
		return $resultModule & $resultItem;
	}

	function fInitialization()
	{
		$resultGroup = $resultUsers = false;
		$this->krnl->dbQuery = 'SELECT * FROM '.$this->tableName;
		if($this->krnl->fDbExecute())
			if (!$this->krnl->fDbNumRows())
			{
				if($this->krnl->mPrmControl) 
					$this->krnl->dbQuery = "INSERT INTO ".$this->tableName." (id,name,active,prmLogin,prmGroupId,prmRights) VALUES (1,'administrators',1,'root',1,255),(2,'moderators',1,'root',1,255),(3,'users',1,'root',1,255)";
				else  
					$this->krnl->dbQuery = "INSERT INTO ".$this->tableName." (id,name,active) VALUES (1,'administrators',1), (2,'moderators',1), (3,'users',1)";	
				if($this->krnl->fDbExecute()) $resultGroup = true;
			}
			else $resultGroup = true;

		$users = &$this->childsClass['prmusers'];
		$this->krnl->dbQuery = 'SELECT * FROM '.$users->tableName;

		if($resultGroup && $this->krnl->fDbExecute())
			if (!$this->krnl->fDbNumRows())
			{
				if($this->krnl->mPrmControl) 
					$this->krnl->dbQuery = "INSERT INTO ".$users->tableName." (id,name,ownerId,active,prmLogin,prmGroupId,prmRights) VALUES ('root','".md5("root")."',1,1,'root',1,255)";
				else 
					$this->krnl->dbQuery = "INSERT INTO ".$users->tableName." (id,name,ownerId,active) VALUES ('root','".md5('root')."',1,1)";
				if($this->krnl->fDbExecute()) $resultUsers = true;
			}
			else $resultUsers = true;
			
		if (!$resultUsers) $this->error = 'Ошибка инициализации данных';
		return $resultUsers;
	}

	function fLogin() 
	{		
			if(isset($_SESSION['prmClear']) && $_SESSION['prmClear']==1)
			{
				unset($_SESSION['prmGroupId']);
				unset($_SESSION['prmPass']);
				unset($_SESSION['prmLogin']);
				unset($_SESSION['prmClear']);
				return 0;
			}

		$login = $password = '';
		$this->userData = false;
		$users = &$this->childsClass['prmusers'];

			if (isset($_POST['login']) && eregi("^".$this->krnl->domainName,$_SERVER['HTTP_REFERER'])) $login = $_POST['login'];
			elseif (isset($_SESSION['prmLogin'])) $login = $_SESSION['prmLogin'];
				
			if (isset($_POST['pass'])) $pass = $_POST['pass'];
			elseif (isset($_SESSION['prmPass'])) $pass = $_SESSION['prmPass'];
				
			if (trim($login)=='' || trim($pass)=='') 
			{
				if (isset($_POST['login']) || isset($_POST['pass'])) $this->error = 'Введите "Имя пользователя" и "Пароль".';
				return 0;
			}
		
		$login = preg_replace('/[^A-Za-z0-9]+/','',$login);
		$pass = preg_replace('/[^A-Za-z0-9]+/','',$pass);
		$this->krnl->dbQuery = "SELECT id,name,ownerId FROM ".$users->tableName." WHERE id='".$login."' AND name='".md5($pass)."' AND active=1";

		if ($this->krnl->fDbExecute() && $this->krnl->fDbNumRows())
		{
			$this->userData = $this->krnl->fDbGetRow();		
			$this->krnl->dbQuery = "SELECT id FROM ".$this->tableName." WHERE id='".$this->userData['ownerId']."' AND active=1";
			
			if ($this->krnl->fDbExecute() && $this->krnl->fDbNumRows())
			{
				$_SESSION['prmLogin'] = $this->userData['id'];
				$_SESSION['prmPass'] = $this->userData['name'];
				$_SESSION['prmGroupId'] = $this->userData['ownerId'];
				return 1;
			}
			else
			{
				$this->error = 'Ошибка авторизации пользователя.';
				return 0;				
			}
		}
		else
		{
			$this->error = '"Имя пользователя" или "Пароль" введены не верно.<p>Возможно данный пользователь был отключен от регистрации.</p>';
			return 0;			
		}
	}

	function fDrawLoginForm($type=true)
	{
		if ($this->error!='') $errorHtml = '<tr><td class="error">'.$this->error.'</td></tr>';
		else $errorHtml = '';
		
		if ($type) $authHtml = '<tr><td class="authorization">Имя пользователя:<br><input type="text" name="login"><br>Пароль:<br><input type="password" name="pass"><br><input type="submit" name="enter" value="Войти" class="submit"></td></tr>';
		else $authHtml = '';
		
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><HTML><HEAD><TITLE>'.$_SERVER['SERVER_NAME'].' - ADMINISTRATOR ZONE</TITLE><meta name="author" content="Vladimir Atamanov (VA)- ATIKO"><meta name="robots" content = "noindex"><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><link REL="SHORTCUT ICON" HREF="/_azone/favicon.ico"><link rel="stylesheet" type="text/css" href="styles/login.css"></HEAD><body><form method="POST"><table class="main"><tr><td><table class="login" align="center"><tr><td align="center" class="top"><img src="/_azone/im/ttll.gif" alt="Authorization on the CMS-ATIKO"></td></tr>'.$errorHtml.$authHtml.'</td><td class="copy"><a href="http://www.atiko.ru" target="_blank"><img src="/_azone/im/cr.gif" alt="ATIKO"></a></td></tr></table></td></tr></table></form></body></HTML>';
		return 1;
	}
}
?>