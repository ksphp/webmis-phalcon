$(function(){
	// Version
	$('#webmisVersion').webmisVersion();
	// Auto Size
	var autoSize = function(){
		var height = ($(window).height()-$('#webmisVersion').height()-$('.login_body').height()-$('.login_copy').height())/3;
		$('#webmisVersion').css({'margin-top':height});
	}
	autoSize();
	$(window).resize(function(){autoSize();});
});