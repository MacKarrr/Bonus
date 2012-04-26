<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items"> 
<xsl:if test="count(item)>0">
<div style="margin:0;padding:0;background:url({domainName}image/bg4.jpg) 50% 0 repeat-y;">
<div style="width:100%;background:url({domainName}image/bg3.jpg) 50% 0 no-repeat;">
	<div style="width:765px;padding:10px;margin:0;">
		<div style="background:#ffd700;font-family:Tahoma,Geneva,sans-serif;font-size:17px;padding:0px 10px 10px;">
			<div style="float:left;"><img src="{domainName}image/logo2.jpg" alt="BonusMouse.ru"/></div>
			<div style="float:right;padding:20px 20px 0 0;color:#FFF;text-align:right;font-size:20px;text-shadow:0 0 3px #000;-moz-text-shadow:0 0 3px #000;-webkit-text-shadow:0 0 3px #000;z-index:1;">Предложение в городе <strong style="display:block;margin:10px 0;font-size:28px;">Уфа</strong></div>
			<div style="clear:both;"></div>
			<div class="cont" style="z-index:1;width:100%;">
				<table>
					<col width="415px"/><col width="320px"/>
					<tr>
						<td valign="top">
							<div class="item" style="font-size:15px;background:rgba(155, 155, 155, 0.5);background:url({domainName}image/bg-opacity.png);padding:10px;border-radius:10px;">
								<div class="item-inner" style="background:#FFF;padding:10px;border-radius:5px;">
									<h1 style="margin:0;padding:0 50px 5px 0;font-size:24px;font-weight:normal;color:#000;"><a href="{domainName}bonus{item/@id}.html"><xsl:value-of disable-output-escaping="yes" select="item/name"/></a></h1>
									<img src="{domainName}{item/img}" alt="{name}"/>
								</div>
							</div>
							<div style="background:rgba(155, 155, 155, 0.5);background:url({domainName}image/bg-opacity.png);margin:5px 0;padding:10px;border-radius:10px;">
								<div class="buyoffer" style="background:#FFF;padding:5px 10px;border-radius:5px;margin:5px 0;">
									
									<div style="width:264px;float:right;margin:12px 0 0;">
										<table cellpadding="0" cellspacing="0" width="100%">
											<col width="50%"/><col width="50%"/>
											<tr>
												<td align="center" style="background:#BBBBBB;text-align:center;padding:2px 10px;">Цена <strong style="display:block;white-space:nowrap;color:#000;"><xsl:value-of disable-output-escaping="yes" select="item/min"/> руб.</strong></td>
												<td align="center" valign="top" style="background:#D7D7D7;text-align:center;color:#707070;padding:2px 10px;">
												<xsl:choose>
													<xsl:when test="percent!=''">
														<xsl:value-of disable-output-escaping="yes" select="percent"/>
													</xsl:when>
													<xsl:otherwise>
														<xsl:if test="item/discount>0"> Скидка: <strong style="display:block;white-space:nowrap;color:#000;"><xsl:value-of disable-output-escaping="yes" select="item/discount"/>%</strong> </xsl:if>
													</xsl:otherwise>
												</xsl:choose>
												</td>
											</tr>
										</table>
									</div>
									
									<a href="{domainName}bonus{item/@id}.html" class="bttn" style="z-index:10;background:url({domainName}im/bttn.png) 0 -179px no-repeat;cursor:pointer;height:63px;margin:-2px 0 0;width:130px;font-size:24px;line-height:60px;text-align:center;color:#FFF;text-decoration:none;display:block;float:left;">Смотреть</a>
									
									<div style="clear:both;"> </div>
								</div>
							</div>
						</td>
						<td valign="top">
							<div style="font-size:13px;background:rgba(155, 155, 155, 0.5);background:url({domainName}image/bg-opacity.png);padding:10px;border-radius:10px;width:298px;">
								<div style="padding:10px;background:#FFF;border-radius:5px;">
								<div>
									<h3>Еще акции:</h3>
									<xsl:for-each select="item">
										<xsl:if test="position()=2">
											<xsl:value-of disable-output-escaping="yes" select="name"/>
											<div class="item-second">
												<a href="{../domainName}bonus{@id}.html" class="bttn" style="background:url({../domainName}im/bttn.png) 0 -179px no-repeat;cursor:pointer;height:63px;margin:2px 0 0;width:130px;font-size:24px;line-height:60px;text-align:center;color:#FFF;display:block;float:right;">Смотреть</a>
												<div style="width:130px;">
													<img src="{../domainName}{img}" alt="{name}" title="{name}" style="margin:12px 5px 0;height:42px;min-height:42px;max-height:42px;"/>
												</div>
											</div>   
											<table class="price" width="100%" style="font-size:14px;color:#707070;">
												<col width="50%"/><col width="50%"/><col width="30%"/>
												<tr>
													<td valign="top">Цена</td><td valign="top">Скидка</td>
												</tr>
												<tr>
													<td valign="top"><strong style="font-weight:normal;color:#000;"><xsl:value-of disable-output-escaping="yes" select="min"/> руб.</strong></td>
													<td valign="top"><xsl:if test="discount>0"><strong style="font-weight:normal;color:#000;"><xsl:value-of disable-output-escaping="yes" select="discount"/>%</strong></xsl:if></td>
												</tr>
											</table>
											<div style="border-bottom:1px dashed #AAA;margin:10px 0;"> </div>
										</xsl:if>
									</xsl:for-each>
									<xsl:for-each select="item">
										<xsl:if test="position()!=1 and position()!=2">
											<xsl:value-of disable-output-escaping="yes" select="name"/>
											<div style="clear:both;"> </div>
											<div style="padding:10px 0 0;margin:0 0 10px;width:298px;">
												<div style="float:right;width:72px;"><a href="{../domainName}bonus{@id}.html" style="background:url({../domainName}im/bttn.png) 0 -35px no-repeat;margin:0 0 0 -10px;height:35px;line-height:35px;width:72px;font-size:14px;color:#FFF;text-align:center;display:block;">Смотреть</a></div>
												<div style="float:left;width:226px;">
												<h3 style="background:#D5D5D5;display:block;margin:4px 0 0; padding:0 2px; float:left;width:100px;text-align:left;font-size:14px;line-height:27px;white-space:nowrap;border-right:2px solid #FFF;padding-left:10px;"><xsl:value-of disable-output-escaping="yes" select="min"/> руб.</h3>
												<div class="left" style="background:#E5E5E5;margin:4px 0 0;line-height:27px;width:101px;font-size:12px;padding:0 0 0 10px;overflow:hidden;white-space:nowrap;"><xsl:if test="discount>0"> Скидка: <strong><xsl:value-of disable-output-escaping="yes" select="discount"/>%</strong> </xsl:if> </div>
												</div>
												<div style="clear:both;"> </div>
											</div>
											<xsl:if test="position()!=last()"><div style="border-bottom:1px dashed #CCC;margin:10px 0;"> </div></xsl:if>
										</xsl:if>
									</xsl:for-each>
								</div>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div class="info" style="width:auto;background:#FFFFFF;padding:10px;border-radius:10px;margin:10px 0 0;border:1px solid #CCC;font-size:17px;font-family:Tahoma,Geneva,sans-serif;color:#979795;">Служба поддержки: 8 (347) 246-86-56 | <a href="{domainName}backlink.html" style="color:#27478a">bonusmouse@mail.ru</a> | <a href="{domainName}myprofile-send.html" style="color:#27478a">отписаться от рассылки</a><br/>Адрес: 450059б  г.Уфа, ул. Р.Зорге, 9/6, 4 этаж	</div>
		</div>
	</div>
</div>
</div>
</xsl:if>
	</xsl:template> 
</xsl:stylesheet>