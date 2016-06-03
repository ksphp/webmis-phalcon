$(function (){
/* Index */
	$('#listBG').webmis('TableOddColor');
/* Search */
	$('#ico-search').click(function(){
		if(!IsMobile){moWidth = 420;}
		$.webmis.win('open',{title:$(this).text(),width:moWidth,height:320});
		// Content
		var url = $('#getUrl').text();
		$.get($base_url+'LogAdminLogin/sea'+url,function(data){
			$.webmis.win('load',data);
			$('#seaSub').webmis('SubClass');
		});
		return false;
	});
/* Del */
	$('#ico-del').click(function(){
		var id = $('#listBG').webmis('GetInputID',{type:'json'});
		if(id){
			$.webmis.win('open',{title:$(this).text(),width:280,height:160});
			$.post($base_url+'LogAdminLogin/del',{'id':id},function(data){
				$.webmis.win('load',data);
				$('#Sub').webmis('SubClass');
				$('#DelID').val(id);
				logForm();
			});
		}else{noSelect();}
		return false;
	});
});

/* Form validation */
function logForm(){
	$('#Sub').webmis('SubClass');
	formValidSub();
}