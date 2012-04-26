<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items"> 
		<xsl:value-of disable-output-escaping="yes" select="text"/> 
		<xsl:if test="count(item)>0"> <xsl:call-template name="it"/> </xsl:if> 
		<xsl:if test="count(item)=0 and text=''"> <div class="alert">По данному разделу информация находится на стадии наполнения</div> </xsl:if> 
	</xsl:template>
	<xsl:template name="it"> <ul> <xsl:for-each select="item"><li><a href="{href}"><xsl:if test="@blank=1"><xsl:attribute name="target">_blank</xsl:attribute></xsl:if><xsl:value-of disable-output-escaping="yes" select="name"/></a><xsl:if test="count(item)>0"><xsl:call-template name="it"/></xsl:if></li></xsl:for-each></ul> </xsl:template>
</xsl:stylesheet>
