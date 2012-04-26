<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:import href="design/xsl/messages.xsl"/>
<xsl:output method="html" encoding="windows-1251" indent="no"/>

<xsl:template match="items"> <xsl:if test="count(item)>0">
	<div class="itemcontainer">
	<xsl:for-each select="item">
		<script type="text/javascript" src="/scripts/timer.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				var month = <xsl:value-of select="sysdate/month"/>-1;
				$('.countdown').countdown(new Date(2012, month, <xsl:value-of select="sysdate/day"/>, 23, 59, 59), {prefix:'', finish: ' '});
			});
		</script>
		<div class="bonush">
			<span class="h2">
				<xsl:value-of disable-output-escaping="yes" select="name"/>
				<xsl:if test="discount>0"> &#160;<strong>  Скидка <xsl:if test="count(offer)>1">до </xsl:if> <xsl:value-of disable-output-escaping="yes" select="discount"/>%</strong> </xsl:if>
			</span>
			<!-- <div class="date"><xsl:value-of disable-output-escaping="yes" select="date"/></div> -->
			<a href="{../domainName}" class="prev date"><div class="item"></div>К списку акций</a>
		</div>
		<div class="bonusi text">
			<div class="info">
			<xsl:if test="@id=57">
				<div class="block" style="padding:10px;">
					<strong style="width:290px;display:block;line-height:36px;height:36px;font-weight:normal;padding:0 0 5px;">
						<span style="font-size:15px;display:block;float:left;">Стоимость голосования</span>
						<span style="font-size:32px;display:inline-block;float:left;margin:0 0 0 10px;"><xsl:value-of disable-output-escaping="yes" select="min"/> руб.</span>
					</strong>
					<span style="white-space:normal;font-size:12px;color:#666;">Для голосования поставьте галочку в клетке напротив фамилии кандидата.</span>
				</div>
			</xsl:if>
			<xsl:if test="@id!=57">
				<div class="price">
					<div class="right" style="position:relative;">
						<xsl:choose>
							<xsl:when test="count(offer)=1 and ../auth=1 or ../fauth=1">
								<a href="{../domainName}pay{offer/@id}.html" class="bttn active">Купить</a>
							</xsl:when>
							<xsl:when test="count(offer)>0 and active=0"><div class="bttn" id="buybttn"></div></xsl:when>
							<xsl:when test="@id=57"></xsl:when>
							<xsl:when test="count(offer)>0 and ../auth=0 and ../fauth=0"><div class="bttn active" id="buybttn" onClick="fShowAuth()">Купить</div> </xsl:when>
							<xsl:otherwise>
								<xsl:if test="../authsend=1"> <script type="text/javascript"> $(document).ready(function() { fShowOffer() }); </script> </xsl:if>
								<div class="buyblock" id="buyblock"> 
									<div class="bonush"><span class="h2">Выберите предложение:</span><div id="lboxClose"></div></div>
									<div class="buyblockc">
										<xsl:for-each select="offer">
											<div class="buyoffer">
												<span class="h4"><xsl:value-of disable-output-escaping="yes" select="name"/></span>
												<div class="buyofferi">
													<span class="h3"><xsl:value-of disable-output-escaping="yes" select="min"/> руб.</span>
													<div class="left">
														<span class="paid">
															<xsl:if test="@paid>0"> 
																<span>Купили <strong><xsl:value-of disable-output-escaping="yes" select="@paid"/></strong> человек.</span>
															</xsl:if>
															<xsl:if test="@paid=0"> Cтаньте первым купившим! </xsl:if>
														</span>
														Стоимость: <strong><xsl:value-of disable-output-escaping="yes" select="max"/> руб.</strong> <span class="li"></span>
														<xsl:if test="discount>0"> Скидка: <strong><xsl:value-of disable-output-escaping="yes" select="discount"/>%</strong> </xsl:if>
													</div>											
													<a href="{../../domainName}pay{@id}.html" class="bttn active">Купить</a>
													<div class="clear"></div>
												</div>
												<xsl:if test="descr!=''">
													<span class="a right" id="details{position()}">подробнее</span>
													<!-- <p>Истекает <xsl:value-of disable-output-escaping="yes" select="date"/></p> -->
													<div class="clear"></div>
													<div class="buyofferc" id="details{position()}s">
														<xsl:value-of disable-output-escaping="yes" select="descr"/>
													</div>
													<div class="clear"></div>
												</xsl:if>
												<!-- <xsl:if test="descr=''">
													<p>Истекает <xsl:value-of disable-output-escaping="yes" select="date"/></p>
												</xsl:if> -->
											</div>
										</xsl:for-each>
									</div>
								</div>
								<div class="bttn active" id="buybttn" onClick="fShowOffer()">Выбрать</div>
							</xsl:otherwise>
						</xsl:choose>
					</div>
					<div class="left">
						<div class="priceblock">
							<div class="other"><span class="copeck"><xsl:value-of disable-output-escaping="yes" select="min/@copeck"/></span><span>руб.</span></div>
							<strong><xsl:value-of disable-output-escaping="yes" select="min"/>’</strong>
							<xsl:if test="count(offer)>1"><div>от</div></xsl:if>
						</div>
						<div>
							<xsl:choose>
								<xsl:when test="percent!=''">
									<div style="white-space:normal;line-height:120%;"><xsl:value-of disable-output-escaping="yes" select="percent"/></div>
								</xsl:when>
								<xsl:otherwise>
									<xsl:if test="discount>0">Скидка <xsl:if test="count(offer)>1">до </xsl:if> <strong><xsl:value-of disable-output-escaping="yes" select="discount"/>%</strong></xsl:if>
								</xsl:otherwise>
							</xsl:choose>
						</div>
						<div class="other"><xsl:if test="discount>0">без скидки <xsl:if test="count(offer)>1">до </xsl:if> <strong><xsl:value-of disable-output-escaping="yes" select="max"/> руб.</strong> </xsl:if></div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="buy-to-gift">
					<span class="a" onClick="$('#buy-to-gift-inner').fadeIn('fast');">Купить в подарок</span>
					<div class="clear"></div>
					<div id="buy-to-gift-inner" class="block">
						<div class="close" onClick="$('#buy-to-gift-inner').fadeOut('fast');"></div>
						<p>Если вы хотите подарить этот купон, то вам необходимо будет оплатить его, и далее в разделе <a href="{../domainName}mybonuses.html">"Купоны"</a> вашего личного кабинета вы сможете отправить данный купон вашему другу.</p>
					</div>
				</div></xsl:if>
				<xsl:if test="active!=0"><div class="clock">
					До завершения осталось
					<strong class="countdown"> </strong>
				</div></xsl:if>
				<div class="peop">
					Купили: <strong><xsl:value-of disable-output-escaping="yes" select="paidUsers"/></strong> человек<br/>
					Интересовались: <strong><xsl:value-of disable-output-escaping="yes" select="interest"/></strong> человек
				</div>
				<div class="like">
					
					<script type='text/javascript' src='http://vkontakte.ru/js/api/share.js'></script>
					<script type='text/javascript' src='http://stg.odnoklassniki.ru/share/odkl_share.js'></script>
					<script type='text/javascript'> window.onload = ODKL.init(); </script>
					<script type='text/javascript' src='http://cdn.connect.mail.ru/js/share/2/share.js?ver=3.0.2PagoodEdition'></script>
					<script type='text/javascript' src='http://static.ak.fbcdn.net/connect.php/js/FB.Share?ver=3.0.2PagoodEdition'></script>
					<script type='text/javascript' src='http://platform.twitter.com/widgets.js?ver=3.0.2PagoodEdition'></script>
					<script type="text/javascript"> document.write(VK.Share.button({url: '<xsl:value-of disable-output-escaping="yes" select="../domainName"/>bonus<xsl:value-of disable-output-escaping="yes" select="@id"/>.html', title: '<xsl:value-of disable-output-escaping="yes" select="name"/>', description: ''},{type: 'button', text: 'Поделиться'})); </script>
					<a rel='nofollow' title='Опубликовать в Facebook' name="fb_share" type="button_count" share_url='{../domainName}bonus{@id}.html'>Поделиться</a>
					<div class="clear"></div>
					<a rel='nofollow' title='Опубликовать в Twitter' href='http://twitter.com/share' data-url='{../domainName}bonus{@id}.html' data-text='{name}' class='twitter-share-button' data-count='horizontal' data-via='{../domainName}'>Tweet</a>
					<a onclick="ODKL.Share(this);return false;" href="{../domainName}bonus{@id}.html" class="odkl" rel="nofollow"><span>0</span></a>
					<a rel='nofollow' title='Опубликовать в Моём Мире' class='mrc__share' type='button_count' href='http://connect.mail.ru/share?share_url={../domainName}bonus{@id}.html'>В Мой Мир</a>
					
				</div>
				
			</div>
			<xsl:if test="count(img)>1">
			<script type="text/javascript" src="/scripts/slider.js"></script>
			<script type="text/javascript">
			$(document).ready(function() {
				$('#slider').fSlider({
					timeOut: 3000
				});
			});
			</script>
			</xsl:if>
			<div class="img" id="slider">
				
				<xsl:if test="@id=57">
					<div class="votelist">
						<script type="text/javascript">
						$(document).ready(function(){
							$('.votepercent').each(function(){
								width=0;
								if($(this).attr('name')!=0){
									width = $(this).attr('id')*100 / $(this).attr('name');
									width = Number(width).toFixed(2);
								}
								$(this).find('div div').css({'width':width+'%'});
								$(this).find('div span').html(width+'%');
							});
						});	
						</script>
						<xsl:for-each select="offer">
							<div class="bold"><xsl:value-of disable-output-escaping="yes" select="name"/></div>
							<div class="votepercent" name="{../paidUsers}" id="{@paid}"><div><div></div><span></span></div></div>
							<div class="clear"></div>
						</xsl:for-each>
					</div>
				</xsl:if>
				<ul id="sliderContent">
				<xsl:for-each select="img">
					<li class="sliderImage"> <img src="{../domainName}{.}" alt="{../item/name}"/> <span></span></li>
				</xsl:for-each>
					<div class="clear sliderImage"></div>
				</ul>
			</div>
			<div class="clear"></div>
			<script type="text/javascript" src="/scripts/marks.js"></script>
				<div class="bonusmark">
					<ul class="marks">
						<li id="mark1"> <xsl:if test="../ok='' and ../er=''"> <xsl:attribute name="class">active</xsl:attribute> </xsl:if> Описание </li>
					<xsl:if test="count(../comment)>0">
						<li id="mark2"> <xsl:if test="../ok!=''"> <xsl:attribute name="class">active</xsl:attribute> </xsl:if> Комментарии </li>
					</xsl:if>
						<li id="mark3"> <xsl:if test="../er!=''"> <xsl:attribute name="class">active</xsl:attribute> </xsl:if> <xsl:if test="../auth=0 and ../fauth=0"> <xsl:attribute name="onClick">fShowAuth()</xsl:attribute> </xsl:if> Оставить комментарий </li>
					</ul>
				</div>
				<a name="form"></a>
				<div class="bonusmarkc">
				<xsl:choose>
					<xsl:when test="@id=57">
						<div id="mark1d"> <xsl:if test="../ok='' and ../er=''"> <xsl:attribute name="class">active</xsl:attribute> </xsl:if>
						<table width="100%" class="vyibory-border">
							<tr>
								<td>
									<table width="100%" class="borderall shtrih">
										<tr>
											<td class="borderall" style="background:#000;"></td>
											<td class="borderall"></td>
											<td class="borderall"></td>
											<td class="borderall"></td>
											<td class="borderall"></td>
											<td class="borderall"></td>
											<td class="borderall"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td class="padding">
									<table width="100%" class="borderall">
										<tr>
											<td class="borderall" style="padding:10px 0;">
<span class="h1 center">КУПОН-БЮЛЛЕТЕНЬ</span>
<p class="center" style="padding:0;">участника благотворительной акции, приуроченной к выборам</p>
<span class="h3 center">Президента Росийской Федерации</span>
<span class="h3 center">4 марта 2012 года</span>
											</td>
											<td rowspan="2" class="borderall"><img src="/im/vyibory.jpg" alt="Благотворительная акция от BonusMouse.ru"/></td>
										</tr>
										<tr>
											<td class="borderall" style="padding:5px 20px;">
											<xsl:value-of disable-output-escaping="yes" select="m_bonus"/>
											</td>
										</tr>
									</table>
									<table width="100%" class="borderall">
										<xsl:for-each select="offer">
											<tr>
												<td style="border-left:1px solid #000;padding:0 10px 0 20px;"><xsl:if test="position()!=last()"><xsl:attribute name="class">borderbottom</xsl:attribute></xsl:if><span class="h4 bold"><xsl:value-of disable-output-escaping="yes" select="name"/></span></td>
												<td class="justify"><xsl:if test="position()!=last()"><xsl:attribute name="class">justify borderbottom</xsl:attribute></xsl:if><xsl:value-of disable-output-escaping="yes" select="descr"/></td>
												<td style="border-right:1px solid #000;"><a href="{../../domainName}pay{@id}.html" class="galka">&#160;</a></td>
											</tr>
										</xsl:for-each>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="100%" class="borderall shtrih">
										<tr>
											<td class="borderall"></td>
											<td class="borderall"></td>
											<td class="borderall"></td>
											<td class="borderall"></td>
											<td class="borderall"></td>
											<td class="borderall" style="background:#000;"></td>
											<td class="borderall"></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						</div>
					</xsl:when>
					<xsl:otherwise>
						<xsl:if test="m_contacts!='' or address!='' or m_bonus!='' or m_clause!='' or m_special!=''">
							<div id="mark1d"> <xsl:if test="../ok='' and ../er=''"> <xsl:attribute name="class">active</xsl:attribute> </xsl:if>
								<xsl:if test="m_contacts!='' or address!=''">
									<div class="contacts">
										<xsl:if test="address!=''">
											<div id="mapico">
												<div class="vertical">К а р т а</div>
											</div>
										</xsl:if>
											<div class="m_contacts wpadding"><xsl:if test="address=''"><xsl:attribute name="class">m_contacts wide</xsl:attribute></xsl:if>
												<span class="h3">Контакты:</span>
													<xsl:value-of disable-output-escaping="yes" select="m_contacts"/>
													<xsl:if test="address!=''">
														<script src="http://api-maps.yandex.ru/1.1/index.xml?key=AKMh304BAAAAYtugUAIAqQLKHmzNhyIRx4V4pqyrD3G9WBwAAAAAAAAAAACL6u51D_X8rv_E7rqRxw4NfwGcyA==" type="text/javascript"></script>
														<script type="text/javascript" src="/scripts/maps.js"></script>
														<ul class="address">
															<xsl:for-each select="address">
																<li onClick="yMaps('{.}');return 0;" class="a">
																	<xsl:value-of disable-output-escaping="yes" select="."/>
																</li>
															</xsl:for-each>
														</ul>
													</xsl:if>
												<div class="clear"></div>
											</div>
											<xsl:if test="address!=''">
												<div class="map hide"><div id="YMapsID"></div></div>
												<div id="addr">
													<xsl:for-each select="address">
														<input type="hidden" value="{.}"/>
													</xsl:for-each>
												</div>
											</xsl:if>
											<div class="clear"></div>
									</div>
								</xsl:if>
								<xsl:if test="m_bonus!=''">
										<xsl:value-of disable-output-escaping="yes" select="m_bonus"/>
								</xsl:if>
								<xsl:if test="m_clause!='' or m_special!=''">
								<a name="m_clause"></a>
								<div class="clause"> <div class="clauseins">
									<xsl:if test="m_clause!=''">
										<div class="left">
											<span class="h2">Условия</span> <xsl:value-of disable-output-escaping="yes" select="m_clause"/>
										</div>
									</xsl:if>
									<xsl:if test="m_special!=''">
										<div class="left">
											<span class="h2">Особенности</span> <xsl:value-of disable-output-escaping="yes" select="m_special"/>
										</div>
									</xsl:if>
									<div class="clear"></div>
								</div> </div>
								</xsl:if>
							</div>
						</xsl:if>
					</xsl:otherwise>
				</xsl:choose>
						<xsl:if test="count(../comment)>0">
						<div id="mark2d"> <xsl:if test="../ok!=''"> <xsl:attribute name="class">active</xsl:attribute> </xsl:if>
							<span class="h2">Комментарии к акции</span>
							<xsl:for-each select="../comment">
								<div class="comment"><div>
									<xsl:value-of disable-output-escaping="yes" select="comment"/>
									<span class="clear"></span>
									<span class="right"><xsl:if test="userName!=' '"><strong><xsl:value-of disable-output-escaping="yes" select="userName"/></strong>,</xsl:if> <xsl:value-of disable-output-escaping="yes" select="date"/></span> <span class="clear"></span>
									<xsl:if test="answer!=''"> <div class="answer"> <strong>BonusMouse.ru: </strong> <xsl:value-of disable-output-escaping="yes" select="answer"/> </div> </xsl:if>
								</div></div>
							</xsl:for-each>
						</div>
						</xsl:if>
						<div id="mark3d"> <xsl:if test="../er!=''"> <xsl:attribute name="class">active</xsl:attribute> </xsl:if>
							<div class="comment"><div>
							<xsl:if test="../auth=0 and ../fauth=0">
								<span class="alert auto"> Для возможности оставлять комментарии Вам необходимо <span onClick="fShowAuth()" class="a"> авторизоваться </span> </span>
							</xsl:if>
							<xsl:if test="../auth=1 or ../fauth=1">						
								<form name="{../form/@name}" action="{../form/action}" method="post" enctype="multipart/form-data">
									<a name="form"></a>
									<div class="left">
									<xsl:for-each select="../form/field">
									<xsl:choose>
										<xsl:when test="@type='textarea'"> 
											<div class="textarea">
												<label for="{@name}" id="l{@name}"><xsl:if test="@error=1"><xsl:attribute name="class">err</xsl:attribute></xsl:if><xsl:value-of select="caption"/></label>
												<textarea id="{@name}" name="{@name}" rows="{@rows}"> <xsl:value-of disable-output-escaping="yes" select="value"/> </textarea> 
											</div> 
										</xsl:when>
										<xsl:when test="@type='secret'">
											<span class="captha"><img src="{@src}" height="25" align="left"/>&#160;</span> 
											<div class="secret"> <label for="{@name}" id="l{@name}"><xsl:if test="@error=1"><xsl:attribute name="class">err</xsl:attribute></xsl:if><xsl:value-of select="caption"/></label> <input id="{@name}" type="text" name="{@name}" maxlength="5" /> </div>
										</xsl:when>
										<xsl:when test="@type='submit'"> <input type="{@type}" name="{@name}" value="{value}" class="bttn long"/> </xsl:when>
									</xsl:choose>
									</xsl:for-each>
									</div>
									<div class="right"> <xsl:if test="../er=''"> <span class="alert"> Перед добавлением нового комментария, изучите, пожалуйста, условия акции и <a href="{../domainName}faq.html"> часто задаваемые вопросы</a></span> </xsl:if> <xsl:if test="../er!=''"> <span class="error"> <xsl:value-of disable-output-escaping="yes" select="../er"/> </span> </xsl:if> </div>
								</form>
							</xsl:if>
							<div class="clear"></div>
							</div></div>
						</div>
				</div>
			<div class="clear"></div>
		</div>
	</xsl:for-each> </div> </xsl:if> 
</xsl:template> 
</xsl:stylesheet>