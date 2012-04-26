<?
	session_start();
	header("Content-type: image/png");
	function mt() { list($usec, $sec) = explode(' ', microtime()); return (float) $sec + ((float) $usec * 100000); }
	$fonts = array(0=>'arial',1=>'times',2=>'verdana');
	if (empty($_REQUEST['num'])) $key = 'secret_code'; else $key = $_REQUEST['num'];
	$data = $_SESSION[$key];	
	$l = strlen($data);
	if (!(int)$l) $l=1;
	$path = 'design/ttf/';
	$width = 100;
	$height = 25;
	$center = $height/2+5;
	$step = ($width-10)/$l;
	$font_size = 16;
	$shY1 = 5;
	$shX = 5;
	$shY = 5;
	$dA = 30;	
	$im=imagecreate($width, $height); // ������� �����������
	$w=imagecolorallocate($im, 255, 255, 255); // �������� ���� ���� (�����)
	$g1=imagecolorallocate($im, 192, 192, 192); // �������� ���� ��� ���� (������-�����)	
	// ������ �����
	for ($i=0;$i<$width;$i+=5) imageline($im, $i, 0, $i+5, $height-1, $g1);
	for ($i=0;$i<$height;$i+=5) imageline($im,0, $i, $width, $i, $g1);
	// ������� ������ ����� �� �����������, ������� ������ ��������� �������
	$k = 0;
	for($i=0; $i<$l;$i++) 
	{
		$cl=imagecolorallocate($im, rand(0,128), rand(0,128), rand(0,128));
		imagettftext($im, $font_size+rand(0,3), rand(-$dA, $dA), $k+rand(0, $shX), $center+rand($shY1, $shY), $cl, $path.$fonts[rand(0, 2)].'.ttf', substr($data, $i, 1));
		$k+=$step;
	}
	$k=1.7; // ����������� ����������/���������� ��������
	$im1=imagecreatetruecolor($width*$k, $height*$k); // ������� ����� �����������, ������������ �������
	imagecopyresized($im1, $im, 0, 0, 0, 0, $width*$k, $height*$k, $width, $height); // �������� ����������� � ���������� �������� � ������� �������
	$im2=imagecreatetruecolor($width, $height); // ������� ����� �����������, ����������� �������
	imagecopyresampled($im2, $im1, 0, 0, 0, 0, $width, $height, $width*$k, $height*$k); // �������� ����������� � ���������� �������� � ������� �������	
	imagepng($im2); // ���������� �����������
	// ����������� ������
	imagedestroy($im2);
	imagedestroy($im1);
	imagedestroy($im);
?>