$(function (){
	$.webmis.inc({files:[$webmis_plugin+'form/Validform.min.js']});
/* Index */
	$('#listBG').webmis('TableOddColor');
/* Import */
	$('#ico-imp').click(function(){
		var id = $('#listBG').webmis('GetInputID');
		if(id){
			if(!IsMobile){moWidth = 450;}
			$.webmis.win('open',{title:$(this).text(),width:moWidth,height:200});
			$.post($base_url+'SysDBRestore/imp',{'file':id},function(data){
				$.webmis.win('load',data);
				impForm('SysDBBackup');
			});
		}else{noSelect();}
		return false;
	});
/* Del */
	$('#ico-del').click(function(){
		var id = $('#listBG').webmis('GetInputID',{type:'json'});
		if(id){
			$.webmis.win('open',{title:$(this).text(),width:280,height:160});
			$.post($base_url+'SysDBRestore/del',{'id':id},function(data){
				$.webmis.win('load',data);
				$('#Sub').webmis('SubClass');
				$('#DelID').val(id);
				impForm('SysDBRestore');
			});
		}else{noSelect();}
		return false;
	});
});
/* Form validation */
function impForm($url){
	$('#Sub').webmis('SubClass');
	// Validation
	$("#Form").Validform({ajaxPost:false,tiptype:2,
		callback:function(data){
			$.Hidemsg();
			if(data.status=="y"){
				$.webmis.win('close',$url);
			}else{
				$.webmis.win('close');
				$.webmis.win('open',{title:data.title,content:'<b class="red">'+data.msg+'</b>',AutoClose:3,AutoCloseText:data.text});
			}
		}
	});
}