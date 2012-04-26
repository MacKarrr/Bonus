<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:import href="design/xsl/bannitem.xsl"/>
<xsl:output method="html" encoding="windows-1251" indent="no"/>
  <xsl:template match="items">
  <xsl:if test="count(bann[@type='ban1'])>0">
<li class="bann" id="banner01"> <xsl:for-each select="bann[@type='ban1']"> <xsl:call-template name="bannitem"/> </xsl:for-each> </li> </xsl:if>
</xsl:template>
</xsl:stylesheet>
