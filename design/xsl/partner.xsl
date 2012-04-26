<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:import href="design/xsl/messages.xsl"/>
	<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items">
	<!-- <ul class="bonusmark bonush"> <li class="l active" id="log1"><a>Купоны</a></li> </ul> -->
	<div class="bonusmarkc log">
		<xsl:if test="fauth!=0">
			<div id="log2d" class="coupon prtn active">
				<xsl:apply-templates select="ok"/> <xsl:apply-templates select="er2"/>
				<div class="clear"></div>
				<xsl:choose>
					<xsl:when test="ident=2">
						<p class="couponinfo">Продано купонов: <strong><xsl:value-of select="count(offer[@paid=1])"/></strong><br/>Оказано услуг по купонам: <strong><xsl:value-of select="count(offer[@used!=''])"/></strong></p>
					</xsl:when>
					<xsl:otherwise>
						<xsl:call-template name="kassir"/>
					</xsl:otherwise>
				</xsl:choose>
				<xsl:for-each select="offer[@paid=1]">
					<div class="block"><xsl:if test="@used!=''"><xsl:attribute name="class">block opacity</xsl:attribute></xsl:if>
						<div class="right"> <xsl:if test="../ident=2"><xsl:attribute name="class">right long</xsl:attribute></xsl:if>
							<span class="numb">
								<xsl:value-of disable-output-escaping="yes" select="@uOfferId"/>/<xsl:value-of disable-output-escaping="yes" select="@firmId"/> 
							</span>
							<a href="{domainName}bonus{@ownerId}.html" class="mintext"><xsl:value-of disable-output-escaping="yes" select="name"/> / за <xsl:value-of disable-output-escaping="yes" select="min"/> рублей<xsl:if test="item/max > item/min"> вместо <xsl:value-of disable-output-escaping="yes" select="max"/> </xsl:if>. <xsl:if test="discount>0"> Скидка <xsl:value-of disable-output-escaping="yes" select="discount"/>% </xsl:if> </a>
							<xsl:if test="paydate!=''"> <span class="calendar1"> Оплачен <xsl:value-of disable-output-escaping="yes" select="paydate"/> </span> </xsl:if>
							<xsl:if test="@used!=''"> <span class="calendar1"> Использован <xsl:value-of disable-output-escaping="yes" select="@used"/> </span> </xsl:if>
							<span class="paid"> <form id="prtnForm2" method="post"> 
								<xsl:choose>
									<xsl:when test="@used!=''">
										<input name="couponId" type="hidden" value="{@uOfferId}"/> <input name="used" type="hidden" value="0"/> <input name="couponSbmt2" type="submit" class="bttn" value="Отменить использование"/>
									</xsl:when>
									<xsl:when test="../ident=2"></xsl:when>
									<xsl:otherwise>
										<input name="couponId" type="hidden" value="{@uOfferId}"/> <input name="used" type="hidden" value="1"/> <input name="couponSbmt2" type="submit" class="bttn" value="Отметить использованным"/>
									</xsl:otherwise>
								</xsl:choose>
							</form> </span>
						</div>
						<img src="{img}" alt="{name}" align="left"/>
						<div class="clear"></div>
					</div>
				</xsl:for-each>
				<div class="clear"></div>
			</div>
		</xsl:if>
		<xsl:if test="fauth!=1">
			<p class="alert">Для получения доступа, Вам необходимо авторизовать учетную запись партнера.</p>
		</xsl:if>		
	</div>
	</xsl:template>
	<xsl:template name="kassir">
		<div class="partner block ">
			<span class="h4">Форма проверки купона</span>
			<form id="prtnForm" method="POST" class="prtnInput">
				<div class="partner-inner left">
					<div class="input left" id="inputcouponId">
						<input name="couponId" maxlength="10" type="text" class="left" value="Номер купона:" onFocus="$('#inputcouponId input').addClass('active').attr('value','');"/>
					</div>
					<div class="h4 bold left"> / <xsl:value-of disable-output-escaping="yes" select="partner"/></div>
				</div>
				<div onClick="$('#prtnForm').submit()" class="bttn">Проверить</div>
			</form>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</xsl:template>
</xsl:stylesheet>

