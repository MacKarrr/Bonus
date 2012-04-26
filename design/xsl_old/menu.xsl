<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items"> <ul> <xsl:for-each select="item[@onmenu1=1]"> <li> <xsl:if test="position()=last()"><xsl:attribute name="class">last</xsl:attribute></xsl:if> <a href="{href}"> <xsl:if test="@sel='1'"><xsl:attribute name="class">sel</xsl:attribute></xsl:if> <xsl:if test="@blank=1"><xsl:attribute name="target">_blank</xsl:attribute></xsl:if> <xsl:value-of disable-output-escaping="yes" select="name"/> </a>  </li> </xsl:for-each> </ul> </xsl:template>
</xsl:stylesheet>