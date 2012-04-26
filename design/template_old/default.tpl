<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<title>{$tpl['title']}</title>
<meta name="Keywords" content="{$tpl['keywords']}"/>
<meta name="Description" content="{$tpl['description']}"/>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
<link rel="stylesheet" type="text/css" href="/styles/content.css"/>
<link rel="stylesheet" type="text/css" href="/styles/base.css"/>
<link rel="stylesheet" type="text/css" href="/styles/styles.css"/>
<link rel="shortcut icon" href="/favicon.ico">
<link rel="stylesheet" media="all" href="/styles/ie.css"/>
<script type="text/javascript" src="/scripts/jquery.js"></script>
<script type="text/javascript" src="/scripts/va.main.js"></script>
<script type="text/javascript" src="/scripts/va.lbox.js"></script>
</head>
<body> {$tpl['reg']} {$tpl['ie6']} <div id="lbox"></div>
	<div class="top">
		<div class="cntr">
			{$tpl['menu']}
		</div>
	</div> 
	<div class="city_head">
		<div class="cntr">
			<div id="re_citylist" class="city_block"></div>
			<div class="city_box"><div class="mid"><span class="h1">Лучшие предложения в городе</span>{$tpl['city']}<div id="city_bttn" onclick="$('#citylist').slideToggle('slow');addActive('city_bttn');return false;"></div></div><div class="r"></div></div>
		</div>
	</div> 
	<div class="bg">
		<div class="cntr">
			<div class="salute"></div>
			<a href="{$tpl['domainName']}" class="home" title="{$tpl['sitename']}"></a>
			<div class="auth">{$tpl['user']}</div>
			{$tpl['bannTop']}
		</div>
		<div id="content" class="cntr"> <div class="def"> <div class="bound"></div> <div class="ang"> {$tpl['text']} </div> </div> </div>
		<div class="cntr"> {$tpl['bannBot']} </div>
		{$tpl['bottom']}
		<div class="clear"></div>
	</div>
	<div class="footer"> 
		<div class="cntr"> 
			<div class="right"> <a href="http://vkontakte.ru/club32591515"> <img align="absmiddle" alt="RichMediaGroup" src="/im/rmg.jpg"/> </a> </div> 
			<div class="left"> {$tpl['copyright']} </div> 
			<div class="center"> <div class="rbk"> <img alt="Webmoney" src="/im/webmoney.png"/> <img alt="Банковские карты Visa" src="/im/visa.png"/> <img alt="Банковские карты Mastercard" src="/im/mastercard.png"/> <img alt="Банковский платеж" src="/im/sberbank.png"/> <img alt="RBK Money" src="/im/rbk_money.png"/></div> <div class="counter">{$tpl['icounter']}</div> 
		</div>
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
</body> </html> 