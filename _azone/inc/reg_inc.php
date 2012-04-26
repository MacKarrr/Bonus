<?
	$html = '';

	if (isset($_POST['cityId']) && (int)$_POST['cityId']) $cityId = $_POST['cityId'];
	else $cityId = 0;
	
	list($html,$flag) = $cUsers->fReg();
	if ($flag) return fXmlTransform('<ok><![CDATA['.$html.']]></ok>','formblock');	
	else 
	{
		if ($html!='') $html = '<div class="ok_er"><div class="error">'.$html.'</div></div>';
		return '<span class="h2"><strong class="red">BonusMouse</strong> - это кафе, кино, spa со скидками от 50% до 90%. Каждый день новое предложение. Присоединяйтесь!</span> <span class="h3">Введите адрес электронной почты</span> <form action="" method="post"> '.$html.' <div class="reg"><label for="emailReg">E-mail:</label><input type="text" autocomplete="off" value="" name="email" id="emailReg"></div> <div class="reg"><label>Город:</label> '.fXmlTransform($cCity->fDisplayList($cityId,'form'),'city').'</div> <div class="reg"><input type="submit" value="зарегистрироваться" class="bttn long" name="regsend"/></div> <div class="clear"></div> </form>
			<div id="login_button" onclick="VK.Auth.login(authInfo);"></div>
			<script language="javascript">
				function authInfo(response) {
					if (response.session) {
						alert (1);
					} else {
						alert (2);
					}
				}
				VK.UI.button("login_button");
			</script>
		<p> <span class="h3">Уже зарегистрировались?</span> </p> <ul class="liarrow"> <li>Вы можете отписаться от рассылки в любое время, через ссылку в письме</li> <li>Мы никогда не предоставим вашу электронную почту третьим лицам</li> </ul> <p>Фактом регистрации на сайте вы соглашаетесь с <a href="'.$cDB->domainName.'oferta.html">условиями публичной оферты</a></p>';	
	}
?>