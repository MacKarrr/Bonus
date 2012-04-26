<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:import href="design/xsl/pagenum.xsl"/>
	<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items"> <xsl:if test="count(item)=0 and mess!=''"><div class="alert"><xsl:value-of disable-output-escaping="yes" select="mess"/></div></xsl:if> <xsl:if test="count(item)>0"> <div class="mt7">Ваш запрос: "<strong><xsl:value-of disable-output-escaping="yes" select="query"/></strong>"<br/>Раздел поиска: <strong><xsl:value-of select="srchtype"/></strong><br/> По Вашему запросу <xsl:value-of disable-output-escaping="yes" select="count"/> </div> <div class="hr"></div> <xsl:apply-templates select="pagenum"/> <ol start="{beginrows+1}" class="s-ol"><xsl:apply-templates select="item"/></ol> <br/> <xsl:apply-templates select="pagenum"/> </xsl:if> </xsl:template>
	<xsl:template match="item"> <li><h3><a href="{href}"><xsl:value-of disable-output-escaping="yes" select="name"/></a></h3><div class="s-result"><xsl:value-of disable-output-escaping="yes" select="description" /></div><div class="s-result">Дата обновления: <strong><xsl:value-of select="date" /></strong>. Категория: <strong><xsl:value-of select="topic"/></strong></div></li> </xsl:template>
</xsl:stylesheet>
