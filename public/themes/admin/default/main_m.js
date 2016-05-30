var IsMobile;
var moWidth;
var moHeight;
$(function (){
	$.webmis.inc({files:[$webmis_plugin+'jquery/jquery.touchSwipe.min.js']});
	navMove();
	menuShow();
	// All or Not all
	$('#checkboxY').click(function () {
		$(this).hide();
		$(this).parent().parent().parent().parent().find("input:checkbox").prop("checked", true);
		$('#checkboxN').show().click(function () {
			$(this).hide();
			$('#checkboxY').show();
			$(this).parent().parent().parent().parent().find("input:checkbox").prop("checked", false);
			return false;
		});
		return false;
	});
});

// No Select
function noSelect(){
	$.get($base_url+'Result/getLang/msg',{msg_title:'',msg_select:'',msg_auto_close:''},function (data){
		$.webmis.win('open',{title:data.msg_title, content:'<b class="red">'+data.msg_select+'</b>',AutoClose:3,AutoCloseText:data.msg_auto_close});
	},'json');
}

// Slide Nav
function navMove(){
	$("#Nav .an1").css({'color':'#FFF'});
	// Equal width
	var W = $(window).width();
	var N = 2;
	if(W >= 320){N = 5;}
	if(W >= 420){N = 6;}
	if(W >= 520){N = 7;}
	if(W >= 620){N = 8;}
	if(W >= 720){N = 9;}
	if(W >= 820){N = 10;}
	$("#Nav li").width(W/N-1);
	// Li width
	var li = $("#Nav li").length;
	var li_w = (W/N-1)*li;
	// Sliding Around
	$('#Nav').swipe({
		swipeLeft: function() {
			var W = $(window).width();
			var left = $('#Nav').css('left');
			if(left=='auto'){left=0;}else{left = parseInt(left);}
			//限制
			if(-left+W < li_w){left = left-W;}
			$('#Nav').animate({'left':left});
		},
		swipeRight: function() {
			var W = $(window).width();
			var left = $('#Nav').css('left');
			if(left=='auto'){left=0;}else{left = parseInt(left);}
			//限制
			if(left+W <= 0){left = left+W;}
			$('#Nav').animate({'left':left});
		},
		threshold:30
	});
}
function menuShow(){
	var W = $(window).width();
	var H = $(window).height();
	//初始化
	IsMobile = $('#IsMobile').text();
	moWidth = W-20;
	moHeight = H-20;
	$('.web_iframe').height(H-102);
	//点击滑动
	var Menu = $('.menu_ct');
	$('.left_menu').click(function (){
		$(this).hide();
		var W = $(window).width();
		Menu.css({'left':0-W}).show().animate({'left':0});
	});
//	//右滑动
//	$("#ctBody").swipe({
//		swipeRight: function() {
//			var W = $(window).width();
//			Menu.css({'left':0-W}).show().animate({'left':0});
//		},
//		min_move_x: 60,
//		preventDefaultEvents: false
//	});
	//左滑动
	Menu.swipe({
		swipeLeft: function() {
			var W = $(window).width();
			Menu.animate({'left':0-W},function(){
				$(this).hide();
				$('.left_menu').show();
			});
		},
		min_move_x: 60,
		preventDefaultEvents: false
	});
}