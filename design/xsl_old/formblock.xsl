<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:import href="design/xsl/messages.xsl"/>
<xsl:import href="design/xsl/form.xsl"/>
<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items">
		<xsl:value-of disable-output-escaping="yes" select="text"/>
		<a name="form"></a>
		<xsl:apply-templates select="ok"/>
		<xsl:apply-templates select="er"/>
		<xsl:apply-templates select="ok2"/>
		<xsl:apply-templates select="er2"/>
		<xsl:apply-templates select="alert"/>
		<xsl:apply-templates select="form"/>
	</xsl:template>
</xsl:stylesheet>
