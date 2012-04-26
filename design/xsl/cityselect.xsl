<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template name="cityselect"> <div class="city_block" id="city{type}list"> 
	<div class="bound"></div> <div class="city_container">
	<div title="Закрыть" onClick="$('#city{type}list').toggle();return false;" class="close"></div>	<xsl:for-each select="item"> <xsl:if test="../type='form'"> <span class="a" onClick="fCityUpForm({@id}, '{name}')"> <xsl:value-of disable-output-escaping="yes" select="name"/></span> </xsl:if> <xsl:if test="../type=''"><a class="left" href="{../domainName}city{@id}/bonus.html"><xsl:value-of disable-output-escaping="yes" select="name"/></a> </xsl:if> </xsl:for-each>
	<div class="clear"></div>
<div class="left"> <span>Страна:</span> <span> <select name="country" onChange="fCityList('{type}region',this.value)"> <xsl:for-each select="country"> <option value="{@id}"><xsl:value-of disable-output-escaping="yes" select="name"/></option> </xsl:for-each> </select> </span> </div>
<div class="left"> <span>Регион/область:</span> <span id="{type}region"> <select name="region" onChange="fCityList('{type}city',this.value)"> <option value="0">- Выберите -</option> <xsl:for-each select="region"> <option value="{@id}"><xsl:value-of disable-output-escaping="yes" select="name"/></option> </xsl:for-each> </select> </span> </div> 
<div class="left"> Ваш город: <span id="{type}city"> <select name="city"> <option value="0">---</option> </select> </span> </div>
<div class="clear"></div>
<span class="clear">Если Вы не нашли Ваш город, напиште о нем <a href="{domainImgName}backlink.html">нам</a></span> </div></div>
	</xsl:template>
</xsl:stylesheet>

