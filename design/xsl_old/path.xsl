<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items"> <div class="path"> <xsl:if test="count(item)>1"> <xsl:for-each select="item[position()!=last()]"> <a href="{../domainName}{href}"><xsl:value-of disable-output-escaping="yes" select="name"/></a> / </xsl:for-each> </xsl:if> <xsl:if test="count(item)=1">&#160;</xsl:if> <h1><xsl:value-of disable-output-escaping="yes" select="item[position()=last()]/name"/></h1> </div> </xsl:template>
</xsl:stylesheet>