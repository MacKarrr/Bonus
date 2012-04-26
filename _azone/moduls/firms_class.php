<?

class cFirms extends cModule
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

		$this->tableName = 'firms';
		$this->moduleCaption = 'клиенты';

		$this->moduleFields['type'] = array('type' => 'VARCHAR', 'width' => 64, 'attr' => "NOT NULL DEFAULT ''", 'min'=>'1');
		$this->moduleFields['firmsname'] = array('type' => 'VARCHAR', 'attr' => "NOT NULL DEFAULT ''", 'min'=>'1');
		$this->moduleFields['address'] = array('type' => 'TEXT', 'attr' => 'NOT NULL');
		$this->moduleFields['phone'] = array('type' => 'TEXT', 'attr' => 'NOT NULL');
		$this->moduleFields['url'] = array('type' => 'VARCHAR', 'width' => 64, 'attr' => "NOT NULL DEFAULT ''");
		$this->moduleFields['city'] = array('type' => 'VARCHAR', 'width' => 64, 'attr' => "NOT NULL DEFAULT ''");
		$this->moduleFields['femail'] = array('type' => 'VARCHAR', 'width' => 64, 'attr' => "NOT NULL DEFAULT ''");
		
		$this->moduleFields['email'] = array('type' => 'VARCHAR', 'width' => 64, 'attr' => "NOT NULL DEFAULT ''", 'min'=>'1');
		$this->moduleFields['password'] = array('type' => 'VARCHAR', 'width' => 32, 'attr' => "NOT NULL DEFAULT ''", 'min'=>'1');
		$this->moduleFields['password2'] = array('type' => 'VARCHAR', 'width' => 32, 'attr' => "NOT NULL DEFAULT ''", 'min'=>'1');
		
		
		$this->itemFormItems['name'] = array('type' => 'text', 'caption' => 'Название предприятия');
		$this->itemFormItems['type'] = array('type' => 'text', 'caption' => 'Тип предприятия');
		$this->itemFormItems['firmsname'] = array('type' => 'text', 'caption' => 'Полное наименование организации', 'comment'=>'пример: <i>ООО "Рич Медиа Груп"</i>');
		$this->itemFormItems['address'] = array('type' => 'textarea', 'rows'=>1, 'caption' => 'Адреса','comment'=>'Каждый адрес в новой строке');
		$this->itemFormItems['phone'] = array('type' => 'textarea', 'rows'=>1, 'caption' => 'Телефоны','comment'=>'Каждый телефон в новой строке через "восьмерку" с кодом города, без пробелов и дефисов:<br/><i>8(347)2654565<br/>8(917)5648523</i>');
		$this->itemFormItems['url'] = array('type' => 'text', 'caption' => 'Адрес сайта');
		$this->itemFormItems['city'] = array('type' => 'text', 'caption' => 'Город');
		$this->itemFormItems['femail'] = array('type' => 'text', 'caption' => 'E-mail');
		
		$this->itemFormItems['email'] = array('type' => 'text','caption' => 'Логин','comment'=>'Логин в виде: <b>bonus@</b>name');
		$this->itemFormItems['password'] = array('type' => 'password', 'caption' => 'Пароль для кассира', 'md5'=>0);
		$this->itemFormItems['password2'] = array('type' => 'password', 'caption' => 'Пароль для директора', 'md5'=>0);
		$this->itemFormItems['active'] = array('type' => 'bool', 'caption' => 'Активна');
	}
}
?>
