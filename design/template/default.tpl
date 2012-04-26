<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<title>{$tpl['title']}</title>
<meta name="Keywords" content="{$tpl['keywords']}"/>
<meta name="Description" content="{$tpl['description']}"/>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
<link rel="stylesheet" type="text/css" href="/styles/reset.css"/>
<link rel="stylesheet" type="text/css" href="/styles/metro.css"/>
<link rel="stylesheet" type="text/css" href="/styles/metro22.css"/>
<link rel="shortcut icon" href="/im/metro/favicon.png">
<link rel="stylesheet" media="all" href="/styles/ie.css"/>
<script type="text/javascript" src="/scripts/jquery.js"></script>
<script type="text/javascript" src="/scripts/va.main.js"></script>
<script type="text/javascript" src="/scripts/va.lbox.js"></script>
{$tpl['yandexmap']}
</head>
<body> {$tpl['reg']} {$tpl['ie6']} <div id="lbox"></div>
	<div class="main">
		<div class="head">
			<div class="system right">
				<div class="cityblock">
					{$tpl['city']}
				</div>
				<div class="auth">{$tpl['user']}</div>
			</div>
			<div class="direction left">
				<div class="menu right">
					{$tpl['menu']}
				</div>
				<div class="logo left">
					<a href="{$tpl['domainName']}" rel="home" title="{$tpl['sitename']}"> <img src="{$tpl['domainName']}im/metro/bonusmouse.png" alt="{$tpl['sitename']}"/><span>{$tpl['sitedescr']}</span> </a>
				</div>
				<div class="clear"></div>
				<ul class="submenu">
					<li><a href="{$tpl['domainName']}">Акции дня</a></li>
					<li><a href="{$tpl['domainName']}?cat=1">Красота и здоровье</a></li>
					<li><a href="{$tpl['domainName']}?cat=2">Отдых и развлечения</a></li>
					<li><a href="{$tpl['domainName']}?cat=3">Услуги</a></li>
					<li><a href="{$tpl['domainName']}?cat=4">Разное</a></li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		<div class="middle">
			{$tpl['bannTop']}
			<div class="content">
				{$tpl['text']}
				<div class="clear"></div>
			</div>
			{$tpl['bannBot']}
			{$tpl['bottom']}
			<div class="footer"> 
				<div class="right"> <a href="http://vkontakte.ru/club32591515"> <img align="absmiddle" alt="RichMediaGroup" src="/im/metro/rmg.jpg"/> </a> </div> 
				<div class="left"> <span>{$tpl['copyright']}</span> </div> 
				<div class="center">
					<div class="rbk"> <img alt="Webmoney" src="/im/webmoney.png"/> <img alt="Банковские карты Visa" src="/im/visa.png"/> <img alt="Банковские карты Mastercard" src="/im/mastercard.png"/> <img alt="Банковский платеж" src="/im/sberbank.png"/> <img alt="RBK Money" src="/im/rbk_money.png"/></div> 
					<div class="counter">{$tpl['icounter']}</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
<!-- Yandex.Metrika counter -->
<div style="display:none;"><script type="text/javascript">
(function(w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter12368905 = new Ya.Metrika({id:12368905, enableAll: true, webvisor:true});
        }
        catch(e) { }
    });
})(window, "yandex_metrika_callbacks");
</script></div>
<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
<noscript><div><img src="//mc.yandex.ru/watch/12368905" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
	</div>
</body> </html> 