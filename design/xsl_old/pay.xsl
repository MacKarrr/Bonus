<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:import href="design/xsl/messages.xsl"/>
	<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items">
			<div class="payment">
				<a class="col-side" href="{domainName}bonus{item/@ownerId}.html">Вернуться к описанию акции</a>
				<div id="er2" style="display:none" class="er2"></div>
				<xsl:choose> 
					<xsl:when test="er2!=''"> <xsl:apply-templates select="er2"/> </xsl:when>
					<xsl:otherwise>
					<p>Акция действует до <xsl:value-of disable-output-escaping="yes" select="item/date"/></p>
					<table class="bgwhite" width="100%">
						<tbody>
							<tr> <th>Наименование</th>
							<!-- <xsl:if test="item/@ownerId!=57"><th>Количество</th></xsl:if> -->
							<th>Цена, руб.</th><!-- <th>Сумма, руб.</th> --></tr>
							<tr>
								<td>
								<xsl:if test="count(item)"><img align="left" src="{item/img}" alt="{item/name}"/> <span class="h4"><xsl:value-of disable-output-escaping="yes" select="item/name"/>&#160;<xsl:value-of disable-output-escaping="yes" select="item/min"/> рублей<xsl:if test="item/max > item/min"> вместо <xsl:value-of disable-output-escaping="yes" select="item/max"/></xsl:if>.
								<xsl:choose>
									<xsl:when test="percent!=''">
										<xsl:value-of disable-output-escaping="yes" select="percent"/>
									</xsl:when>
									<xsl:otherwise>
										<xsl:if test="discount>0"> Скидка <xsl:value-of disable-output-escaping="yes" select="item/discount"/>%</xsl:if>
									</xsl:otherwise>
								</xsl:choose>
								</span> </xsl:if>
								</td>
								<!-- <xsl:if test="item/@ownerId!=57"><td align="center" width="91">
									<img class="qcount" src="/im/minus.gif" id="quant" onClick="fCountQuant(-1,{item/@id})"/>
									<input type="text" value="{item/@cntoffer}" id="quant" class="quant" onClick="this.select()" onKeyUp="fCountQuant(0,{item/@id})"/>
									<img class="qcount" src="/im/plus.gif" id="quant" onClick="fCountQuant(1,{item/@id})"/>
								</td></xsl:if> -->
								<td>
								<input type="hide" value="{item/@cntoffer}" id="quant" class="quant hide" onClick="this.select()" onKeyUp="fCountQuant(0,{item/@id})"/>
								<span id="quantPrice" class="price"><xsl:value-of disable-output-escaping="yes" select="item/min"/></span>
								<span id="quantCost" class="hide pcount"><xsl:value-of disable-output-escaping="yes" select="item/cost"/></span>
								</td>
								<!-- <td></td> -->
							</tr>
						</tbody>
					</table>
					<br/>
					<xsl:if test="text!=''">
					<span class="h2 right a_inner" onClick="$('#WhatAfter').toggle();">Что произойдет после оплаты?</span>
					<div class="pay block" id="WhatAfter">
						<xsl:for-each select="text">
							<xsl:value-of disable-output-escaping="yes" select="."/>
						</xsl:for-each>
					</div>
					</xsl:if>
					<span class="h2">Выберите метод оплаты</span>
					<ul class="methods"> <xsl:value-of disable-output-escaping="yes" select="pay"/> </ul>
					</xsl:otherwise>
				</xsl:choose>
			</div>
	</xsl:template>
</xsl:stylesheet>
