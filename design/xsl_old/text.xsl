<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items"> 
		<xsl:value-of disable-output-escaping="yes" select="text"/> 
		<xsl:if test="count(item)>0"> <xsl:call-template name="it"/> </xsl:if> 
	</xsl:template>
	<xsl:template name="it">
    <ul id="ul-{@id}" class="snone"> <xsl:if test="count(../item)>0"><xsl:attribute name="class">hide</xsl:attribute></xsl:if> <xsl:for-each select="item"><li><xsl:if test="count(item)>0"><span id="{@id}" onClick="ulShow('{@id}')" class="pointer">+</span></xsl:if><xsl:if test="count(item)=0"><span>&#8211;</span></xsl:if><a href="{href}"><xsl:if test="@blank=1"><xsl:attribute name="target">_blank</xsl:attribute></xsl:if><xsl:value-of disable-output-escaping="yes" select="name"/></a><xsl:if test="count(item)>0"><xsl:call-template name="it"/></xsl:if></li></xsl:for-each></ul>
  </xsl:template>
</xsl:stylesheet>
