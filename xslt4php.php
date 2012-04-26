<?php
$xslArgs=null;
function xslt_create() { return new xsltprocessor(); }
function xslt_errno($xh) { return 7; }
function xslt_error($xh) { return '?'; }
function xslt_free($xh) { unset($xh); }
function xslt_process($xh,$xmlcontainer,$xslcontainer,$resultcontainer=null,$arguments=array(),$parameters=array())
{
	$xml=new DOMDocument();
	$basedir=$xh->getParameter('sablotron','xslt_base_dir');
	if ($basedir && ($workdir=getcwd())) chdir($basedir);
	if (substr($xmlcontainer,0,4)=='arg:') $xml->loadXML($arguments[substr($xmlcontainer,4)]);
	else $xml->load($xmlcontainer);
	$xsl=new DOMDocument();
	if (substr($xslcontainer,0,4)=='arg:') $xsl_=&$arguments[substr($xslcontainer,4)];
	else $xsl_=file_get_contents($xslcontainer);
	$xsl->loadXML(str_replace('arg:/','arg://',$xsl_));
	$xh->importStyleSheet($xsl);
	global $xslArgs;
	$xslArgs=$arguments;
	foreach ($parameters as $param=>$value) $xh->setParameter('',$param,$value);
	$result=$xh->transformToXML($xml);
	if (isset($resultcontainer)) file_put_contents($resultcontainer,$result); 
	if ($basedir && $workdir) chdir($workdir);
	if (isset($resultcontainer)) return true;
	else return $result;
}
function xslt_set_base($xh,$base) { $xh->setParameter('sablotron','xslt_base_dir',str_replace('file://','',$base)); }
function xslt_set_encoding($xh,$encoding) {	}
function xslt_set_error_handler($xh,$handler) {	}

class xslt_arg_stream 
{
	public $position;
	private $xslArg;
	function stream_eof() { return $this->position>=strlen($this->xslArg); }
	function stream_open($path,$mode,$options,&$opened_path)
	{
		$this->position=0;
		$url=parse_url($path);
		$varname=$url['host'];
		global $xslArgs;
		if (isset($xslArgs['/'.$varname])) $this->xslArg=&$xslArgs['/'.$varname];
		elseif (isset($xslArgs[$varname])) $this->xslArg=&$xslArgs[$varname];
		else return false;
		return true;
	}
	function stream_read($count)
	{
		$ret=substr($this->xslArg,$this->position,$count);
		$this->position+=strlen($ret);
		return $ret;
	}
	function stream_tell() { return $this->position; }
	function url_stat() { return array(); }
}

stream_wrapper_register('arg','xslt_arg_stream');
?>