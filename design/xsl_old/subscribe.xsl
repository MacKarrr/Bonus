<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items"> 
<xsl:if test="count(item)>0">
<table width="100%" cellspacing="0" cellpadding="5" border="0" height="1px" style="min-height:1px;font:14px Tahoma;" bgcolor="#FFF">
	<tr>
		<td align="center" valign="middle">
		<table width="670" cellspacing="0" cellpadding="5" border="0" height="1px" style="min-height:1px;font:14px Tahoma;" bgcolor="#ffd700">
			<tr>
				<td align="center" valign="middle" bgcolor="#a20203">
					<table cellspacing="0" cellpadding="0" border="0" width="660" bgcolor="#ffd700">
						<tr>
							<td align="center">
								<table width="100%" cellspacing="0" cellpadding="0">
									<col width="340"/><col width="285"/><col width="35"/>
									<tr>
										<td>
											<a href="{domainName}" title="BonuseMouse.ru" align="center"><img src="{domainName}image/logo3.jpg" alt="BonusMouse.ru"/></a>
										</td>
										<td align="right" valign="middle">
											<h1 style="color:#FFF;font-weight:normal;font-size:18px;padding:0 8px 0 0;">Предложение в городе <strong style="display:block;margin:10px 0;font-size:28px;">Уфа</strong></h1>
										</td>
										<td></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<table width="660" cellspacing="0" cellpadding="0" border="0">
									<tr>
										<td align="center">
											<table width="600" cellspacing="0" cellpadding="0" border="0" background="{domainName}image/mail/mail_corners_top.png">
												<tr>
													<td height="26"> </td>
												</tr>
											</table>
											<table width="600" cellspacing="0" cellpadding="0" border="0" background="{domainName}image/mail/mail_middle.png">
												<col width="25"/><col width="550"/><col width="25"/>
												<tr>
													<td> </td>
													<td height="50" valign="top">
														<table width="100%" cellspacing="0" cellpadding="0" border="0">
															<col width="212"/><col width="10"/><col width=""/>
															<xsl:for-each select="item">
																<xsl:if test="position()=1 or position()=2 or position()=3 or position()=4">
																	<tr>
																		<td valign="top">
																			<a href="{../domainName}bonus{@id}.html"><img src="{../domainName}{img}" width="212"/></a>
																		</td>
																		<td valign="top">
																		</td>
																		<td valign="top" style="line-height:100%;">
																			<a href="{../domainName}bonus{@id}.html" style="text-decoration:none;font-weight:bold;color:#000;"><xsl:value-of disable-output-escaping="yes" select="name"/> <span style="color:#d61000;white-space:nowrap;">
<xsl:choose>
	<xsl:when test="percent!=''">&#160;<xsl:value-of disable-output-escaping="yes" select="percent"/></xsl:when>
	<xsl:otherwise><xsl:if test="discount>0"> Скидка <xsl:if test="count(offer)>1">до </xsl:if> <xsl:value-of disable-output-escaping="yes" select="discount"/>% </xsl:if></xsl:otherwise>
</xsl:choose>
																			</span></a>
																			<table width="100%" cellspacing="0" cellpadding="0" border="0">
																				<col width=""/><col width="120"/><col width="180"/>
																				<tr>
																					<td colspan="3" style="font-size:11px;color:#666;"><br/>
																					<xsl:if test="discount>0">Цена без скидки: <xsl:if test="count(offer)>1">до </xsl:if> <strong><xsl:value-of disable-output-escaping="yes" select="max"/> руб.</strong> </xsl:if>
																					</td>
																				</tr>
																				<tr>
																					<td rowspan="2" align="right" style="font-size:38px;line-height:100%;">
																						<xsl:value-of disable-output-escaping="yes" select="min"/>'
																					</td>
																					<td style="font-size:14px;line-height:100%;"><xsl:value-of disable-output-escaping="yes" select="min/@copeck"/></td>
																					<td align="right" rowspan="2">
																						<a href="{../domainName}bonus{@id}.html"><img src="{../domainName}image/mail/mail_bttn.png"/></a>
																					</td>
																				</tr>
																				<tr>
																					<td style="font-size:10px;">руб.</td>
																				</tr>
																			</table>
																		</td>
																	</tr>
																	<tr>
																		<td colspan="3">
																			<div style="border-bottom:1px solid #CCC;margin:10px 0;"></div>
																		</td>
																	</tr>
																</xsl:if>
															</xsl:for-each>
														</table>
														
														<table width="100%" cellspacing="0" cellpadding="0" border="0">
															<col width="128"/><col width="13"/><col width="128"/><col width="13"/><col width="128"/><col width="12"/><col width="128"/>
															<tr>
															<xsl:for-each select="item">
																<xsl:if test="position()=5 or position()=6 or position()=7 or position()=8">
																	<td align="left" valign="top">
																		<a href="{../domainName}bonus{@id}.html" style="text-decoration:none;font-size:12px;color:#000;">
																			<img src="{../domainName}{img}" width="128" height="64"/> <br/> <xsl:value-of disable-output-escaping="yes" select="name"/> <span style="color:#d61000;">
<xsl:choose>
	<xsl:when test="percent!=''">&#160;<xsl:value-of disable-output-escaping="yes" select="percent"/></xsl:when>
	<xsl:otherwise><xsl:if test="discount>0"> Скидка <xsl:if test="count(offer)>1">до </xsl:if> <xsl:value-of disable-output-escaping="yes" select="discount"/>% </xsl:if></xsl:otherwise>
</xsl:choose>
																			</span>
																		</a>
																	</td>
																	<xsl:if test="position()!=8"><td> </td></xsl:if>
																</xsl:if>
															</xsl:for-each>
															</tr>
															<tr>
																<td colspan="7">
																	<div style="border-bottom:1px solid #CCC;margin:10px 0;"></div>
																</td>
															</tr>
															<tr>
															<xsl:for-each select="item">
																<xsl:if test="position()=9 or position()=10 or position()=11 or position()=12">
																	<td align="left" valign="top">
																		<a href="{../domainName}bonus{@id}.html" style="text-decoration:none;font-size:12px;color:#000;">
																			<img src="{../domainName}{img}" width="128" height="64"/> <br/> <xsl:value-of disable-output-escaping="yes" select="name"/> <span style="color:#d61000;">
<xsl:choose>
	<xsl:when test="percent!=''">&#160;<xsl:value-of disable-output-escaping="yes" select="percent"/></xsl:when>
	<xsl:otherwise><xsl:if test="discount>0"> Скидка <xsl:if test="count(offer)>1">до </xsl:if> <xsl:value-of disable-output-escaping="yes" select="discount"/>% </xsl:if></xsl:otherwise>
</xsl:choose>
																			</span>
																		</a>
																	</td>
																	<xsl:if test="position()!=12"><td> </td></xsl:if>
																</xsl:if>
															</xsl:for-each>
															</tr>
															<tr>
																<td colspan="7">
																	<div style="border-bottom:1px solid #CCC;margin:10px 0;"></div>
																</td>
															</tr>
															<tr>
															<xsl:for-each select="item">
																<xsl:if test="position()=13 or position()=14 or position()=15 or position()=16">
																	<td align="left" valign="top">
																		<a href="{../domainName}bonus{@id}.html" style="text-decoration:none;font-size:12px;color:#000;">
																			<img src="{../domainName}{img}" width="128" height="64"/> <br/> <xsl:value-of disable-output-escaping="yes" select="name"/> <span style="color:#d61000;">
<xsl:choose>
	<xsl:when test="percent!=''">&#160;<xsl:value-of disable-output-escaping="yes" select="percent"/></xsl:when>
	<xsl:otherwise><xsl:if test="discount>0"> Скидка <xsl:if test="count(offer)>1">до </xsl:if> <xsl:value-of disable-output-escaping="yes" select="discount"/>% </xsl:if></xsl:otherwise>
</xsl:choose>
																			</span>
																		</a>
																	</td>
																	<xsl:if test="position()!=16"><td> </td></xsl:if>
																</xsl:if>
															</xsl:for-each>
															</tr>
														</table>
														<h4 style="margin:10px 0 0;">Еще акции:</h4>
														<ul style="margin:5px 0 10px;line-height:130%;">
															<xsl:for-each select="item">
																<xsl:if test="position()>17">
																	<li><a href="{../domainName}bonus{@id}.html" style="color:#000;font-size:12px;text-decoration:none;line-height:100%;"><xsl:value-of disable-output-escaping="yes" select="name"/></a></li>
																</xsl:if>
															</xsl:for-each>
														</ul>
														
														<a style="display:block;width:70px;padding:14px 3px 14px 48px;color:#333333;text-decoration:none;font-size:14px;line-height:100%;text-align:left;background:url({domainName}image/nav-prev.png) no-repeat;" href="{domainName}">К списку акций</a>
													</td>
													<td> </td>
												</tr>
											</table>
											<table width="600" cellspacing="0" cellpadding="0" border="0" background="{domainName}image/mail/mail_corners_bottom.png">
												<tr>
													<td height="26"> </td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td height="30"> </td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
</table>
</xsl:if>
	</xsl:template> 
</xsl:stylesheet>