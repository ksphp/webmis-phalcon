$(function(){
	// Version
	$('#webmisVersion').webmisVersion();
	// Lang
	$('#Lang').hover(function(){$(this).find('ul').show();},function(){$(this).find('ul').hide();});
	// Auto Size
	var autoSize = function(){
		var height = ($(window).height()-318)/2;
		$('#webmisVersion').css({'margin-top':height});
	}
	autoSize();
	$(window).resize(function(){autoSize();});
	
	// Login
	var login = function(){
		var uname = $('#uname').val();
		var passwd = $('#passwd').val();
		var is_mobile = $('#is_mobile').text();
		if(uname.length < 1 || passwd.length < 1){
			$.webmis.win('open',{content:'<b class="red">帐号或密码为空！</b>',AutoClose:3});
			return false;
		}else{
			$.post($base_url+'index/login',{'uname':uname,'passwd':passwd,'is_mobile':is_mobile},function(data){
				if(data.status == 'y'){
					$.webmis.win('close','Welcome');
				}else{
					$.webmis.win('open',{content:'<b class="red">'+data.msg+'</b>',AutoClose:3});
				}
				return false;
			},"json");
		}
		return false;
	}
	// Enter Login
	$(document).keypress(function(e){if(e.which == 13){login();}});
	// Click Login
	$('#adminLogin').click(login);
});