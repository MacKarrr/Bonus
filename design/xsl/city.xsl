<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:import href="design/xsl/cityselect.xsl"/>
<xsl:output method="html" encoding="windows-1251" indent="no"/> <xsl:template match="items"> <xsl:if test="count(item)>0"> <xsl:if test="type='form'"> <input type="hidden" name="cityId" id="cityId" value="{id}"/> </xsl:if> <span class="city" id="city{type}Name" title="Выберите город" onClick="$('#city{type}list').toggle();return false;"><div class="top_down"></div><xsl:value-of disable-output-escaping="yes" select="name"/></span> <xsl:call-template name="cityselect"/> </xsl:if> <xsl:if test="count(item)=0">&#160;</xsl:if> </xsl:template>
</xsl:stylesheet>