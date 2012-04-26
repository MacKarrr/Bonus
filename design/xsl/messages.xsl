<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="txt"> <xsl:value-of disable-output-escaping="yes" select="."/> </xsl:template>
	<xsl:template match="ok"> <div class="ok_er"><div class="ok"><xsl:value-of disable-output-escaping="yes" select="."/></div></div> </xsl:template>
	<xsl:template match="er"> <div class="ok_er"><p class="error"><xsl:value-of disable-output-escaping="yes" select="."/></p></div> </xsl:template>
	<xsl:template match="ok2"> <div class="ok_er"><div class="ok2"><xsl:value-of disable-output-escaping="yes" select="."/></div></div> </xsl:template>
	<xsl:template match="er2"> <div class="ok_er"><div class="er2"><xsl:value-of disable-output-escaping="yes" select="."/></div></div> </xsl:template>
	<xsl:template match="alert"> <div class="ok_er"><div class="alert"><xsl:value-of disable-output-escaping="yes" select="."/></div></div> </xsl:template>
</xsl:stylesheet>
 