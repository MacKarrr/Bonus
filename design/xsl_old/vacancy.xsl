<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items">
<xsl:if test="count(item)>0">
<script type="text/javascript" src="/scripts/va.accord.js"></script>
<div class="accord">
<p class="col-side"> Напишите нам на <a href="{domainImgName}backlink.html" class="email">info@bonusmouse.ru</a> </p>
<span class="clear"></span>
	<xsl:for-each select="item">
		<span class="h2"> <xsl:if test="count(../item)=1"> <xsl:attribute name="class">h2 active</xsl:attribute> </xsl:if> <xsl:value-of disable-output-escaping="yes" select="name"/></span>
		<span class="dsc"> <xsl:value-of disable-output-escaping="yes" select="descr"/> </span>
	</xsl:for-each>
</div>
</xsl:if></xsl:template>
</xsl:stylesheet>