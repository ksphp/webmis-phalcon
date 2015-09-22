$(function (){
	$.webmis.inc({files:[$webmis_plugin+'form/Validform.min.js']});
/* Index */
	$('#listBG').webmis('TableOddColor');
/* Export */
	$('#ico-exp').click(function(){
		var id = $('#listBG').webmis('GetInputID',{type:'json'});
		if(id){
			if(!IsMobile){moWidth = 580; moHeight= 420;}
			$.webmis.win('open',{title:$(this).text(),width:moWidth,height:moHeight,overflow:true});
			$.post($base_url+'SysDBBackup/exp',{'table':id},function(data){
				$.webmis.win('load',data);
				expForm();
			});
		}else{noSelect();}
		return false;
	});
/* Del */
	$('#ico-del').click(function(){
		var id = $('#listBG').webmis('GetInputID',{type:'json'});
		if(id){
			$.webmis.win('open',{title:$(this).text(),width:280,height:160});
			$.post($base_url+'SysDBBackup/del',{'id':id},function(data){
				$.webmis.win('load',data);
				$('#Sub').webmis('SubClass');
				$('#DelID').val(id);
				expForm();
			});
		}else{noSelect();}
		return false;
	});
});
/* Form validation */
function expForm(){
	$('#Sub').webmis('SubClass');
	// Validation
	$("#Form").Validform({ajaxPost:true,tiptype:2,
		callback:function(data){
			$.Hidemsg();
			if(data.status=="y"){
				$.webmis.win('close','SysDBRestore');
			}else{
				$.webmis.win('close');
				$.webmis.win('open',{title:data.title,content:'<b class="red">'+data.msg+'</b>',AutoClose:3,AutoCloseText:data.text});
			}
		}
	});
}