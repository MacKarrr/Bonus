<?xml version="1.0" encoding="windows-1251" ?> <xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">	<xsl:output method="html" encoding="windows-1251" indent="no"/>	<xsl:template match="pagenum"> 
 <div class="pagenum"> <xsl:if test="@cntPage>0"> <a href="{@hfirst}"> <img src="/im/pn-{@ps}frst.gif" alt="�� ������"/> </a> <a href="{@hprev}"> <img src="/im/pn-{@ps}prev.gif" alt="�� ����������"/> </a> <xsl:for-each select="link"> <xsl:if test="@href='select_page'"> <span> <xsl:value-of select="."/> </span> </xsl:if> <xsl:if test="@href!='select_page'"> <a href="{@href}"> <xsl:value-of select="."/> </a> </xsl:if> </xsl:for-each> <a href="{@hnext}"> <img src="/im/pn-{@ns}next.gif"/> </a> <a href="{@hend}"> <img src="/im/pn-{@ns}end.gif"/> </a> </xsl:if> <xsl:if test="@cntPage=0"> <span class="a"> <img src="/im/pn-sfrst.gif" alt="�� ������"/> </span> <span class="a"> <img src="/im/pn-sprev.gif" alt="�� ����������"/> </span> <span>1</span> <span class="a"> <img src="/im/pn-snext.gif" alt="�� ������"/> </span> <span class="a"> <img src="/im/pn-send.gif" alt="�� ����������"/> </span> </xsl:if> <form id="messOnPage" method="post"> <select id="selOnPage" name="messOnPage" onChange="$('#selOnPage').val(this.value);$('#messOnPage').submit();"> <option value="12"> <xsl:if test="@messOnPage=12"> <xsl:attribute name="selected"> true </xsl:attribute> </xsl:if> 12 ������� �� ��������</option> <option value="20"> <xsl:if test="@messOnPage=20"> <xsl:attribute name="selected"> true </xsl:attribute> </xsl:if> 20 ������� �� ��������</option> <option value="60"> <xsl:if test="@messOnPage=60"> <xsl:attribute name="selected"> true </xsl:attribute> </xsl:if> 60 ������� �� ��������</option> <option value="100"> <xsl:if test="@messOnPage=100"> <xsl:attribute name="selected"> true </xsl:attribute> </xsl:if> 100 ������� �� ��������</option> <option value="200"> <xsl:if test="@messOnPage=200"> <xsl:attribute name="selected"> true </xsl:attribute> </xsl:if> 200 ������� �� ��������</option> </select> </form> </div> </xsl:template> </xsl:stylesheet>