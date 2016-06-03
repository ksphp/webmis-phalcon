$(function (){
/* Index */
	$('#listBG').webmis('TableOddColor');
/* Search */
	$('#ico-search').click(function(){
		if(!IsMobile){moWidth = 360;}
		$.webmis.win('open',{title:$(this).text(),width:moWidth,height:240});
		// Content
		var url = $('#getUrl').text();
		$.get($base_url+'SysMenusAction/sea'+url,function(data){
			$.webmis.win('load',data);
			$('#seaSub').webmis('SubClass');
		});
		return false;
	});
/* Add */
	$('#ico-add').click(function(){
		if(!IsMobile){moWidth = 450;}
		$.webmis.win('open',{title:$(this).text(),width:moWidth,height:300});
		// Content
		$.get($base_url+'SysMenusAction/add',function(data){
			$.webmis.win('load',data);
			menusForm();
		});
		return false;
	});
/* Edit */
	$('#ico-edit').click(function(){
		var id = $('#listBG').webmis('GetInputID');
		if(id){
			if(!IsMobile){moWidth = 450;}
			$.webmis.win('open',{title:$(this).text(),width:moWidth,height:300});
			// Content
			$.post($base_url+'SysMenusAction/edit',{'id':id},function(data){
				$.webmis.win('load',data);
				menusForm();
			});
		}else{noSelect();}
		return false;
	});
/* Del */
	$('#ico-del').click(function(){
		var id = $('#listBG').webmis('GetInputID',{type:'json'});
		if(id){
			$.webmis.win('open',{title:$(this).text(),width:280,height:160});
			$.post($base_url+'SysMenusAction/del',{'id':id},function(data){
				$.webmis.win('load',data);
				$('#Sub').webmis('SubClass');
				$('#DelID').val(id);
				menusForm();
			});
		}else{noSelect();}
		return false;
	});
});

/* Form validation */
function menusForm(){
	$('#Sub').webmis('SubClass');
	formValidSub();
}