<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="form">
	<script type="text/javascript"> jQuery(function() {$('span.err').each(function(){var id = $(this).attr('id');$(this).find('.input input').focus(function(){$('#'+id).find('.comment').html('');});$(this).find('.textarea textarea').focus(function(){$('#'+id).find('.comment').html('');});}); }); </script>	
	<form name="{@name}" action="{action}" method="post" enctype="multipart/form-data" class="form"> <div class="req"><xsl:if test="count(field[@error=1])>0"><xsl:attribute name="class">reqer</xsl:attribute></xsl:if>���� ������������ ��� <span class="error">*</span> ����������� ��� ����������</div> <div class="block"> <div> <div> <div> <div> 
	<xsl:for-each select="field"> <xsl:choose> 
	<xsl:when test="@type='submit'"> <input type="{@type}" name="{@name}" value="{value}" class="bttn right"/> <div class="clear"></div> </xsl:when>
	<xsl:when test="@type='info'"> <xsl:if test="value!=''"> <div class="h4"><xsl:value-of disable-output-escaping="yes" select="value"/></div><br/> </xsl:if> </xsl:when>
	<xsl:when test="@type='textarea'"> <span class="label" id="tr{@name}"><xsl:if test="@error=1"><xsl:attribute name="class">label err</xsl:attribute></xsl:if> <span class="caption"><xsl:value-of disable-output-escaping="yes" select="caption"/><xsl:if test="@claim='1'"><span class="error">*</span></xsl:if>:</span> <span class="textarea"><textarea id="{@name}" name="{@name}"><xsl:value-of disable-output-escaping="yes" select="value"/></textarea></span> <div class="clear"></div> <div class="comment"><xsl:value-of disable-output-escaping="yes" select="comment"/></div> </span> </xsl:when> <xsl:when test="@type='hidden'"> <input type="hidden" name="{@name}" value="{value}"/> </xsl:when>
	<xsl:when test="@type='checkbox'"> <span class="label" id="tr{@name}"> <xsl:if test="@error=1"><xsl:attribute name="class">label err</xsl:attribute></xsl:if> <span class="caption"> <xsl:value-of disable-output-escaping="yes" select="caption"/><xsl:if test="@claim='1'"><span style="color:#F00">*</span></xsl:if>:</span> <table> <xsl:for-each select='item'> <tr> <td class="rd"> <input type="{../@type}" name="{../@name}[]" value="{@id}"><xsl:if test="@sel=1"><xsl:attribute name="checked">true</xsl:attribute></xsl:if></input> </td> <td><xsl:value-of disable-output-escaping="yes" select="name"/></td> </tr> </xsl:for-each> </table> <div class="clear"></div> <div class="comment"><xsl:value-of disable-output-escaping="yes" select="comment"/></div> </span> </xsl:when>
	<xsl:when test="@type='radio'"> <span class="label" id="tr{@name}"> <xsl:if test="@error=1"><xsl:attribute name="class">label err</xsl:attribute></xsl:if> <span class="caption"> <xsl:value-of disable-output-escaping="yes" select="caption"/><xsl:if test="@claim='1'"><span style="color:#F00">*</span></xsl:if>:</span> <table> <xsl:for-each select='item'> <tr> <td class="rd"><input type="{../@type}" name="{../@name}" value="{@id}"> <xsl:if test="@sel=1"><xsl:attribute name="checked">true</xsl:attribute></xsl:if></input> </td> <td><xsl:value-of disable-output-escaping="yes" select="name"/> <xsl:if test="@id=3 and ../@delivery=1"> <hr/> ��� ������������� ������� ������ �������� �� �������� <br/> <span class="input"> <input type="text" name="transport" value="{../@transport}"/> </span> </xsl:if> </td> </tr> </xsl:for-each> </table> <div class="clear"></div> <div class="comment"><xsl:value-of disable-output-escaping="yes" select="comment"/></div> </span> </xsl:when>
	<xsl:when test="@type='select'"> <span class="label" id="tr{@name}"> <xsl:if test="@error=1"><xsl:attribute name="class">label err</xsl:attribute></xsl:if> <span class="caption"> <xsl:value-of disable-output-escaping="yes" select="caption"/><xsl:if test="@claim='1'"><span style="color:#F00">*</span></xsl:if>: </span> <span class="input"> <select id="{@name}" name="{@name}"> <xsl:for-each select='item'> <option value="{@id}"><xsl:if test="@sel=1"><xsl:attribute name="selected">true</xsl:attribute></xsl:if><xsl:value-of disable-output-escaping="yes" select="name"/></option> </xsl:for-each> </select> </span> <div class="clear"></div> <div class="comment"><xsl:value-of disable-output-escaping="yes" select="comment"/></div> </span> </xsl:when> 	
	<xsl:when test="@type='date'"> <span class="label" id="tr{@name}"> <xsl:if test="@error=1"><xsl:attribute name="class">label err</xsl:attribute></xsl:if> <span class="caption"> <xsl:value-of disable-output-escaping="yes" select="caption"/><xsl:if test="@claim='1'"><span style="color:#F00">*</span></xsl:if>: </span> <span class="input"> <select id="day" name="day"> <xsl:for-each select="item[@id='day']/item"> <option value="{@id}"><xsl:if test="@sel=1"><xsl:attribute name="selected">true</xsl:attribute></xsl:if><xsl:value-of disable-output-escaping="yes" select="name"/></option> </xsl:for-each> </select> <select id="month" name="month"> <xsl:for-each select="item[@id='month']/item"> <option value="{@id}"><xsl:if test="@sel=1"><xsl:attribute name="selected">true</xsl:attribute></xsl:if><xsl:value-of disable-output-escaping="yes" select="name"/></option> </xsl:for-each> </select> <select id="year" name="year"> <xsl:for-each select="item[@id='year']/item"> <option value="{@id}"><xsl:if test="@sel=1"><xsl:attribute name="selected">true</xsl:attribute></xsl:if><xsl:value-of disable-output-escaping="yes" select="name"/></option> </xsl:for-each> </select> </span> <div class="clear"></div> <div class="comment"><xsl:value-of disable-output-escaping="yes" select="comment"/></div> </span> </xsl:when>	
	<xsl:when test="@type='city'"> <span class="label" id="tr{@name}"> <xsl:if test="@error=1"><xsl:attribute name="class">label err</xsl:attribute></xsl:if> <span class="caption"> <xsl:value-of disable-output-escaping="yes" select="caption"/><xsl:if test="@claim='1'"><span style="color:#F00">*</span></xsl:if>: </span> <xsl:value-of disable-output-escaping="yes" select="value"/> <div class="clear"></div> <div class="comment"><xsl:value-of disable-output-escaping="yes" select="comment"/></div> </span> </xsl:when> 	
	<xsl:when test="@type='secret'"> <span class="label" id="tr{@name}"> <xsl:if test="@error=1"><xsl:attribute name="class">label err</xsl:attribute></xsl:if><span class="caption"> <xsl:value-of disable-output-escaping="yes" select="caption"/><xsl:if test="@claim='1'"><span class="error">*</span></xsl:if>:</span> <span class="captha"><img src="{@src}" height="25" align="left"/>&#160;</span> <span class="input secret"> <input type="text" name="{@name}" maxlength="5"/> </span> <div class="clear"></div> <div class="comment"><xsl:value-of disable-output-escaping="yes" select="comment"/></div> </span> </xsl:when>
	<xsl:when test="@type='password' and @remind=1"> <span class="label" id="tr{@name}"><xsl:if test="@error=1"><xsl:attribute name="class">label err</xsl:attribute></xsl:if> <span class="caption"><xsl:value-of disable-output-escaping="yes" select="caption"/><xsl:if test="@claim='1'"><span class="error">*</span></xsl:if>:</span> <span class="pass_remind" onClick="fUserRestore(0)">���������</span> <span class="input secret"> <input type="password" name="{@name}" size="15"/> </span> <div class="clear"></div> <div id="authCheckMess" class="comment"><xsl:value-of disable-output-escaping="yes" select="comment"/></div> </span> </xsl:when>
	<xsl:otherwise> <span class="label" id="tr{@name}"><xsl:if test="@error=1"><xsl:attribute name="class">label err</xsl:attribute></xsl:if><span class="caption"><xsl:value-of disable-output-escaping="yes" select="caption"/><xsl:if test="@claim='1'"><span class="error">*</span></xsl:if>:</span> <span class="input"> <input id="{@name}" type="{@type}" name="{@name}" value="{value}"> <xsl:if test="@onkeyup!=''"> <xsl:attribute name="autocomplete">off</xsl:attribute> <xsl:attribute name="onkeyup"><xsl:value-of select="@onkeyup"/></xsl:attribute> </xsl:if> </input> </span> <div class="clear"></div> <div class="comment"><xsl:value-of disable-output-escaping="yes" select="comment"/></div> </span> </xsl:otherwise> </xsl:choose> </xsl:for-each> 
	</div></div></div></div>	
	</div> </form> </xsl:template> </xsl:stylesheet>