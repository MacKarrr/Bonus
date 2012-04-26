<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items"> <xsl:if test="count(htmlcode)>0"> <xsl:for-each select="htmlcode"> <div class="icounter"> <xsl:value-of disable-output-escaping="yes" select="."/> </div> </xsl:for-each> </xsl:if> </xsl:template>
</xsl:stylesheet>