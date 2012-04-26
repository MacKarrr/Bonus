<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items">	
	<div class="mn2">
		<span>О компании</span> 
		<ul> <xsl:for-each select="item[@onmenu2=1]"> <li> <a href="{href}"> <xsl:if test="@blank=1"><xsl:attribute name="target">_blank</xsl:attribute></xsl:if> <xsl:value-of disable-output-escaping="yes" select="name"/> </a> </li> </xsl:for-each> </ul>
	</div>
	<div class="mn2">
		<span>Узнать больше</span> 
		<ul> <xsl:for-each select="item[@onmenu3=1]"> <li> <a href="{href}"> <xsl:if test="@blank=1"><xsl:attribute name="target">_blank</xsl:attribute></xsl:if> <xsl:value-of disable-output-escaping="yes" select="name"/> </a> </li> </xsl:for-each> </ul>
	</div>
	<div class="mn2">
		<span>Дополнительно</span> 
		<ul> <xsl:for-each select="item[@onmenu4=1]"> <li> <a href="{href}"> <xsl:if test="@blank=1"><xsl:attribute name="target">_blank</xsl:attribute></xsl:if> <xsl:value-of disable-output-escaping="yes" select="name"/> </a> </li> </xsl:for-each> </ul>
	</div>	
	 </xsl:template>
</xsl:stylesheet>