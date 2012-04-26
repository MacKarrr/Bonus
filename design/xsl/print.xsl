<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:import href="design/xsl/messages.xsl"/>
<xsl:output method="html" encoding="windows-1251" indent="no"/>
<xsl:template match="items"> 
<xsl:if test="count(item)>0">
	<xsl:choose>
		<xsl:when test="print=1">
			<script type='text/javascript'>
				window.onload = function(){setTimeout(function () { window.print(); }, 100);}
			</script>
		</xsl:when>
		<xsl:otherwise>
			<div class="printbttn" onClick="$('.printbttn').addClass('hide');window.print();">Распечатать</div>
		</xsl:otherwise>
	</xsl:choose>
	<div class="right"><a href="{domainName}" class="logo"><img src="{domainName}image/metro/logo.png"/></a></div>
	<div class="head left">
		<h1>Скидочный купон</h1>
		Предъявите этот купон на месте, чтобы получить услугу
	</div>
	<div class="hr clear"></div>
	<div class="box left">Номер вашего купона:<h1><xsl:value-of disable-output-escaping="yes" select="firstId"/>/<xsl:value-of disable-output-escaping="yes" select="secondId"/></h1></div>
	<h2>
		<xsl:value-of disable-output-escaping="yes" select="item/offer/name"/><br/>
		<xsl:if test="item/percent=''">
			<xsl:if test="cnt=1"> <span>Скидка <xsl:value-of disable-output-escaping="yes" select="item/offer/discount"/>%</span> </xsl:if>
			<xsl:if test="cnt>1"> <span><xsl:value-of disable-output-escaping="yes" select="cnt"/> купона со скидкой <xsl:value-of disable-output-escaping="yes" select="item/offer/discount"/>%</span> </xsl:if>
		</xsl:if>
	</h2>
	<div class="clear"></div>
	<div class="m_clause">
		<xsl:for-each select="item">
			<xsl:if test="m_contacts!='' or address!=''">
				<div class="contacts">
					<xsl:if test="address!=''">
						<script type="text/javascript">
							YMaps.jQuery(function () {
								map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);
								var geocoder = new YMaps.Geocoder('<xsl:value-of disable-output-escaping="yes" select="address"/>', {results: 1, boundedBy: map.getBounds()});
								YMaps.Events.observe(geocoder, geocoder.Events.Load, function (geocoder) {
									placemark = geocoder.get(0).getGeoPoint();
									src = $('#address').attr('src')+'&#38;pt='+placemark+'&#38;ll='+placemark;
									$('#address').attr('src', src);
								});
							});
						</script>
						<div class="map"><div id="YMapsID"></div>
							<img id="address" src="http://static-maps.yandex.ru/1.x/?z=15&#38;size=400,231&#38;&#38;l=map&#38;key=ABYQNEkBAAAAgM-ZTwMAK_IKAfJkc-72mWoAq8el6lFmTeEAAAAAAAAAAAChHQgTyECkUqGduyet_fMaeQ6ckw==" alt="{address}"/>
						</div>
					</xsl:if>
					<div class="m_contacts" style="height:250px;"><xsl:if test="address=''"><xsl:attribute name="class">m_contacts</xsl:attribute></xsl:if>
						<h2>Цена <strong> <xsl:value-of disable-output-escaping="yes" select="../cost"/></strong>'<span><xsl:value-of disable-outpu-escaping="yes" select="../cost/@copeck"/></span> руб.</h2>
						<xsl:choose>
							<xsl:when test="percent!=''">
								<xsl:value-of disable-output-escaping="yes" select="percent"/>
							</xsl:when>
							<xsl:otherwise>
								<p>Цена (без скидки) <strong><xsl:value-of disable-output-escaping="yes" select="../cost2"/></strong> руб.</p>
							</xsl:otherwise>
						</xsl:choose>
						<div class="hr"></div>
							<xsl:value-of disable-output-escaping="yes" select="m_contacts"/>
						<div class="hr"></div>
						<p>Воспользоваться купоном можно до <strong><xsl:value-of disable-output-escaping="yes" select="offer/date"/></strong></p>
					</div>
					
					<div class="clear"></div>
				</div>
			</xsl:if>
		<xsl:if test="m_clause!=''" style="height:588px;overflow:hidden;"><div class="hr"></div><h3>Условия</h3> <xsl:value-of disable-output-escaping="yes" select="m_clause"/></xsl:if>
		</xsl:for-each>
	</div>
	<div class="hr clear"></div>
	<span class="comment">Если вам не понравилось заведение или сотрудники недостаточно вежливы, обязательно <a href="http://bonusmouse.ru/backlink.html">напишите нам</a><br/>Мы обязательно разберёмся.</span>
	<span class="comment">Если вы не получили услугу по купону то его возможно ВСЕГДА возвратить через Ваш личный кабинет и вернуть все Ваши деньги на баланс БонусМаус  после окончания действия акции </span>
	<div class="dashed"></div>
	<div class="" style="width:700px;margin:0 auto;">
		<img src="{domainName}image/banner01.jpg" alt="Русское Радио"/>
	</div>
</xsl:if>
<xsl:if test="count(item)=0 or item/text=''"> <div class="alert">По данному разделу информация находится на стадии наполнения</div> </xsl:if>
</xsl:template>
</xsl:stylesheet>