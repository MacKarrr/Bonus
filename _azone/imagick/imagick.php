<?
	header('Cache-Control: max-age=0, must-revalidate' );
	header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()-1).' GMT');
	header('Expires: '.gmdate('D, d M Y H:i:s', time()-1).' GMT');
	header('Content-type:text/html');

	if (!isset($_REQUEST['class']) || $_REQUEST['class']=='' || 
		!isset($_REQUEST['moduleName']) || $_REQUEST['moduleName']=='' || 
		!isset($_REQUEST['dir']) || $_REQUEST['dir']=='' || 
		!isset($_REQUEST['id']) || $_REQUEST['id']=='' ||
		!isset($_REQUEST['ext']) || $_REQUEST['ext']=='')
		exit;

	$class = $_REQUEST['class'];
	$moduleName = $_REQUEST['moduleName'];
	$id = $_REQUEST['id'];
	$dir = $_REQUEST['dir'];
	$ext =	$_REQUEST['ext'];
	$width = 0;

	$pathKRNL = include(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/pathkrnl.php');	
	require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/kernel/initial_class.php');
	require_once($pathKRNL.'kernel/db_class.php');
	require_once($pathKRNL.'kernel/azone_ex_class.php');

	$cDB = new cDB();

	if (file_exists($cDB->pathMDL.$class.'_class.php')) 
	{
		$module = $cDB->fGetModule($class);
		if ($class != $moduleName)
			$module = $module->fGetByModuleNick($moduleName);
	}

	if (!$module)
		exit;

	$sourceFile = $cDB->pathWWW.$dir.'/'.$id.'.'.$ext;

	if (file_exists($sourceFile) && isset($module->moduleAttaches[$dir]['mod']) && count($module->moduleAttaches[$dir]['mod']))
	{
		$size = getimagesize($sourceFile);
		$height = $size[1];
		$heightYNew = $height-2;
		$width = $size[0];
		$widthXNew = $width-2;
		$mod = $module->moduleAttaches[$dir]['mod'];

		foreach($mod as $row)
			if (count($row))
			{
				$outFile = $cDB->pathWWW.$dir.'/'.$row[1].$id.'.'.$ext;
				$widthX = $row[2];
				$heightY = $row[3];
					if ($row[0] == 'resize_width')
					{
						if ($width>$widthX)
						{
							$heightYNew = ceil($height*$widthX/$width);
							shell_exec($cDB->pathCNV.' -size '.$width.'x'.$height.' '.$sourceFile.' -resize '.$widthX.'x'.$heightYNew.' -quality 100 -interlace plane '.$outFile);
						}
						elseif ($sourceFile!=$outFile)
							copy($sourceFile,$outFile);
					}				
					elseif ($row[0] == 'resize_over')
					{
						if ($width>$widthX || $height>$heightY)
						{
							if ($width/$widthX > $height/$heightY)
							{
								$heightYNew = ceil($height*$widthX/$width)-2;
								$widthXNew = $widthX-2;
							}
							else							
							{
								$widthXNew = ceil($width*$heightY/$height)-2;
								$heightYNew = $heightY-2;
							}
							
							shell_exec($cDB->pathCNV.' -size '.$width.'x'.$height.' '.$sourceFile.' -resize '.$widthXNew.'x'.$heightYNew.' -quality 100 -interlace plane '.$outFile);												
						}
						else
							shell_exec($cDB->pathCNV.' -size '.$width.'x'.$height.' '.$sourceFile.' -resize '.$widthXNew.'x'.$heightYNew.' -quality 100 -interlace plane '.$outFile);			
						$size = getimagesize($outFile);
						$borderLeft = ceil(($widthX-$size[0])/2);
						$borderTop = ceil(($heightY-$size[1])/2);
						
						if (substr($cDB->pathCNV,-7)=='convert')
							shell_exec($cDB->pathCNV." -bordercolor '#FFFFFF' -border ".$borderLeft."x".$borderTop." ".$outFile." ".$outFile); 
						else
							shell_exec($cDB->pathCNV." -bordercolor #FFFFFF -border ".$borderLeft."x".$borderTop." ".$outFile." ".$outFile);
					}
					elseif ($row[0] == 'resize')
					{
						if ($width>$widthX || $height>$heightY)
						{
							if ($width>$height)
							{
								$heightYNew = ceil($height*$widthX/$width);
								shell_exec($cDB->pathCNV.' -size '.$width.'x'.$height.' '.$sourceFile.' -resize '.$widthX.'x'.$heightYNew.' -quality 100 -interlace plane '.$outFile);
							}
							else
							{
								$widthXNew = ceil($width*$heightY/$height);
								shell_exec($cDB->pathCNV.' -size '.$width.'x'.$height.' '.$sourceFile.' -resize '.$widthXNew.'x'.$heightY.' -quality 100 -interlace plane '.$outFile);
							}
						}
						elseif ($sourceFile!=$outFile)
							copy($sourceFile,$outFile);
					}					
					elseif($row[0] == 'crop')
					{
						if ($width>$widthX || $height>$heightY)
						{
							if($width/$widthX>$height/$heightY)
							{
								$widthXNew = ceil($width*$heightY/$height);
								shell_exec($cDB->pathCNV.' -size '.$width.'x'.$height.' '.$sourceFile.' -resize '.$widthXNew.'x'.$heightY.' -quality 100 -interlace plane '.$outFile);
								$left = ceil(($widthXNew-$widthX)/2);
								shell_exec($cDB->pathCNV.' -size '.$w.'x'.$heightY.' '.$outFile.' -crop '.$widthX.'x'.$heightY.'+'.$left.'+0 '.$outFile);
							}
							else
							{
								$heightYNew = ceil($height*$widthX/$width);
								shell_exec($cDB->pathCNV.' -size '.$width.'x'.$height.' '.$sourceFile.' -resize '.$widthX.'x'.$heightYNew.' -quality 100 -interlace plane '.$outFile);	
								$top = ceil(($heightYNew-$heightY)/2);
								shell_exec($cDB->pathCNV.' -size '.$widthX.'x'.$heightYNew.' '.$outFile.' -crop '.$widthX.'x'.$heightY.'+0+'.$top.' '.$outFile);
							}
						}
						else
						{
														
							$borderLeft = ceil(($widthX-$width)/2);
							$borderTop = ceil(($heightY-$height)/2);

							if (substr($cDB->pathCNV,-7)=='convert')
								shell_exec($cDB->pathCNV." -bordercolor '#FFFFFF' -border ".$borderLeft."x".$borderTop." ".$sourceFile." ".$outFile); 
							else
								shell_exec($cDB->pathCNV." -bordercolor #FFFFFF -border ".$borderLeft."x".$borderTop." ".$sourceFile." ".$outFile);
						}
					}
				/*
				if ($row[1]=="b_")
					shell_exec($cDB->pathCMP.' -gravity SouthWest -geometry +8+5 '.$cDB->pathWWW.'im/ilg.png '.$outFile.' '.$outFile);				
				*/
			}
	}
?>

<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'><HTML><HEAD><title>MODULS LIST</title><meta name='author' content='Vladimir Atamanov (VA)'><meta name='document-state' content = 'dynamic'><meta name='robots' content = 'noindex'><meta http-equiv='Content-Type' content='text/html; charset=windows-1251'><script>
	function fLoad() 
	{
		Obj = top.action.document.getElementById('imgload');
		if (Obj) Obj.innerHTML = document.getElementById('content').innerHTML;

	}
</script></HEAD><BODY onLoad='fLoad()'>
<?
	$er = 1;
	
	if ($width && isset($module->moduleAttaches[$dir]['mod']) && count($module->moduleAttaches[$dir]['mod']))
	{
		$modWidth = 0;
		foreach ($module->moduleAttaches[$dir]['mod'] as $row)
			if ($row[1]=='') 
				$modWidth = $row[2];
		
		$size = getimagesize($sourceFile);
		
		if ($size[0]<($modWidth+5))
		{
			$er = 0;
			echo '<div id="content"><img src="'.$cDB->domainName.$dir.'/'.$id.'.'.$ext.'?'.rand(0,9999).'" alt="Загрузка" width="100"/></div>';
		}
	}
	
	if ($er)
	{	
		$cDB->fDbConnect();
		$module->id = $id;
		$module->fDeleteAttaches();
		$cDB->fDBClose();
		echo '<div id="content"><strong style="color:#D00">Ошибка обработки<br/>изображения</strong></div>';			
	}
	?>
</BODY></HTML>