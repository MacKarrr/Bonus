<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items"> 
		<xsl:for-each select="item"> <a href="{href}" class="mny"> <span class="h2"><xsl:value-of disable-output-escaping="yes" select="name"/></span> <xsl:value-of disable-output-escaping="yes" select="comment"/> </a> </xsl:for-each>
	</xsl:template>
</xsl:stylesheet>