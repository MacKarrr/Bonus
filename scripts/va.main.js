jQuery(function(){
	if ($('.bannslider.top li.bann').length > 1)
	{
		var bannClass = '.bannslider.top';
		var chTime = 7000;
		$('.bannslider.top').addClass('active');
		$('.bannslider.top li.bann:first').addClass('active').css({'opacity':1});
		$('.bannslider.top li.bann').each(function(){
			if(!$(this).hasClass('active'))
				$(this).addClass('hide').css({'opacity':0});
			else {
				Index = $(this).index();
			}
		})
		fChangeBann(Index, bannClass, chTime);
	}
	if ($('.bannslider.bottom li.bann').length > 1)
	{
		var bannClass = '.bannslider.bottom';
		var chTime = 5050;
		$('.bannslider.bottom').addClass('active');
		$('.bannslider.bottom li.bann:first').addClass('active').css({'opacity':1});
		$('.bannslider.bottom li.bann').each(function(){
			if(!$(this).hasClass('active'))
				$(this).addClass('hide').css({'opacity':0});
			else {
				Index = $(this).index();
			}
		})
		fChangeBann(Index, bannClass, chTime);
	}
	if ($('#citypics').length > 0)
	{
		$('.grid').each(function(){
			$(this).find('img:last').addClass('active').css({'opacity':1});
			$(this).find('img:not(:last)').addClass('hide').css({'opacity':0});
			Index = $(this).find('.active').index();
			fChangePics(this, Index);
		})
	}
	var html = $('.city_head #citylist').html();
	$('.city_head #citylist').html('').attr('id','');
	$('.city_head #cityName').attr('onclick','');
	$('#re_citylist').html(html).attr('id','citylist');
});
	
function fChangeBann(Index, bannClass, chTime)
{
	setInterval(
		function()
		{
			$(bannClass+' li.bann').eq(Index).animate({"opacity": 0},{queue:false,duration:1000}).addClass('hide').removeClass('active');
			if($(bannClass+' li.bann').eq(Index+1).length)
				Index = Index+1;
			else
				Index = 0;
			$(bannClass+' li.bann').eq(Index).removeClass('hide').addClass('active').animate({"opacity": 1},{queue:true,duration:1000});
		}
	,chTime);
}

function fChangePics(thiS, Index)
{
	setInterval(
		function()
		{
			rand1 = Math.floor(Math.random() * (500 - 300 + 1)) + 300;
			rand2 = Math.floor(Math.random() * (500 - 300 + 1)) + 300;
			$(thiS).find('img').eq(Index).animate({"opacity": 0},{queue:false,duration:rand1}).addClass('hide').removeClass('active');
			if($(thiS).find('img').eq(Index+1).length)
				Index = Index+1;
			else
				Index = 0;
			$(thiS).find('img').eq(Index).removeClass('hide').addClass('active').animate({"opacity": 1},{queue:true,duration:rand2});
		}
	, Math.random() * (7000 - 3000) + 3000);
}

function getBrowserInfo() {
    var t,v = undefined;
   
    if (window.chrome) t = 'Chrome';
    else if (window.opera) t = 'Opera';
    else if (document.all) {
        t = 'IE';
        var nv = navigator.appVersion;
        var s = nv.indexOf('MSIE')+5;
        v = nv.substring(s,s+1);
    }
    else if (navigator.appName) t = 'Netscape';   
    return {type:t,version:v};
}

function bookmark(a){
    var url = window.document.location;
    var title = window.document.title;
    var b = getBrowserInfo();
   
    if (b.type == 'IE' && 8 >= b.version && b.version >= 4) window.external.AddFavorite(url,title);
    else if (b.type == 'Opera') {
        a.href = url;
        a.rel = "sidebar";
        a.title = url+','+title;
        return true;
    }
    else if (b.type == "Netscape") window.sidebar.addPanel(title,url,"");
    else alert("Нажмите CTRL-D, чтобы добавить страницу в закладки.");
    return false;
}

function fRedir() {
	alert ($(this).attr('name'));
}
// CITY

function fCitySel(id) { location.href = '/city'+id+'/bonus.html';  }
function fCityList(type,ownerId) { $.post('/g_citylist.php',{ type: ''+type+'', ownerId: ''+ownerId+'' }, function(result) { $('#'+type).html(result); }); }
function fCityUpForm(id,name) {
	$('#cityformlist').toggle();
	$('#cityId').val(id);
	if (!name) name = $("#formcity select option[value="+id+"]").html();
	$('#cityformName').html('- '+name+' - <span></span>');
	$('#formregion select option[value=0]').attr('selected',true); 
	$('#formcity').html('<select name="city"> <option value="0">---</option> </select>');
 }
 
 
function ulShow(id) 
{
	var cHght = $('#content').attr("name");
	var cHghtTemp;
	var ulHght;
	var fHght;
	var pHght = $('.path').height()+16;
	
	if ($('#'+id).html()=='+')
	{
		cHghtTemp = $('#content').height();
		fHght = $("#ul-").height()+pHght;
		$('#'+id).html('–');
		$('#ul-'+id).show();
		$('#ul-'+id).removeClass('hide');
		ulHght = $('#ul-'+id).height();
		if ((fHght+ulHght) > cHghtTemp) $('#content').height(fHght+ulHght);
	}
	else
	{
		cHghtTemp = $('#content').height();
		fHght = $("#ul-").height()+pHght;
		ulHght = $('#ul-'+id).height();
		$('#'+id).html('+');
		$('#ul-'+id).hide();
		$('#ul-'+id).addClass('hide');
		var ccc = fHght-ulHght;
		if ((fHght-ulHght) > cHght) $('#content').height(cHghtTemp-ulHght);
		else $('#content').height(cHght);
	}
}

function fShowAuth() 
{
	var auth = $(".auth").html();
	var reg;
	$(".text").find(".reg").each(function(){
		reg = $(".text .reg").html();
	});
	
	var pageSize = fGetPageSize();
	var pageScrollY = (window.pageYOffset || document.documentElement.scrollTop  || document.body.scrollTop);
	
	$('.userer').css({'display':'none'});
	
	$("#lbox").html( '<div id="lboxBack" style="display:none;"></div><div id="lboxCont" style="position:absolute;display:none;width:100%;"><div id="lboxInner"><div class="bound"></div><div id="lboxInner2"></div></div></div>');
	$("#lboxBack").css({'position':'fixed', 'left':-500, 'top':-500, 'z-index':1000, 'width':pageSize[0]+1000, 'height':pageSize[1]+1000, 'background':'#999', 'filter':'progid:DXImageTransform.Microsoft.Alpha(opacity=70)', '-moz-opacity':0.7, '-khtml-opacity':0.7 ,'opacity':0.7});
	$("#lboxCont").css({'top':((pageSize[2]-250)/3+pageScrollY),'z-index':1001});		
	/* $("#lboxInner").css({'margin':'0 auto', 'width':646, 'min-height':220, 'background':'#FFF','border-radius':'20px', '-moz-border-radius':'20px', '-webkit-border-radius':'20px','box-shadow':'1px 1px 5px #000000','-moz-box-shadow':'1px 1px 5px #000000','-webkit-shadow':'1px 1px 5px #000000','filter':'progid:DXImageTransform.Microsoft.dropshadow(offX=5, offY=5, color=#000000)'}); */
	$('#lboxInner2').html('<div class="bonush"><span class="h2">Добро пожаловать в BonusMouse<div id="lboxClose"></div></span></div><div class="bonusi text"><div class="authl form"><div class="block"><div><div><div><div><span class="h2">Вход на сайт</span>'+auth+'<div class="clear"></div></div></div></div></div></div></div><div class="authl"><span class="h2">Я новый покупатель</span>Чтобы совершать покупки, Вам нужно зарегистрироваться. Это просто и займёт всего одну минуту.<div class="clear"></div><br/><a href="reg.html" class="bttn long">Зарегистрироваться</a></div><div class="clear"></div></div>');
	
	$('#lboxBack').show();
	$('#lboxCont').show();
	
	$('#lboxClose').click(function(){
		$('#lbox').html('');
	});
}

function fShowOffer() 
{
	var html = $('#buyblock').html();
	var pageSize = fGetPageSize();
	var pageScrollY = (window.pageYOffset || document.documentElement.scrollTop  || document.body.scrollTop);
	$('#buyblock').css({'display':'none'});

	$("#lbox").html('<div id="lboxBack" style="display:none;"></div><div id="lboxCont" style="position:absolute;display:none;width:100%;"><div id="lboxInner"><div class="bound"></div><div id="lboxInner2"></div></div></div>');
	$("#lboxBack").css({'position':'fixed', 'left':-500, 'top':-500, 'width':pageSize[0]+1000, 'height':pageSize[1]+1000});
	$("#lboxCont").css({'top':((pageSize[2]-250)/3+pageScrollY),'z-index':1001});		
	/* $("#lboxInner").css({'margin':'0 auto', 'width':660, 'min-height':220, 'background':'#FFF','border-radius':'20px', '-moz-border-radius':'20px', '-webkit-border-radius':'20px','box-shadow':'1px 1px 5px #000000','-moz-box-shadow':'1px 1px 5px #000000','-webkit-shadow':'1px 1px 5px #000000','filter':'progid:DXImageTransform.Microsoft.dropshadow(offX=5, offY=5, color=#000000)'}); */
	$('#lboxInner2').html('<div class="buyblock">'+html+'</div>');
	
	$('#lboxBack').show();
	$('#lboxCont').show();
	
	$('#lboxClose').click(function(){ 
		$('#lbox').html('');
	});
	
	$('.buyoffer span.a').click(function(){
		var id = $(this).attr('id')+'s';
		$('.buyoffer .buyofferc').each(function(){
			if ($(this).attr('id')!=id){
				$(this).hide();
			}
		});
		var id = $(this).attr('id');
		$('.buyoffer #'+id+'s').toggle();
	});
}

$(document).ready(function(){
	$('.comment .left div').each(function () {
		if ($(this).find('input')){
			if ($(this).find('input').attr('value')){
			$(this).find('label').css('display','none');
			} else if ($(this).find('textarea').val()){
			$(this).find('label').css('display','none');
			}
		}
	})

	$('.comment .left div').find('input').focus(function(){
		id = $(this).attr('id');
		$('label#l'+id).css('display','none');
	});

	$('.comment .left div').find('textarea').focus(function(){
		id = $(this).attr('id');
		$('label#l'+id).css('display','none');
	});

	$('.comment .left div').find('input').blur(function(){
		//alert(1);
		id = $(this).attr('id');
		if (!($(this).attr('value')))
		$('label#l'+id).css('display','block');
	});

	$('.comment .left div').find('textarea').blur(function(){
		id = $(this).attr('id');
		if (!($(this).attr('value')))
		$('label#l'+id).css('display','block');
	});
});

function fCountQuant (plus,payId)
{
	var value = parseInt($('input#quant').attr('value'));
	var price = parseInt($('#quantPrice').text());
	plus = parseInt(plus);
	
	if (!isNaN(value) && !isNaN(price) && !isNaN(plus))
	{
		value = value + plus;
		if (value < 1) value = 1;
		
		cost = Math.floor(price)*value;	
		$.post('g_pay.php',{ id: ""+payId+"", cnt: ""+value+"", cost: ""+cost+"" }, function(result) { if (result != 1) value = 1; });	

		$('form').each(function(){
			if($(this).attr('name') == 'pay')
				$(this).find('input').each(function() {
					if($(this).attr('name') == 'recipientAmount')
						$(this).attr('value',cost);
				})
		});
		
		$('input#quant').attr('value', value);
		$('#quantCost').text(cost);
	}
}

function fAddSumm ()
{
	var summ = parseInt($('input#addSumm').attr('value'));	
	if (!isNaN(summ))
	{
		if (summ < 1) summ = 1;
		$.post('g_balans.php',{ cost: ""+summ+"" }, function(result) 
		{ 
			if (result != 0)
			{
				$('form').each(function(){
				if($(this).attr('name') == 'pay')
					$(this).find('input').each(function() {
						if($(this).attr('name') == 'recipientAmount')
							$(this).attr('value',summ);
						if($(this).attr('name') == 'orderId')
							$(this).attr('value',result);
					})
				});
				$('#payment-type').show();
			}
		});	
	}
	else alert('Введите сумму!');
}

function addActive (dom)
{
	if($('#'+dom).hasClass('active')) $('#'+dom).removeClass('active')
	else $('#'+dom).addClass('active');
}

function fSendBonus(id,flag)
{
	
	if (flag==1) { obj = '#sendToFriend'+id; friendId = $('#toFriends'+id).val(); }
	else { obj = '#sendbonus'+id; friendId = 'SendSelf';}
	
	$(obj).removeClass('mail');
	$(obj).removeClass('a');
	$(obj).addClass('mailld');
	$(obj).html('Идет отправка!!');
	
	$.post('g_sendbonus.php',{ id: ""+id+"", friendId: ""+friendId+"" }, function(result) { 
	
		if (result == 1) 
		{
			$(obj).removeClass('mailld');
			$(obj).addClass('mail');		
			$(obj).html('Успешно отправлен!');
			$(obj).attr('onClick','');
			if (flag==1) $('#give-present'+id).fadeOut('fast');
		}
		else if (result == 0)
		{
			$(obj).removeClass('mailld');
			$(obj).addClass('mailer');		
			$(obj).html('Ошибка отправки!');
		}
		else if (result == 2)
		{
			$(obj).removeClass('mailld');
			$(obj).addClass('mailer');		
			$(obj).html('Ошибка отправки!');
		}
		else
		{
			$(obj).removeClass('mailld');
			$(obj).addClass('mailer');		
			$(obj).html(result);
		}
	});
}

function fPayFromBalans(payId)
{
	var value = parseInt($('input#quant').attr('value'));
	var price = parseInt($('#quantPrice').text());
	
	if (!isNaN(value) && !isNaN(price))
	{
		if (value < 1) value = 1;
		
		cost = Math.floor(price)*value;	
		$.post('g_payfrom.php',{ id: ""+payId+"", cnt: ""+value+"", cost: ""+cost+"" }, function(result) 
		{ 
			if (result==5) 
				location.href = '/mybonuses.html';
			else if (result==2) 
			{
				$('#er2').html('Внимание. Недостаточно средств на балансе для оплаты купона. <a href="/myprofile.html">Пополнить баланс</a>.');
				$('#er2').show();
			}
			else
			{
				$('#er2').html('Ошибка оплаты №2. Попробуйте повторить попытку.<br> В случае, если вы не можете решить проблему самостоятельно <a href="/backlink.html">напишите о ней нам</a>.');
				$('#er2').show();
			}
		});	
		
	}
}

