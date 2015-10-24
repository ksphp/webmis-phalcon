$(function(){
	$.webmis.inc({files:[$webmis_plugin+'form/Validform.min.js']});
	$('#Sub').webmis('SubClass');
	// ValidForm
	$("#Form").Validform({ajaxPost:true,tiptype:2,
		callback:function(data){
			$.Hidemsg();
			if(data.status=="y"){
				$.webmis.win('close',data.url);
			}else{
				$.webmis.win('close');
				$.webmis.win('open',{title:data.title,content:'<b class="red">'+data.msg+'</b>',AutoClose:3,AutoCloseText:data.text});
			}
		}
	});
});