<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$tpl['title']}</title>
<link rel="shortcut icon" href="/im/metro/favicon.png">
<meta name="Keywords" content="{$tpl['keywords']}"/>
<meta name="Description" content="{$tpl['description']}"/>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
<script type="text/javascript" src="/scripts/jquery.js"></script>
{$tpl['yandexmap']}
<style type="text/css">
body {padding:0;margin:0;background:#FFF;font-family:Tahoma;}
a {color:#27478A;}
.left {float:left;}
.right {float:right;}
.clear {clear:both;}
hr {height:1px;}

.printbttn.hide {display:none;}
.printbttn {position:absolute;right:10px;top:-2px;padding:5px 10px 10px;font-size:20px;color:#FFF;background:#d68181;border:2px solid #ffd700;border-radius:0 0 20px 20px;-moz-border-radius:0 0 20px 20px;-webkit-border-radius:0 0 20px 20px;cursor:pointer;}
.printbttn:hover {background:#ad0303;text-shadow:0 0 5px #FFF;}

.box {border:2px solid #000;padding:10px;width:225px;margin:0 15px 0 0;}
.box h1 {margin:0;line-height:50px;text-align:center;font-size:22px;}
h1, h2, h3, p {margin:0;}

.print {margin:0 auto;width:700px;font-size:12px;}
.print .path {display:none;}
.print ul {padding:0 0 0 15px;}
.print p {padding:5px 25px;margin:0;}
.print h2 {padding:0px 25px 5px 0;line-height:120%;height:86px;overflow:hidden;font-size:20px;font-weight:normal;}

.map {margin:0;width:402px;height:233px;padding:5px;border:1px solid #777;float:left;}
.map img {border:1px solid #777777;display:block;background:#eee;}

.m_contacts {float:right;width:275px;margin:0 0 0 10px;}
.m_contacts.wide {width:100%;}
.m_contacts ul {margin:10px 0;}
.m_contacts h2, .m_contacts p {padding:0 0 5px;height:auto;}
.m_contacts .hr {margin:10px 0;}

.logo {display:block;margin:10px 0 20px;}
.head {margin:10px 0;}
.head h1 {margin:20px 0 0;}
h2 span {font-size:16px;}

.hr {margin:20px 0 15px;border-top:1px solid #777;}
.comment {font-size:11px;color:#555;margin:0 0 15px;display:block;}
.info p {padding:5px 0;}

.alert{padding:15px 20px 15px 65px!important;text-align:left;background:url(/im/alert.png) 5px 50% no-repeat;}

.dashed {height:1px;border-bottom:1px dashed #aaa;margin:10px 0;}

.input {height:30px;border-bottom:1px solid #000;}

table td {padding:0 5px;}

</style>
</head>
<body>
	<div class="print">
		{$tpl['text']}
	</div>
</body>
</html>