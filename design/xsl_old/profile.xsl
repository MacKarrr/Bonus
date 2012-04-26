<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:import href="design/xsl/form.xsl"/>
	<xsl:import href="design/xsl/messages.xsl"/>
	<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items"> <script src="/scripts/marks.js" type="text/javascript"></script> 
	<ul class="bonusmark bonush">
		<li class="l" id="log1"> <xsl:if test="type='profile'"> <xsl:attribute name="class">l active</xsl:attribute> </xsl:if> <a href="#">Личная информация</a></li>
		<li id="log2"><xsl:if test="type='bonuses' or coupon/ok!=''"> <xsl:attribute name="class">active</xsl:attribute> </xsl:if> <a href="#"> Купоны</a></li>
		<li class="log3" id="log3"> <xsl:if test="type='friends'"> <xsl:attribute name="class">active</xsl:attribute> </xsl:if> <a href="#">Друзья</a></li>
	</ul>	
<div class="bonusmarkc log">
	<div id="log1d" class="profile"> <xsl:if test="type='profile'"> <xsl:attribute name="class">profile active</xsl:attribute> </xsl:if>
	<xsl:apply-templates select="addsumm/ok"/> <xsl:apply-templates select="addsumm/er2"/> <div class="clear"></div>
	<div class="formb"> <xsl:choose> <xsl:when test="subtype=''"> <table> <tr> <th>Имя:</th> <td> <xsl:value-of disable-output-escaping="yes" select="name"/> </td> </tr> <tr> <th>Пол:</th> <td> <xsl:value-of disable-output-escaping="yes" select="sex"/> </td> </tr> <tr> <th>Эл. почта:</th> <td><xsl:value-of disable-output-escaping="yes" select="email"/></td> </tr> <tr> <th>Город:</th> <td><xsl:value-of disable-output-escaping="yes" select="cityName"/></td> </tr> <tr> <th>Дата рождения:</th> <td><xsl:value-of disable-output-escaping="yes" select="birthday"/></td> </tr> <tr> <th>Рассылка</th> <td> <xsl:value-of disable-output-escaping="yes" select="sending"/> </td> </tr> </table> <p class="profilea"> <a href="{domainImgName}myprofile-edit.html" class="myedit">Редактировать</a> <a href="{domainImgName}myprofile-pass.html" class="mypass">Сменить пароль</a> <a href="{domainImgName}myprofile-send.html" class="mysubs">Настроить рассылку</a> </p> </xsl:when> <xsl:otherwise> <xsl:apply-templates select="ok"/> <xsl:apply-templates select="er"/> <xsl:apply-templates select="form"/> <p class="profilea"> <a href="{domainImgName}myprofile.html" class="myedit">Вернуться</a> </p> </xsl:otherwise> </xsl:choose> </div> <div class="profilem"> Ваш баланс: <div> <strong><xsl:value-of disable-output-escaping="yes" select="balans"/>’</strong> <div> <span><xsl:value-of disable-output-escaping="yes" select="balans/@copeck"/></span> <p>руб.</p> </div> </div> <span id="hrefblns" class="a bttn" onClick="$('.payment-inner').slideToggle('fast');">Пополнить</span> 
	<div class="payment-inner">
	<div id="addblns" class="profileb"><span class="left frst">Сумма:</span><div class="input left"><input id="addSumm" name="addSumm" maxlength="5" type="text"/></div><span class="left"> руб.</span> <span onClick="fAddSumm()" class="left bttn">Пополнить</span>	
	<div class="clear"></div></div>
	<div id="payment-type" style="display:none;"> <span class="clear h3">Выберите метод оплаты</span> <ul class="methods"> <xsl:value-of disable-output-escaping="yes" select="pay"/> <div class="clear"></div> </ul> </div>
	</div>
	</div> 
	<div class="clear"></div>
	<xsl:if test="count(interest)>0">
		<div class="notbuy">
		<span class="h3">Недавно вы интересовались этими акциями </span>
		<xsl:for-each select="interest">
			<div class="block left">
				<a href="{../domainName}bonus{@id}.html" class="h4"> <xsl:if test="img!=''"><img src="{../domainName}{img}" align="left"/></xsl:if> <xsl:value-of disable-output-escaping="yes" select="name"/></a>
				<span class="calendar">Истекает <xsl:value-of disable-output-escaping="yes" select="date"/></span>
				<xsl:if test="discount>0"> <span class="price">Скидка <xsl:if test="count(offer)>1">до </xsl:if> <xsl:value-of disable-output-escaping="yes" select="discount"/>%</span> </xsl:if>
				<a href="{../domainName}bonus{@id}.html" class="bttn">Подробнее</a>
				<div class="clear"></div>
			</div>
		</xsl:for-each>
		<div class="clear"></div>
		</div>
	</xsl:if>
	</div> 
	<div id="log2d" class="coupon">
		<xsl:if test="type='bonuses' or coupon/ok!=''"> <xsl:attribute name="class">coupon active</xsl:attribute> </xsl:if>
		<xsl:apply-templates select="coupon/ok"/> <xsl:apply-templates select="coupon/er2"/>
		<div class="clear"></div>
		<div class="right fixed">
			<a href="{domainName}mybonuses.html" class="bttn long">Проверить платежи</a>
			<a href="{domainName}mybonuses.html" class="bttn long">Ваши купоны</a>
			<a href="{domainName}mybonuses.html?fl=nopaid" class="bttn long">Не оплаченные</a>
			<a href="{domainName}mybonuses.html?fl=ldate" class="bttn long">Прошедшие акции</a>
		</div>		
		<xsl:for-each select="offer">
			
			<div class="block"><xsl:if test="@ldate=1"><xsl:attribute name="class">block ldate</xsl:attribute></xsl:if>
				<div class="right">
					<xsl:choose>
						<xsl:when test="@used!='' or @paid=1"> 
							<a href="{domainName}print{@prId}.html?start=no" target="_blank" class="h4"><xsl:value-of disable-output-escaping="yes" select="name"/> <span class="colored"> За <xsl:value-of disable-output-escaping="yes" select="min"/> рублей<xsl:if test="item/max > item/min"> вместо <xsl:value-of disable-output-escaping="yes" select="max"/></xsl:if>. <xsl:if test="discount>0"> Скидка <xsl:value-of disable-output-escaping="yes" select="discount"/>% </xsl:if> </span> </a>
						</xsl:when>
						<xsl:otherwise> <a href="{domainName}bonus{@id}.html" class="h4"><xsl:value-of disable-output-escaping="yes" select="name"/> <span class="colored"> За <xsl:value-of disable-output-escaping="yes" select="min"/> рублей<xsl:if test="item/max > item/min"> вместо <xsl:value-of disable-output-escaping="yes" select="max"/></xsl:if>. <xsl:if test="discount>0"> Скидка <xsl:value-of disable-output-escaping="yes" select="discount"/>% </xsl:if> </span></a> </xsl:otherwise>
					</xsl:choose>
					
					<span class="paid"> 
						<xsl:choose>
							<xsl:when test="@used!=''"> <span> Использован <xsl:value-of disable-output-escaping="yes" select="@used"/> </span> </xsl:when> 
							<xsl:when test="@paid=1"> <span> Оплачен <xsl:value-of disable-output-escaping="yes" select="paydate"/> </span> </xsl:when> 
							<xsl:otherwise> <strong>Не оплачен.</strong> <a href="{../domainName}pay{@id}.html" class="bttn">Оплатить</a> </xsl:otherwise>
						</xsl:choose>
					</span>
					<xsl:if test="@used='' and @ownerId!='57'">
						<xsl:choose>
							<xsl:when test="@ldate=1">
								<span class="calendar{@paid}"> <xsl:if test="date">Действовал до <xsl:value-of disable-output-escaping="yes" select="date"/></xsl:if></span>
							</xsl:when>
							<xsl:otherwise>
								<span class="calendar{@paid}"> <xsl:if test="date">Действует до <xsl:value-of disable-output-escaping="yes" select="date"/></xsl:if></span>
							</xsl:otherwise>
						</xsl:choose>
						<xsl:if test="@paid=1">
							<span id="sendbonus{@prId}" class="mail a" onClick="fSendBonus({@prId},0)">Отправить на почту</span>
							<xsl:choose>
								<xsl:when test="@used!=''"> </xsl:when>
								<xsl:when test="@sendFriend!=''">
									<span class="favour a" onClick="$('#favourfriend').fadeIn('fast');">Подарен другу</span>
									<div class="present-inner">
										<div class="block give-present min" id="favourfriend">
											<div class="close" onClick="$('#favourfriend').fadeOut('fast');"></div>
											<p>Ваш подарок отправлен на почту:</p>
											<strong><xsl:value-of disable-output-escaping="yes" select="@sendFriend"/></strong>
											<div class="hr dashed"></div>
											<p class="min-text">Вы можете подарить этот купон только один раз.</p>
										</div>
									</div>
								</xsl:when>
								<xsl:otherwise>
									<span id="sendToFriend{@prId}" class="mail a" onClick="$('#give-present{@prId}').fadeIn('fast');">Подарить другу</span>
									<div class="present-inner">
										<div class="block give-present" id="give-present{@prId}">
											<div class="close" onClick="$('#give-present{@prId}').fadeOut('fast');"></div>
											<p>Введите e-mail вашего друга.</p>
											<div class="bttn" onClick="fSendBonus({@prId},1)">Подарить</div>
											<input type="text" value="" name="toFriends" id="toFriends{@prId}"/>
											<div class="clear"></div>
											<p class="min-text">Вы можете подарить этот купон только один раз.</p>
										</div>
									</div>
								</xsl:otherwise>
							</xsl:choose>
							<span target="_blank" class="print a" onclick="window.open('{domainName}print{@prId}.html', '_blank', ''); return false;">Распечатать</span>
						</xsl:if>
						<span id="sendFriend"></span>
					</xsl:if>
				</div>
				<div class="ldatediv"></div>
				<a href="{domainName}bonus{@ownerId}.html" class="profileprev">Вернуться к акции</a>
				<img src="{img}" alt="{name}" align="left"/>
				<div class="clear"></div>
			</div>
		</xsl:for-each>
		<xsl:if test="count(offer)=0"> <div class="alert">На текущий момент список Ваших купонов пуст.</div> </xsl:if>
		<div class="clear"></div>
	</div>
	<div id="log3d" class="friends"> <xsl:if test="type='friends'"> <xsl:attribute name="class">friends active</xsl:attribute> </xsl:if>
	<xsl:if test="count(friends)>0">
		<span class="h3">Друзья приглашенные Вами</span>
		<table> <tr> <th>E-mail</th> <th>Дата регистрации</th> </tr>
		<xsl:for-each select="friends">
			<tr>
				<td class="user"><xsl:value-of select="email"/></td>
				<td><xsl:value-of disable-output-escaping="yes" select="date"/></td>
			</tr>
		</xsl:for-each>
		</table> <br/>
	</xsl:if>	
<span class="h3"><b>ДОПОЛНИТЕЛЬНЫЙ ДОХОД, НОВЫЕ ВОЗМОЖНОСТИ!</b><br />
Мечта любого Россиянина получать деньги, и ничего не делать...</span>
<p>Идиотский вопрос от сайта удачных покупок &#171;Бонус Маус&#187;:<br/>
<ul>
    <li>Вы хотите этого?</li>
</ul>
Ответ любого <b>разумного</b> человека:<br/>
<ul>
    <li>Да! Да! Да!</li>
</ul>
Вопрос любого <b>умного</b> человека:<br/>
<ul>
    <li>Но как это возможно? Такого не бывает!!!</li>
</ul>
Неожиданный, сенсационный ответ сайта удачных покупок &#171;Бонус Маус&#187;:<br/>
<ul>
    <li>Ха-ха-ха!!! Мы утверждаем, что это возможно!!! Легко и просто!</li>
</ul>
Вопрос каждого <b>любопытного, практичного и продвинутого</b> человека:<br/>
<ul>
    <li>Как???</li>
</ul>
Простой и логичный ответ сайта удачных покупок &#171;Бонус Маус&#187;:<br/>
<ul>
    <li>Все элементарно: вы заходите на наш сайт, регистрируетесь и начинаете приглашать своих друзей, родственников, соседей, жен, любовниц и т.д. зарегистрироваться на сайте Бонус Маус с помощью кнопки в личном кабинете &#171;Пригласи друга&#187;, а также пригласив друзей в Facebook и Вконтакте. Вот собственно и все... После того как Ваши приглашенные друзья начнут совершать покупки на сайте &#171;Бонус Маус&#187; Вы начнете постоянно получать бонусы на Ваш личный счет. Полученные бонусы Вы сможете потратить на любые покупки на нашем сайте, более того, когда Ваши друзья будут приглашать своих друзей, Вы тоже будете получать с этого бонусы, и так бесконечно!</li>
</ul>
Вопрос <b>следователя</b>:<br/>
<ul>
    <li>Похоже на пирамиду?</li>
</ul>
Ответ самого продвинутого сайта &#171;Бонус Маус&#187;:<br/>
<ul>
    <li>Нет и еще раз нет! Мы делимся с нашими пользователями частью нашей прибыли от 5 до 20%, повышая тем самым лояльность покупателей и премируя наших друзей!!!</li>
</ul>
Вопрос <b>восхищенных</b> пользователей:<br/>
<ul>
    <li>Сколько я смогу на этом заработать?</li>
</ul>
Ответ <b>ведущего экономиста</b> сайта &#171;Бонус Маус&#187;:<br/>
<ul>
    <li>Предположим, Вы пригласили 100 друзей, каждый из которых в течение месяца потратил на покупки 1000 рублей. Ваше вознаграждение составит 1000 рублей. А вот дальше гораздо интересней: Ваши сто друзей пригласят еще по 100 друзей каждый, и они потратят всего по 1000 рублей в месяц. Тогда Ваше вознаграждение уже составит более 80 000 рублей. И так далее!!! Даже я не могу сразу посчитать, сколько Вы получите, если и у друзей Ваших друзей вдруг тоже найдутся свои друзья!!</li>
</ul>
Вопрос <b>офигевшего от изумления</b> пользователя:<br/>
<ul>
    <li>Куда бежать???</li>
</ul>
Ответ <b>надежного</b> друга и <b>партнера</b> &#8212; сайта &#171;Бонус Маус&#187;:<br/>
<ul>
    <li>К компьютеру!!! Регистрируйся скорей!!! И начинай приглашать друзей, пока их не пригласил кто-то другой!</li>
</ul>
</p>
		<a name="friends"></a> 
		<div class="frmess"><xsl:apply-templates select="fr/ok"/> <xsl:apply-templates select="fr/er"/> </div>
		<form action="#friends" method="post" class="block invite left">
			<span class="h4">Пригласить друга по электронной почте</span>
			<div class="input"><input type="text" name="invmail" onClick="this.value=''" value="Введите e-mail друга"/></div>
			<div class="textarea" id="invite_text"><textarea name="invtext" onFocus="$('#invite_text').addClass('active')">Приглашаю на сайт BonusMouse, эксклюзивных предложений от престижных заведений города</textarea></div>
			<input class="bttn" type="submit" value="Пригласить"/>
		</form>
		<div class="block invite">
			<span class="h4">Пошлите друзьям вашу персональную прямую ссылку</span>
			<div class="input"><input type="text" onClick="this.select()" value="{domainName}i{id}"/></div>
			<div class="linkimg">
				<a target="_blank" title="Пригласить через Твиттер" href="http://twitter.com/share?text=%D0%9F%D1%80%D0%B8%D0%B3%D0%BB%D0%B0%D1%88%D0%B0%D1%8E+%D0%B2%D1%81%D0%B5%D1%85+%D0%BD%D0%B0&#38;bonusmouse.ru&#38;url={domainName}i{id}" class="twitter">
					<img src="/im/twitter.png" alt="" width="32"/>
				</a>
				<a target="_blank" title="Пригласить через ВКонтакте" href="http://share.yandex.ru/go.xml?service=vkontakte&#38;url={domainName}i{id}&#38;note=%D0%9F%D1%80%D0%B8%D0%B3%D0%BB%D0%B0%D1%88%D0%B0%D1%8E+%D0%B2%D1%81%D0%B5%D1%85+%D0%BD%D0%B0&#38;bonusmouse.ru" class="vk">
					<img src="/im/vk.png" alt=""/>
				</a>
				<a target="_blank" title="Пригласить через Mail.ru" href="http://connect.mail.ru/share?share_url={domainName}i{id}" class="mailru">
					<img src="/im/mailru.png" alt=""/>
				</a>
				<a target="_blank" title="Пригласить через Facebook" href="http://www.facebook.com/sharer.php?u={domainName}i{id}&#38;t=%D0%9F%D1%80%D0%B8%D0%B3%D0%BB%D0%B0%D1%88%D0%B0%D1%8E+%D0%B2%D1%81%D0%B5%D1%85+%D0%BD%D0%B0&#38;bonusmouse.ru&#38;" class="facebook">
					<img src="/im/fb.png" alt=""/>
				</a>
				<script src="http://stg.odnoklassniki.ru/share/odkl_share.js" type="text/javascript" ></script>
				<script type="text/javascript" >
					$(window).load(function(){ODKL.init();});
				</script>
				<!--<a target="_blank" title="Пригласить через Одноклассники.ru" href="{domainName}i{id}" onclick="ODKL.Share(this);return false;" class="odkl-klass-oc">
					<img src="/im/odkl.png" alt=""/>
				</a>-->
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	</div>	
	</xsl:template> 
</xsl:stylesheet>

