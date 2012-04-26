$(document).ready(function(){
	$(".accord .dsc").hide();
	$('.accord .h2.active').next(".dsc").show();
		
	$(".accord .h2").click(function(){
		if ($(this).next(".dsc").hasClass('active')){
		$(this).next(".dsc").hide(0);
		$(this).removeClass("active");
		$(this).next(".dsc").removeClass("active");
		}
		else {
		$(this).next(".dsc").show(0);
		$(this).next(".dsc").addClass("active");
		$(this).addClass("active");
		}
	});
});