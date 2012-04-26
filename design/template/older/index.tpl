<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<title>{$tpl['title']}</title>
<meta name="Keywords" content="{$tpl['keywords']}">
<meta name="Description" content="{$tpl['description']}">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="/styles/content.css">
<link rel="stylesheet" type="text/css" href="/styles/base.css">
<link rel="stylesheet" type="text/css" href="/styles/styles.css">
<link rel="stylesheet" type="text/css" href="/styles/ie.css">
<script type="text/javascript" src="/scripts/jquery.js"></script>
<script type="text/javascript" src="/scripts/va.main.js"></script>
<script type="text/javascript" src="/scripts/va.gallery.js"></script>
<script type="text/javascript" src="/scripts/va.order.js"></script>
<script type="text/javascript" src="/scripts/va.frm.js"></script>
</head>
<body>
{$tpl['ie6']}
<div class="top">
	<div class="cntr">
		{$tpl['menu']}
		<span class="lnkT"> 
		<a href="/info/startpage.html"
onClick="this.style.behavior='url(#default#homepage)';
var ohp=this.isHomePage('{$tpl['domainName']}');
this.setHomePage('{$tpl['domainName']}');
var nhp=this.isHomePage('{$tpl['domainName']}');
r(this, 'shp/o=' + ohp + '/n=' + nhp);
return false;">������� ���������</a>
		<a href="javascript:void(0);" onclick="return bookmark(this);">�������� � ���������</a> </span>
	</div>
</div>
<div class="bg">
	<div class="cntr sun">
		{$tpl['offer']}
		<div class="auth"> 
			<form name="frm_login" method="post" action="#">
				<label for="login">�����:</label><input type="text" autocomplete="off" value="" id="login" name="login"/>
				<div class="clear"></div>
				<label for="password">������:</label> <input type="password" value="" id="password" name="password" class="pass"/>
				<a href="{$tpl['domainName']}remind.html">������?</a>
				<input type="checkbox" id="rem" class="check"/> <label for="rem">���������</label>
				<div class="clear"> <input type="submit" value="�����" class="bttn" name="authsend"/>
				<a href="{$tpl['domainName']}reg.html">������������������</a> </div>
			</form>
		</div>
		{$tpl['city']}
		<a class="home" href="{$tpl['domainName']}" rel="home"></a>
		<div class="clear"></div>
	</div>
	<div class="cntr">
		<div id="content">
			<div class="ang">
				<div class="action">
				<img src="/im/action.png" class="prev"/>
				<h1>���������� � ���������  ���� ��������� �B�. ������,  ����� �����������  ��������, ������������� � �����</h1>
				<span class="price">1600 ������ / ������ 4000</span>
				<span class="bttn big">������</span>������ <span>60%</span> ��� 2400 ���. 
				<p class="">������: 31 �������</p>
				<p class="">�� ���������� �������� 10 ���� 2 ���� 3 ������</p>
				<div class="clear"></div>
				</div>
				<!-- {$tpl['path']} {$tpl['text']} -->
			</div>
		</div>
		<div id="col">
			<div class="ang">
				<p>���������� � ���� ����������. ��������, �������, Love Story ��� ��������. ������ �� 80%.</p>
				<span class="date">15.06.11</span><span class="price">�� <span>200 �.</span></span><a href="" class="bttn">������</a><div class="clear"></div>
				<p>���������� � ���� ����������. ��������, �������, Love Story ��� ��������. ������ �� 80%.</p>
				<span class="date">15.06.11</span><span class="price">�� <span>200 �.</span></span><a href="" class="bttn">������</a><div class="clear"></div>
				<p>���������� � ���� ����������. ��������, �������, Love Story ��� ��������. ������ �� 80%.</p>
				<span class="date">15.06.11</span><span class="price">�� <span>200 �.</span></span><a href="" class="bttn">������</a><div class="clear"></div>
			</div>
		</div>
	</div>

</div>
<div class="footer">
	<div class="cntr">
		<div class="left"> {$tpl['copyright']}</div> <div class="right"> <a href="">���������� � �������� �����<img align="absmiddle" alt="�������� ������� qb-Art" src="/im/qb.png"></a> </div> <div class="center"> {$tpl['counter']} </div> <div class="clear"></div>
	</div>
</div>
</body> </html>
