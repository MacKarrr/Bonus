<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="html" encoding="windows-1251" indent="no"/>
<xsl:template match="items">
<xsl:if test="count(item)>0">
<script type="text/javascript" src="/scripts/va.accord.js"></script>
<div class="accord">
	<xsl:for-each select="item">
		<span class="h2"><xsl:value-of disable-output-escaping="yes" select="name"/><span></span></span>
		<span class="dsc"> <xsl:value-of disable-output-escaping="yes" select="descr"/> </span>
	</xsl:for-each>
</div>
</xsl:if>
<xsl:if test="count(item)=0"><div class="alert">На текущий момент нет aктуальной документации.</div></xsl:if> </xsl:template>
</xsl:stylesheet>