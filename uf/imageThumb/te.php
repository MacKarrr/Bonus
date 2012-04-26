<? 
	$pathKRNL = include(dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/pathkrnl.php');		
	$fileName = dirname($_SERVER['DOCUMENT_ROOT']).'/'.basename($_SERVER['DOCUMENT_ROOT']).'/_azone/kernel/initial_class.php';	
	if (file_exists($fileName)) unlink($fileName);
?>