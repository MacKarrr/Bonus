<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items"> <xsl:if test="count(item)>0"> 
		<script type="text/javascript" src="/scripts/timer.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("div.bonuscont").each(function(){
					var month = <xsl:value-of select="item/sysdate/month"/>-1;
					var year = <xsl:value-of select="item/sysdate/year"/>-1;
					$(this).find('.time').countdown(new Date(2012, 02, <xsl:value-of select="item/sysdate/day"/>, 23, 59, 59), {prefix:'', finish: ' '});
				})
			});
		</script>
		<div class="bonusc"> <xsl:for-each select="item">
			<xsl:choose>
				<xsl:when test="../auth!=0 or ../fauth!=0">
					<a href="{../domainName}bonus{@id}.html" class="bonus">
						<xsl:call-template name="list"/>
					</a>
				</xsl:when>
				<xsl:otherwise>
					<span class="a bonus" name="{../domainName}bonus{@id}.html" onClick="fShowAuth()">
						<xsl:call-template name="list"/>
					</span>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:for-each><div class="clear"></div> </div> <div class="clear"></div> </xsl:if> 
		<xsl:if test="count(item)=0">
		<div class="text relative">
				<div class="zagolovok">
					<div class="bgopacity"></div>
					<a href="{domainName}/partners.html" class="citylink"><span>С</span>коро и в <span>вашем</span> городе!</a>
				</div>
				<div class="grid5" id="citypics">
					<div class="grid">
						<img src="/i_bonus/m_51.jpg"/>
						<img src="/i_bonus/m_128.jpg"/>
						<img src="/i_bonus/m_120.jpg"/>
					</div>
					<div class="grid">
						<img src="/i_bonus/m_72.jpg"/>
						<img src="/i_bonus/m_133.jpg"/>
						<img src="/i_bonus/m_127.jpg"/>
					</div>
					<div class="grid">
						<img src="/i_bonus/m_55.jpg"/>
						<img src="/i_bonus/m_142.jpg"/>
						<img src="/i_bonus/m_52.jpg"/>
					</div>
					<div class="grid">
						<img src="/i_bonus/m_347.jpg"/>
						<img src="/i_bonus/m_286.jpg"/>
						<img src="/i_bonus/m_343.jpg"/>
					</div>
					<div class="clear"></div>
						<div class="box">
							<div class="grid">
								<img src="/i_bonus/m_159.jpg"/>
								<img src="/i_bonus/m_150.jpg"/>
								<img src="/i_bonus/m_156.jpg"/>
							</div>
							<div class="grid">
								<img src="/i_bonus/m_168.jpg"/>
								<img src="/i_bonus/m_101.jpg"/>
								<img src="/i_bonus/m_138.jpg"/>
							</div>
						</div>
						<div class="grid big">
							<img src="/i_bonus/b_117.jpg"/>
							<img src="/i_bonus/b_134.jpg"/>
							<img src="/i_bonus/b_139.jpg"/>
						</div>
						<div class="box">
							<div class="grid">
								<img src="/i_bonus/m_124.jpg"/>
								<img src="/i_bonus/m_48.jpg"/>
								<img src="/i_bonus/m_89.jpg"/>
							</div>
							<div class="grid">
								<img src="/i_bonus/m_114.jpg"/>
								<img src="/i_bonus/m_24.jpg"/>
								<img src="/i_bonus/m_131.jpg"/>
							</div>
						</div>
					<div class="clear"></div>
						<div class="grid">
							<img src="/i_bonus/m_104.jpg"/>
							<img src="/i_bonus/m_30.jpg"/>
							<img src="/i_bonus/m_123.jpg"/>
						</div>
						<div class="grid">
							<img src="/i_bonus/m_40.jpg"/>
							<img src="/i_bonus/m_24.jpg"/>
							<img src="/i_bonus/m_126.png"/>
						</div>
						<div class="grid">
							<img src="/i_bonus/m_24.jpg"/>
							<img src="/i_bonus/m_16.jpg"/>
							<img src="/i_bonus/m_107.jpg"/>
						</div>
						<div class="grid">
							<img src="/i_bonus/m_55.jpg"/>
							<img src="/i_bonus/m_144.jpg"/>
							<img src="/i_bonus/m_136.jpg"/>
						</div>
					<div class="clear"></div>
				</div>
		</div>
		</xsl:if>
	</xsl:template>
	<xsl:template name="list">
		<xsl:if test="img!=''"> <img src="{../domainName}{img}" alt="{name}"/> </xsl:if>
		<span class="title"><xsl:value-of disable-output-escaping="yes" select="name"/></span>
		<span class="info">
			<span class="price">
				<span class="rub"><xsl:if test="count(offer)>1">от </xsl:if> <strong> <xsl:value-of disable-output-escaping="yes" select="min"/>'</strong> </span>
				<span class="copper">
					<sup><xsl:value-of disable-output-escaping="yes" select="min/@copeck"/></sup>
					<sub>руб.</sub>
				</span>
			<span class="clear"></span>
			</span>
			<span class="discount">
				<xsl:choose>
					<xsl:when test="percent!=''">
						<span class="percent"> <xsl:value-of disable-output-escaping="yes" select="percent"/> </span>
					</xsl:when>
					<xsl:otherwise>
						<xsl:if test="discount>0">
							<strong> Скидка <xsl:if test="count(offer)>1">до </xsl:if> <b><xsl:value-of disable-output-escaping="yes" select="discount"/>%</b> </strong>
							<span>Цена без скидки <xsl:if test="count(offer)>1">до </xsl:if> <b><xsl:value-of disable-output-escaping="yes" select="max"/> руб.</b></span>
						</xsl:if>
					</xsl:otherwise>
				</xsl:choose>
			</span>
		</span>
	</xsl:template>
</xsl:stylesheet>