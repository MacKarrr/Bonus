<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="html" encoding="windows-1251" indent="no"/>
  <xsl:template match="items"> 
  <div class="bonusarch">
	<div class="bonusmenu"><ul class="accord">
	<script src="/scripts/va.accord.js" type="text/javascript"></script>
		<xsl:for-each select="menu/item"> <li class="h2"> <xsl:if test="position()=1 and @sel=1"> <xsl:attribute name="class">h2 frst active</xsl:attribute> </xsl:if> <xsl:if test="position()=1 and @sel=0"> <xsl:attribute name="class">h2 frst</xsl:attribute> </xsl:if> <xsl:if test="position()!=1 and @sel=1"> <xsl:attribute name="class">h2 active</xsl:attribute> </xsl:if> <xsl:value-of disable-output-escaping="yes" select="name"/> </li> <xsl:if test="item"> <ul class="dsc"> <xsl:for-each select="item"> <li> <xsl:if test="@sel=1"> <xsl:attribute name="class">active</xsl:attribute> </xsl:if> <a href="{href}"> <xsl:value-of disable-output-escaping="yes" select="name"/> </a> </li> </xsl:for-each> </ul> </xsl:if>
		</xsl:for-each>
	</ul></div>	
	
	<div class="bonusmin">
	<span class="h1">������� �����</span>
	<span class="h4">���������� ����������� ����� �� <xsl:value-of disable-output-escaping="yes" select="path"/> </span>
	<xsl:for-each select="item">
		<a href="{../domainName}bonus{@id}.html" class="bonusbox"> <span class="name"><xsl:value-of disable-output-escaping="yes" select="name"/>
		<xsl:if test="discount>0"> &#160;<strong>������ <xsl:if test="count(offer)>1">�� </xsl:if> <xsl:value-of disable-output-escaping="yes" select="discount"/>%</strong> </xsl:if> </span>
			<div class="date"><xsl:value-of disable-output-escaping="yes" select="date"/></div>
			<div class="bonuscont">
				<xsl:if test="paidUsers!=0"><div class="peop�">������ �������:<span><xsl:value-of disable-output-escaping="yes" select="paidUsers"/></span></div></xsl:if>
				<div class="info">
					<span class="dott">���� <xsl:if test="count(offer)>1">�� </xsl:if> <strong> <xsl:value-of disable-output-escaping="yes" select="min"/> ���.</strong> </span>
					<xsl:if test="discount>0"> <span>������ <xsl:if test="count(offer)>1">�� </xsl:if> <strong><xsl:value-of disable-output-escaping="yes" select="discount"/>%</strong></span> </xsl:if>
					<span href="" class="bttn">���������</span>
				</div>
				<xsl:if test="img!=''"> <img src="{../domainName}{imgm}" alt="{name}"/> </xsl:if>
				<xsl:if test="img=''"> <img src="{domainName}im/nofoto200.jpg" alt="{name}"/> </xsl:if>
			</div>
		</a>
	</xsl:for-each>
	</div>
	<div class="clear"></div>
	</div>
	<!-- <xsl:if test="count(item)=0"> <div class="alert">�� ������� ������� ���������� ��������� �� ������ ����������</div> </xsl:if> -->
	</xsl:template>
</xsl:stylesheet>