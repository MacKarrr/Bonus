<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:import href="design/xsl/form.xsl"/>
	<xsl:import href="design/xsl/messages.xsl"/>
	<xsl:output method="html" encoding="windows-1251" indent="no"/>
	<xsl:template match="items"> <script src="/scripts/marks.js" type="text/javascript"></script> 
	<ul class="bonusmark bonush">
		<li class="l" id="log1"> <xsl:if test="type='profile'"> <xsl:attribute name="class">l active</xsl:attribute> </xsl:if> <a href="#">������ ����������</a></li>
		<li id="log2"><xsl:if test="type='bonuses' or coupon/ok!=''"> <xsl:attribute name="class">active</xsl:attribute> </xsl:if> <a href="#"> ������</a></li>
		<li class="log3" id="log3"> <xsl:if test="type='friends'"> <xsl:attribute name="class">active</xsl:attribute> </xsl:if> <a href="#">������</a></li>
	</ul>	
<div class="bonusmarkc log">
	<div id="log1d" class="profile"> <xsl:if test="type='profile'"> <xsl:attribute name="class">profile active</xsl:attribute> </xsl:if>
	<xsl:apply-templates select="addsumm/ok"/> <xsl:apply-templates select="addsumm/er2"/> <div class="clear"></div>
	<div class="formb"> <xsl:choose> <xsl:when test="subtype=''"> <table> <tr> <th>���:</th> <td> <xsl:value-of disable-output-escaping="yes" select="name"/> </td> </tr> <tr> <th>���:</th> <td> <xsl:value-of disable-output-escaping="yes" select="sex"/> </td> </tr> <tr> <th>��. �����:</th> <td><xsl:value-of disable-output-escaping="yes" select="email"/></td> </tr> <tr> <th>�����:</th> <td><xsl:value-of disable-output-escaping="yes" select="cityName"/></td> </tr> <tr> <th>���� ��������:</th> <td><xsl:value-of disable-output-escaping="yes" select="birthday"/></td> </tr> <tr> <th>��������</th> <td> <xsl:value-of disable-output-escaping="yes" select="sending"/> </td> </tr> </table> <p class="profilea"> <a href="{domainImgName}myprofile-edit.html" class="myedit">�������������</a> <a href="{domainImgName}myprofile-pass.html" class="mypass">������� ������</a> <a href="{domainImgName}myprofile-send.html" class="mysubs">��������� ��������</a> </p> </xsl:when> <xsl:otherwise> <xsl:apply-templates select="ok"/> <xsl:apply-templates select="er"/> <xsl:apply-templates select="form"/> <p class="profilea"> <a href="{domainImgName}myprofile.html" class="myedit">���������</a> </p> </xsl:otherwise> </xsl:choose> </div> <div class="profilem"> ��� ������: <div> <strong><xsl:value-of disable-output-escaping="yes" select="balans"/>�</strong> <div> <span><xsl:value-of disable-output-escaping="yes" select="balans/@copeck"/></span> <p>���.</p> </div> </div> <span id="hrefblns" class="a bttn" onClick="$('.payment-inner').slideToggle('fast');">���������</span> 
	<div class="payment-inner">
	<div id="addblns" class="profileb"><span class="left frst">�����:</span><div class="input left"><input id="addSumm" name="addSumm" maxlength="5" type="text"/></div><span class="left"> ���.</span> <span onClick="fAddSumm()" class="left bttn">���������</span>	
	<div class="clear"></div></div>
	<div id="payment-type" style="display:none;"> <span class="clear h3">�������� ����� ������</span> <ul class="methods"> <xsl:value-of disable-output-escaping="yes" select="pay"/> <div class="clear"></div> </ul> </div>
	</div>
	</div> 
	<div class="clear"></div>
	<xsl:if test="count(interest)>0">
		<div class="notbuy">
		<span class="h3">������� �� �������������� ����� ������� </span>
		<xsl:for-each select="interest">
			<div class="block left">
				<a href="{../domainName}bonus{@id}.html" class="h4"> <xsl:if test="img!=''"><img src="{../domainName}{img}" align="left"/></xsl:if> <xsl:value-of disable-output-escaping="yes" select="name"/></a>
				<span class="calendar">�������� <xsl:value-of disable-output-escaping="yes" select="date"/></span>
				<xsl:if test="discount>0"> <span class="price">������ <xsl:if test="count(offer)>1">�� </xsl:if> <xsl:value-of disable-output-escaping="yes" select="discount"/>%</span> </xsl:if>
				<a href="{../domainName}bonus{@id}.html" class="bttn">���������</a>
				<div class="clear"></div>
			</div>
		</xsl:for-each>
		<div class="clear"></div>
		</div>
	</xsl:if>
	</div> 
	<div id="log2d" class="coupon">
		<xsl:if test="type='bonuses' or coupon/ok!=''"> <xsl:attribute name="class">coupon active</xsl:attribute> </xsl:if>
		<xsl:apply-templates select="coupon/ok"/> <xsl:apply-templates select="coupon/er2"/>
		<div class="clear"></div>
		<div class="right fixed">
			<a href="{domainName}mybonuses.html" class="bttn long">��������� �������</a>
			<a href="{domainName}mybonuses.html" class="bttn long">���� ������</a>
			<a href="{domainName}mybonuses.html?fl=nopaid" class="bttn long">�� ����������</a>
			<a href="{domainName}mybonuses.html?fl=ldate" class="bttn long">��������� �����</a>
		</div>		
		<xsl:for-each select="offer">
			
			<div class="block"><xsl:if test="@ldate=1"><xsl:attribute name="class">block ldate</xsl:attribute></xsl:if>
				<div class="right">
					<xsl:choose>
						<xsl:when test="@used!='' or @paid=1"> 
							<a href="{domainName}print{@prId}.html?start=no" target="_blank" class="h4"><xsl:value-of disable-output-escaping="yes" select="name"/> <span class="colored"> �� <xsl:value-of disable-output-escaping="yes" select="min"/> ������<xsl:if test="item/max > item/min"> ������ <xsl:value-of disable-output-escaping="yes" select="max"/></xsl:if>. <xsl:if test="discount>0"> ������ <xsl:value-of disable-output-escaping="yes" select="discount"/>% </xsl:if> </span> </a>
						</xsl:when>
						<xsl:otherwise> <a href="{domainName}bonus{@id}.html" class="h4"><xsl:value-of disable-output-escaping="yes" select="name"/> <span class="colored"> �� <xsl:value-of disable-output-escaping="yes" select="min"/> ������<xsl:if test="item/max > item/min"> ������ <xsl:value-of disable-output-escaping="yes" select="max"/></xsl:if>. <xsl:if test="discount>0"> ������ <xsl:value-of disable-output-escaping="yes" select="discount"/>% </xsl:if> </span></a> </xsl:otherwise>
					</xsl:choose>
					
					<span class="paid"> 
						<xsl:choose>
							<xsl:when test="@used!=''"> <span> ����������� <xsl:value-of disable-output-escaping="yes" select="@used"/> </span> </xsl:when> 
							<xsl:when test="@paid=1"> <span> ������� <xsl:value-of disable-output-escaping="yes" select="paydate"/> </span> </xsl:when> 
							<xsl:otherwise> <strong>�� �������.</strong> <a href="{../domainName}pay{@id}.html" class="bttn">��������</a> </xsl:otherwise>
						</xsl:choose>
					</span>
					<xsl:if test="@used='' and @ownerId!='57'">
						<xsl:choose>
							<xsl:when test="@ldate=1">
								<span class="calendar{@paid}"> <xsl:if test="date">���������� �� <xsl:value-of disable-output-escaping="yes" select="date"/></xsl:if></span>
							</xsl:when>
							<xsl:otherwise>
								<span class="calendar{@paid}"> <xsl:if test="date">��������� �� <xsl:value-of disable-output-escaping="yes" select="date"/></xsl:if></span>
							</xsl:otherwise>
						</xsl:choose>
						<xsl:if test="@paid=1">
							<span id="sendbonus{@prId}" class="mail a" onClick="fSendBonus({@prId},0)">��������� �� �����</span>
							<xsl:choose>
								<xsl:when test="@used!=''"> </xsl:when>
								<xsl:when test="@sendFriend!=''">
									<span class="favour a" onClick="$('#favourfriend').fadeIn('fast');">������� �����</span>
									<div class="present-inner">
										<div class="block give-present min" id="favourfriend">
											<div class="close" onClick="$('#favourfriend').fadeOut('fast');"></div>
											<p>��� ������� ��������� �� �����:</p>
											<strong><xsl:value-of disable-output-escaping="yes" select="@sendFriend"/></strong>
											<div class="hr dashed"></div>
											<p class="min-text">�� ������ �������� ���� ����� ������ ���� ���.</p>
										</div>
									</div>
								</xsl:when>
								<xsl:otherwise>
									<span id="sendToFriend{@prId}" class="mail a" onClick="$('#give-present{@prId}').fadeIn('fast');">�������� �����</span>
									<div class="present-inner">
										<div class="block give-present" id="give-present{@prId}">
											<div class="close" onClick="$('#give-present{@prId}').fadeOut('fast');"></div>
											<p>������� e-mail ������ �����.</p>
											<div class="bttn" onClick="fSendBonus({@prId},1)">��������</div>
											<input type="text" value="" name="toFriends" id="toFriends{@prId}"/>
											<div class="clear"></div>
											<p class="min-text">�� ������ �������� ���� ����� ������ ���� ���.</p>
										</div>
									</div>
								</xsl:otherwise>
							</xsl:choose>
							<span target="_blank" class="print a" onclick="window.open('{domainName}print{@prId}.html', '_blank', ''); return false;">�����������</span>
						</xsl:if>
						<span id="sendFriend"></span>
					</xsl:if>
				</div>
				<div class="ldatediv"></div>
				<a href="{domainName}bonus{@ownerId}.html" class="profileprev">��������� � �����</a>
				<img src="{img}" alt="{name}" align="left"/>
				<div class="clear"></div>
			</div>
		</xsl:for-each>
		<xsl:if test="count(offer)=0"> <div class="alert">�� ������� ������ ������ ����� ������� ����.</div> </xsl:if>
		<div class="clear"></div>
	</div>
	<div id="log3d" class="friends"> <xsl:if test="type='friends'"> <xsl:attribute name="class">friends active</xsl:attribute> </xsl:if>
	<xsl:if test="count(friends)>0">
		<span class="h3">������ ������������ ����</span>
		<table> <tr> <th>E-mail</th> <th>���� �����������</th> </tr>
		<xsl:for-each select="friends">
			<tr>
				<td class="user"><xsl:value-of select="email"/></td>
				<td><xsl:value-of disable-output-escaping="yes" select="date"/></td>
			</tr>
		</xsl:for-each>
		</table> <br/>
	</xsl:if>	
<span class="h3"><b>�������������� �����, ����� �����������!</b><br />
����� ������ ���������� �������� ������, � ������ �� ������...</span>
<p>��������� ������ �� ����� ������� ������� &#171;����� ����&#187;:<br/>
<ul>
    <li>�� ������ �����?</li>
</ul>
����� ������ <b>���������</b> ��������:<br/>
<ul>
    <li>��! ��! ��!</li>
</ul>
������ ������ <b>������</b> ��������:<br/>
<ul>
    <li>�� ��� ��� ��������? ������ �� ������!!!</li>
</ul>
�����������, ������������ ����� ����� ������� ������� &#171;����� ����&#187;:<br/>
<ul>
    <li>��-��-��!!! �� ����������, ��� ��� ��������!!! ����� � ������!</li>
</ul>
������ ������� <b>�����������, ����������� � ������������</b> ��������:<br/>
<ul>
    <li>���???</li>
</ul>
������� � �������� ����� ����� ������� ������� &#171;����� ����&#187;:<br/>
<ul>
    <li>��� �����������: �� �������� �� ��� ����, ��������������� � ��������� ���������� ����� ������, �������������, �������, ���, �������� � �.�. ������������������ �� ����� ����� ���� � ������� ������ � ������ �������� &#171;�������� �����&#187;, � ����� ��������� ������ � Facebook � ���������. ��� ���������� � ���... ����� ���� ��� ���� ������������ ������ ������ ��������� ������� �� ����� &#171;����� ����&#187; �� ������� ��������� �������� ������ �� ��� ������ ����. ���������� ������ �� ������� ��������� �� ����� ������� �� ����� �����, ����� ����, ����� ���� ������ ����� ���������� ����� ������, �� ���� ������ �������� � ����� ������, � ��� ����������!</li>
</ul>
������ <b>�����������</b>:<br/>
<ul>
    <li>������ �� ��������?</li>
</ul>
����� ������ ������������ ����� &#171;����� ����&#187;:<br/>
<ul>
    <li>��� � ��� ��� ���! �� ������� � ������ �������������� ������ ����� ������� �� 5 �� 20%, ������� ��� ����� ���������� ����������� � �������� ����� ������!!!</li>
</ul>
������ <b>�����������</b> �������������:<br/>
<ul>
    <li>������� � ����� �� ���� ����������?</li>
</ul>
����� <b>�������� ����������</b> ����� &#171;����� ����&#187;:<br/>
<ul>
    <li>�����������, �� ���������� 100 ������, ������ �� ������� � ������� ������ �������� �� ������� 1000 ������. ���� �������������� �������� 1000 ������. � ��� ������ ������� ����������: ���� ��� ������ ��������� ��� �� 100 ������ ������, � ��� �������� ����� �� 1000 ������ � �����. ����� ���� �������������� ��� �������� ����� 80 000 ������. � ��� �����!!! ���� � �� ���� ����� ���������, ������� �� ��������, ���� � � ������ ����� ������ ����� ���� �������� ���� ������!!</li>
</ul>
������ <b>���������� �� ���������</b> ������������:<br/>
<ul>
    <li>���� ������???</li>
</ul>
����� <b>���������</b> ����� � <b>��������</b> &#8212; ����� &#171;����� ����&#187;:<br/>
<ul>
    <li>� ����������!!! ������������� ������!!! � ������� ���������� ������, ���� �� �� ��������� ���-�� ������!</li>
</ul>
</p>
		<a name="friends"></a> 
		<div class="frmess"><xsl:apply-templates select="fr/ok"/> <xsl:apply-templates select="fr/er"/> </div>
		<form action="#friends" method="post" class="block invite left">
			<span class="h4">���������� ����� �� ����������� �����</span>
			<div class="input"><input type="text" name="invmail" onClick="this.value=''" value="������� e-mail �����"/></div>
			<div class="textarea" id="invite_text"><textarea name="invtext" onFocus="$('#invite_text').addClass('active')">��������� �� ���� BonusMouse, ������������ ����������� �� ���������� ��������� ������</textarea></div>
			<input class="bttn" type="submit" value="����������"/>
		</form>
		<div class="block invite">
			<span class="h4">������� ������� ���� ������������ ������ ������</span>
			<div class="input"><input type="text" onClick="this.select()" value="{domainName}i{id}"/></div>
			<div class="linkimg">
				<a target="_blank" title="���������� ����� �������" href="http://twitter.com/share?text=%D0%9F%D1%80%D0%B8%D0%B3%D0%BB%D0%B0%D1%88%D0%B0%D1%8E+%D0%B2%D1%81%D0%B5%D1%85+%D0%BD%D0%B0&#38;bonusmouse.ru&#38;url={domainName}i{id}" class="twitter">
					<img src="/im/twitter.png" alt="" width="32"/>
				</a>
				<a target="_blank" title="���������� ����� ���������" href="http://share.yandex.ru/go.xml?service=vkontakte&#38;url={domainName}i{id}&#38;note=%D0%9F%D1%80%D0%B8%D0%B3%D0%BB%D0%B0%D1%88%D0%B0%D1%8E+%D0%B2%D1%81%D0%B5%D1%85+%D0%BD%D0%B0&#38;bonusmouse.ru" class="vk">
					<img src="/im/vk.png" alt=""/>
				</a>
				<a target="_blank" title="���������� ����� Mail.ru" href="http://connect.mail.ru/share?share_url={domainName}i{id}" class="mailru">
					<img src="/im/mailru.png" alt=""/>
				</a>
				<a target="_blank" title="���������� ����� Facebook" href="http://www.facebook.com/sharer.php?u={domainName}i{id}&#38;t=%D0%9F%D1%80%D0%B8%D0%B3%D0%BB%D0%B0%D1%88%D0%B0%D1%8E+%D0%B2%D1%81%D0%B5%D1%85+%D0%BD%D0%B0&#38;bonusmouse.ru&#38;" class="facebook">
					<img src="/im/fb.png" alt=""/>
				</a>
				<script src="http://stg.odnoklassniki.ru/share/odkl_share.js" type="text/javascript" ></script>
				<script type="text/javascript" >
					$(window).load(function(){ODKL.init();});
				</script>
				<!--<a target="_blank" title="���������� ����� �������������.ru" href="{domainName}i{id}" onclick="ODKL.Share(this);return false;" class="odkl-klass-oc">
					<img src="/im/odkl.png" alt=""/>
				</a>-->
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	</div>	
	</xsl:template> 
</xsl:stylesheet>

