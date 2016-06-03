$(function (){
/* Index */
	$('#listBG').webmis('TableOddColor');
/* Import */
	$('#ico-imp').click(function(){
		var id = $('#listBG').webmis('GetInputID');
		if(id){
			if(!IsMobile){moWidth = 450;}
			$.webmis.win('open',{title:$(this).text(),width:moWidth,height:240});
			$.post($base_url+'SysDBRestore/imp',{'file':id},function(data){
				$.webmis.win('load',data);
				impForm();
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
				impForm();
			});
		}else{noSelect();}
		return false;
	});
});
/* Form validation */
function impForm(){
	$('#Sub').webmis('SubClass');
	formValidSub();
}