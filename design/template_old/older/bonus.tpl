<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<title>{$tpl['title']}</title>
<meta name="Keywords" content="{$tpl['keywords']}"/>
<meta name="Description" content="{$tpl['description']}"/>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

<meta property="og:tag name" content="tag value"/>

<link rel="stylesheet" type="text/css" href="/styles/content.css"/>
<link rel="stylesheet" type="text/css" href="/styles/base.css"/>
<link rel="stylesheet" type="text/css" href="/styles/styles.css"/>
<link rel="stylesheet" type="text/css" href="/styles/ie.css"/>
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
		<span class="lnkT"> <a href="">Сделать стартовой</a> <a href="">Добавить в избранное</a> </span>
	</div>
</div>
<div class="bg">
	<div class="cntr sun">
		{$tpl['offer']}
		{$tpl['city']}
		<a class="home" href="{$tpl['domainName']}" rel="home"></a>
		<div class="clear"></div>
	</div>
	<div class="cntr">
		<div id="content" class="def">
			<div class="ang">
				{$tpl['text']}
			</div>
		</div>
	</div>
	<div class="cntr">
		{$tpl['menu2']}
			<div class="social">
				<span>Следуйте за нами</span>
				<a title="Twitter" href="http://twitter.com/bonusmouse" class="twitter"></a>
				<a title="Facebook" href="http://www.facebook.com/bonusmouse" class="facebook"></a>
				<a title="RSS акций" href="http://feeds.feedburner.com/bonusmouse" class="rss"></a>
				<a title="ВКонтакте" href="http://vkontakte.ru/bonusmouse" class="vk"></a>
			</div>
			<div class="clear"></div>
	</div>
</div>
<div class="footer">
	<div class="cntr">
		<div class="left"> {$tpl['copyright']}</div> <div class="right"> <a href="">Разработка и создание сайта<img align="absmiddle" alt="создание портала qb-Art" src="/im/qb.png"></a> </div> <div class="center"> {$tpl['counter']} </div> <div class="clear"></div>
	</div>
</div>
</body> </html>
