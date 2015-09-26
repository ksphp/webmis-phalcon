$(function (){
	// Auto Size
	var autoSize = function(){
		var height = ($(window).height()-$('.in_body').height())/3;
		$('.in_body').css({'margin-top':height});
	}
	autoSize();
	$(window).resize(function(){autoSize();});
});