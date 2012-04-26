$(document).ready(function(){
	$('.bonusmark li').click(function() {
		if (!$(this).hasClass('active')){
			id = $(this).attr('id');
			$('.bonusmark li').each(function(){
				idtemp = $(this).attr('id');
				$(this).removeClass('active');
				$('.bonusmarkc div#'+idtemp+'d').removeClass('active');
			})
			$(this).addClass('active');
			$('.bonusmarkc div#'+id+'d').addClass('active');
		}
	});
});