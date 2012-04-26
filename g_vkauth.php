<?
error_reporting(E_ALL);
define(APP_ID, '2867256');
define(APP_SHARED_SECRET, '2867256');

function authOpenAPIMember() {
  $session = array();
  $member = FALSE;
  $valid_keys = array('expire', 'mid', 'secret', 'sid', 'sig');
  $app_cookie = $_COOKIE['vk_app_'.APP_ID];
  if ($app_cookie) {
    $session_data = explode ('&', $app_cookie, 10);
    foreach ($session_data as $pair) {
      list($key, $value) = explode('=', $pair, 2);
      if (empty($key) || empty($value) || !in_array($key, $valid_keys)) {
        continue;
      }
      $session[$key] = $value;
    }
    foreach ($valid_keys as $key) {
      if (!isset($session[$key])) return $member;
    }
    ksort($session);
    
    $sign = '';
    foreach ($session as $key => $value) {
      if ($key != 'sig') {
        $sign .= ($key.'='.$value);
      }
    }
    $sign .= APP_SHARED_SECRET;
    $sign = md5($sign);
    if ($session['sig'] == $sign && $session['expire'] > time()) {
      $member = array(
        'id' => intval($session['mid']),
        'secret' => $session['secret'],
        'sid' => $session['sid']
      );
    }
  }
  return $member;
}

$member = authOpenAPIMember();

if($member !== FALSE) {
	$pathKRNL = include(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/pathkrnl.php');	
	require_once($pathKRNL.'kernel/initial_class.php');
	require_once($pathKRNL.'kernel/db_class.php');

	$cDB = new cDB();		
	$cDB->fDbConnect();	
	
	if($fields['sex'] == 1)
		$sex=2;
	elseif ($fields['sex'] == 2)
		$sex=1;
	
	$pass = substr(md5(md5($data['email'].$this->fGetMicroTime())),-8);
	
	
	// $this->krnl->dbQuery = "INSERT INTO ".$cDB->tableName." (name, active, sname, password, sex, sending, balans, cityId, level, regtime, addip, delivery) VALUES (".$name.", 1, ".$sname.", ".$pass.", ".$sex.", 1, ".$balans.", ".$cityId.", 1, ".time().", ".$_SERVER['REMOTE_ADDR'].", ".date('Y-m-d').")";
	
	// $this->krnl->fDbExecute();
	
	// $_SESSION['User']['Id'] = $id;
	// $_SESSION['User']['Name'] = $name;
	// $_SESSION['User']['Balans'] = $balans;
	// $_SESSION['city'] = $cityId;
	
	// setcookie ('bmu',$id,time()+3600*24*1000);
	// setcookie ('nsh',$email,time()+3600*24*1000);
	// setcookie ('lsw',$level,time()+3600*24*1000);
	
	$cDB->fCheckAuth();
	$cDB->fDbClose();
	
	//echo 'DONE';
} else {
	/* Пользователь не авторизирован в Open API */
}
?>