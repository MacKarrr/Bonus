jQuery(function(){
	$('img[rel^=lbox]').click(function(){
		
		var pageSize = fGetPageSize();		
		var pageScrollX = (window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft);
		var pageScrollY = (window.pageYOffset || document.documentElement.scrollTop  || document.body.scrollTop);
		var countImg = $('img[rel^=lbox]').length;
		var itemIndex = $('img[rel^=lbox]').index(this)+1;
		var srcImg = $(this).attr('name');
		var altImg = $(this).attr('alt');
		if (countImg>1) {
			tdComment = 'Вперед';
			buttons = '<img id="lboxPrev" src="/im/lboxprev.png" alt="Назад" title="Назад" style="cursor:pointer;margin:0;"/><img id="lboxNext" src="/im/lboxnext.png" alt="Вперед" title="Вперед" style="cursor:pointer;margin:0 0 0 5px;"/>';
		} else {
			tdComment = 'Закрыть';
			buttons = '';
		}
		
		
$('#lbox').html('<div id="lboxBack" style="display:none"></div><div id="lboxCont" style="display:none"></div>');
$('#lboxBack').css({'position':'absolute', 'left':0, 'top':0, 'z-index':1000, 'width':pageSize[0], 'height':pageSize[1], 'background':'#999', 'filter':'progid:DXImageTransform.Microsoft.Alpha(opacity=70)', '-moz-opacity':0.7, '-khtml-opacity':0.7 ,'opacity':0.7});
$('#lboxCont').css({'position':'absolute','left':((pageSize[0]-660)/2+pageScrollX), 'top':((pageSize[2]-550)/4+pageScrollY),'z-index':1001, 'width':646, 'height':536, 'background':'#FFF','padding':10});		
$('#lboxCont').html('<table style="border:1px solid #CCC;" width="646" height="486"> <tr> <td valign="middle" align="center" style="padding:3px;cursor:pointer;" id="tdImage" title="'+tdComment+'"> <img id="srcImg" style="margin:0;max-width:640px;max-height:480px;" src="'+srcImg+'" /></td> </tr> </table><div style="width:120px;float:right;text-align:right;padding:12px 7px 0 0;">'+buttons+'<img id="lboxClose" style="cursor:pointer;margin:0 0 0 15px;" alt="Закрыть" title="Закрыть" src="/im/lboxclose.png"/></div><div style="float:left;padding:15px 0 0;width:510px;overflow:hidden;white-space:nowrap;"><span style="color:#606060;font:10px Verdana;"><strong id="altImg">'+altImg+'</strong><br/>Изображение <span id="itemIndex">'+itemIndex+'</span> из '+countImg+'</span></div>');
		$('#lboxBack').show();
		$('#lboxCont').show();
		
		if (countImg>1){
			$('#tdImage').click(function(){
				if (itemIndex < countImg) itemIndex = ++itemIndex;
				else if (itemIndex = countImg) itemIndex = 1;
				$('#itemIndex').text(itemIndex);
				
				altImg = $('img[rel^=lbox]').eq(itemIndex-1).attr('alt');
				$('#altImg').text(altImg);
				
				srcImg = $('img[rel^=lbox]').eq(itemIndex-1).attr('name');
				$('#srcImg').attr({'src':srcImg});
			});
		} else {
			$('#tdImage').click(function(){ 
				$('#lbox').html('');
			});
		}
		
		
		$('#lboxNext').click(function(){
			if (itemIndex < countImg) itemIndex = ++itemIndex;
			else if (itemIndex = countImg) itemIndex = 1;
			$('#itemIndex').text(itemIndex);
			
			altImg = $('img[rel^=lbox]').eq(itemIndex-1).attr('alt');
			$('#altImg').text(altImg);
			
			srcImg = $('img[rel^=lbox]').eq(itemIndex-1).attr('name');
			$('#srcImg').attr({'src':srcImg});
		});
		
		$('#lboxPrev').click(function(){
			if (itemIndex <= countImg && itemIndex > 1) {itemIndex = --itemIndex;}
			else {itemIndex = countImg;}
			$('#itemIndex').text(itemIndex);
			altImg = $('img[rel^=lbox]').eq(itemIndex-1).attr('alt');
			$('#altImg').text(altImg);
			srcImg = $('img[rel^=lbox]').eq(itemIndex-1).attr('name');
			$('#srcImg').attr({'src':srcImg});
		});
		
		$('#lboxBack').click(function(){ 
			$('#lbox').html('');
		});
		
		$('#lboxClose').click(function(){ 
			$('#lbox').html('');
		});
	});
});

function fGetPageSize() 
{
	var xScroll, yScroll;
	
	if (window.innerHeight && window.scrollMaxY) {	
		xScroll = window.innerWidth + window.scrollMaxX;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
	
	var windowWidth, windowHeight;
	
	if (self.innerHeight) {	// all except Explorer
		if(document.documentElement.clientWidth){
			windowWidth = document.documentElement.clientWidth; 
		} else {
			windowWidth = self.innerWidth;
		}
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}	

	// for small pages with total height less then height of the viewport
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	} else { 
		pageHeight = yScroll;
	}

	// for small pages with total width less then width of the viewport
	if(xScroll < windowWidth){	
		pageWidth = xScroll;		
	} else {
		pageWidth = windowWidth;
	}

	return [pageWidth,pageHeight,windowHeight];
}
