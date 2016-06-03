var IsMobile = $('#IsMobile').text();
var moWidth = $(window).width()-20;
var moHeight = $(window).height()-60;
$(function (){
	// Auto Size
	var autoSize = function(){
		var height = $(window).height()-70
		// Change Height
		$(".ct_left,.ct_right").height(height);
		$(".web_iframe").height(height-5);
	}
	autoSize();
	$(window).resize(function(){autoSize();});
	// Menus
	$('.ct_left .left_title').click(function (){
		// alert($(this).next('ul').html());
		var p = $(this).next('ul');
		if(p.is(':hidden')){
			p.slideDown('fast');
		}else{
			p.slideUp('fast');
		}
	});
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

/* Form Valid Submit */
function formValidSub(obj) {
	// Loading
	$.webmis.inc({files:[
		$webmis_plugin + 'form/jquery.validate.min.js',
		$webmis_plugin + 'form/jquery.form.js'
	]});
	// Lang
	var lang = $('#getLang').text();
	if(lang=='zh-CN'){
		$.webmis.inc({files:[$webmis_plugin + 'form/jquery.validate.zh.js']});
	}
	// 校验
	if(obj==null){obj='#Form';}
	$(obj).validate({
		success: function(label) {
			label.html('<em class="suc"></em>').addClass("checked");
		},
		submitHandler: function(form){
			$(form).ajaxSubmit({
				dataType:'json', 
				success:function(data) {
					if(data.status=='y'){
						var url = $('#getUrl').text();
						$.webmis.win('open',{title:data.title,content:'<b class="green"><em></em>'+data.msg+'</b>',target:data.url+url,AutoClose:3,AutoCloseText:data.text});
					}else{
						$('#textVal').html('<span class="err"><em></em>'+data.msg+'</span>');
					}
				}
			});
		}
	});
}